<?php

namespace Grafit\Services;

use Grafit\ProdType;
use Grafit\Format;
use Grafit\PaperType;
use Grafit\CoverType;
use Grafit\PriceDoc;

class PriceManager
{
    public $last_error;

    public $prod_type;

    public $paper_type;

    public $format;

    public $numering;

    public $num_sheets;

    public $stitch;

    public $cover_type;

    public $num;

    //
    public $name;

    public $params;

    public $full_name;

    //
    public $priceDoc;

    //
    public $full_price;

    public $price;

    public $materials;

    public $operations;

    /***************************/
    public function setParamsForm($arr)
    {
        $this->last_error = "";
        $this->prod_type = ProdType::find((int)config('app.id_prod_type_form'));
        $this->paper_type = PaperType::find((int)$arr['paper_type']);
        $this->format = Format::find((int)$arr['format']);
        $this->numering = (int)$arr['numering'];
        $this->num = (int)$arr['num'];

        // name, fullname, params
        $this->name = "Бланк";
        $this->params = $this->format->name;
        $this->params .= $this->numering ? ($this->params ? ", " : "") . "з нумерацією" : "";
        $this->full_name = $this->name . " (" . $this->params . "), " . $this->paper_type->name;

        return $this->full_name;
    }

    /***************************/
    public function setParamsJournal($arr)
    {
        $this->last_error = "";
        $this->prod_type = ProdType::find((int)config('app.id_prod_type_journal'));
        $this->paper_type = PaperType::find((int)$arr['paper_type']);
        $this->format = Format::find((int)$arr['format']);
        $this->num_sheets = (int)$arr['num_sheets'];
        $this->stitch = (int)$arr['stitch'];
        $this->numering = (int)$arr['numering'];
        $this->cover_type = CoverType::find((int)$arr['cover_type']);
        $this->num = (int)$arr['num'];

        // name, fullname, params
        $this->name = "Журнал";
        $this->params = ($this->format->numA4==1 ? "":$this->format->name);
        $this->params .= ($this->params ? ", " : "") . $this->num_sheets . "л";
        $this->params .= $this->stitch ? ($this->params ? ", " : "") . "прошитий" : "";
        $this->params .= $this->numering ? ($this->params ? ", " : "") . "з нумерацією" : "";
        $this->params .= $this->cover_type->id==config("app.default_id_cover_type") ? "" : ($this->params ? ", " : "") . $this->cover_type->name . " обл.";
        $this->full_name = $this->name . " (" . $this->params . "), " . $this->paper_type->name;

        return $this->full_name;
    }

    /***************************/
    public function SetParamsProduction($arr)
    {
        if ($arr['prod_type'] == config('app.id_prod_type_form'))
            return $this->setParamsForm($arr);
        elseif ($arr['prod_type'] == config('app.id_prod_type_journal'))
            return $this->setParamsJournal($arr);
        else {
            $this->last_error = "Непередбачений вид продукції";
            return "";
        }
    }

    /***************************/
    private function setPriceDoc()
    {
        $this->priceDoc = PriceDoc::orderBy('date_doc', 'desc')->first();
        if(is_null($this->priceDoc)) {
            $this->last_error = "Не знайден актуальний прайс";
            return null;
        }

        return $this->priceDoc;
    }

    /***************************/
    private function addPriceMaterial($caption, $price_value){
        if($price_value == 0)
            return true;

        $this->materials += array($caption => $price_value);
        return true;
    }

    /***************************/
    private function addPriceOperation($caption, $price_value){
        if($price_value == 0)
            return true;

        $this->operations += array($caption => $price_value);
        return true;
    }

    /***************************/
    public function calculateForm($arr)
    {
        $this->discount = (int)$arr['discount'];
        $this->setPriceDoc();

        $this->materials = [];
        $this->operations = [];
        $this->price = 0;
        $this->full_price = 0;

        // проверка на минимальный тираж
        if($this->num == 0) {
            $this->last_error = "Не заданий тираж";
            return 0;

        } elseif($this->format->numA3 > 0){
            if($this->num < config('app.forms_min_circulationA3')/$this->format->numA3){
                $this->last_error = "Неприпустимий тираж (мінімальний - " . (config('app.forms_min_circulationA3')/$this->format->numA3) . " " . $this->format->name . ")";
                return 0;
            }

        } elseif($this->format->numA4 > 0){
            if($this->num < config('app.forms_min_circulationA4')/$this->format->numA4) {
                $this->last_error = "Неприпустимий тираж (мінімальний - " . (config('app.forms_min_circulationA4') / $this->format->numA4) . " " . $this->format->name . ")";
                return 0;
            }
        }

        $this->addPriceMaterial('Папір А3', $this->priceDoc->getPriceMaterial($this->paper_type->id)*$this->format['numA3']*2);
        $this->addPriceMaterial('Папір А4', $this->priceDoc->getPriceMaterial($this->paper_type->id)*$this->format['numA4']);

        $this->addPriceOperation('Тиражування А3', $this->priceDoc->getPriceOperation(config('app.id_operation_replicationA3'), $this->num*min($this->format->numA3,1))*$this->format->numA3*$this->format->numSides);
        $this->addPriceOperation('Тиражування А4', $this->priceDoc->getPriceOperation(config('app.id_operation_replicationA4'), $this->num*min($this->format['numA4'],1))*$this->format->numA4*$this->format->numSides);
        $this->addPriceOperation('Порізка', $this->priceDoc->getPriceOperation(config('app.id_operation_cutting_perform'), 1)*$this->format->coefCut);

        if ($this->numering){
            if ($this->format->numA3 > 0) {
                $this->last_error = "Нумерація для формата А3 не передбачена";
                return 0;
            }
            $this->addPriceOperation('Нумерація', $this->priceDoc->getPriceOperation(config('app.id_operation_numering'), 1)*$this->format->numA4);
        }

        // суммирование статей и сбивание лога
        foreach($this->materials as $caption => $price)
            $this->full_price += $price;

        foreach($this->operations as $caption => $price)
            $this->full_price += $price;

        // скидка и округление
        $this->full_price = round($this->full_price, 3);
        $this->price = round($this->full_price*(100-$this->discount)/100, 3);

        if ($this->last_error)
            return 0;
        else
            return $this->price;
    }

    /***************************/
    public function calculateJournal($arr)
    {

        $this->discount = (int)$arr['discount'];
        $this->setPriceDoc();

        $this->materials = [];
        $this->operations = [];
        $this->price = 0;
        $this->full_price = 0;

        // проверка на минимальный тираж
        if($this->num == 0) {
            $this->last_error = "Не заданий тираж";
            return 0;
        }

        // обложка
        if($this->cover_type->hardCover){
            $this->addPriceOperation('Тверда обкладинка А3 (обкладинка)', $this->priceDoc->getPriceOperation(config('app.id_operation_hard_cover'), 1)*$this->format->numA3*1.3);
            $this->addPriceOperation('Твердий переплет А4 (обкладинка)', $this->priceDoc->getPriceOperation(config('app.id_operation_hard_cover'), 1)*$this->format->numA4);
            $this->addPriceOperation('Тиражування А3 (обкладинка)', $this->priceDoc->getPriceOperation(config('app.id_operation_replicationA3'), $this->num*min($this->format->numA3,1))*$this->format->numA3);
            $this->addPriceOperation('Тиражування А4 (обкладинка)', $this->priceDoc->getPriceOperation(config('app.id_operation_replicationA4'), $this->num*min($this->format->numA4,1))*$this->format->numA4);
        } else{
            $this->addPriceMaterial('Папір А3 (обкладинка)', $this->priceDoc->getPriceMaterial($this->cover_type->id_paper_type)*2*$this->format->numA3*2);
            $this->addPriceMaterial('Папір А4 (обкладинка)', $this->priceDoc->getPriceMaterial($this->cover_type->id_paper_type)*$this->format->numA4*2);
            $this->addPriceOperation('Тиражування А3 (обкладинка)', $this->priceDoc->getPriceOperation(config('app.id_operation_replicationA3'), $this->num*min($this->format->numA3,1))*$this->format->numA3);
            $this->addPriceOperation('Тиражування А4 (обкладинка)', $this->priceDoc->getPriceOperation(config('app.id_operation_replicationA4'), $this->num*min($this->format->numA4,1))*$this->format->numA4);
            $this->addPriceOperation('Обклеювання торця', $this->priceDoc->getPriceOperation(config('app.id_operation_endface_gluing'), 1));
        }

        if($this->cover_type->laminate){
            $this->addPriceOperation('Ламінація А3 (обкладинка)', $this->priceDoc->getPriceOperation(config('app.id_operation_lamination'), 1)*$this->format->numA3*4);
            $this->addPriceOperation('Ламінація А4 (обкладинка)', $this->priceDoc->getPriceOperation(config('app.id_operation_lamination'), 1)*$this->format->numA4*2);
        }

        // тело
        $this->addPriceMaterial('Папір А3 (тіло)', $this->priceDoc->getPriceMaterial($this->paper_type->id)*2*$this->format->numA3*$this->num_sheets);
        $this->addPriceMaterial('Папір А4 (тіло)', $this->priceDoc->getPriceMaterial($this->paper_type->id)*$this->format->numA4*$this->num_sheets);
        $this->addPriceOperation('Тиражування А3 (тіло)', $this->priceDoc->getPriceOperation(config('app.id_operation_replicationA3'), $this->num*$this->num_sheets*min($this->format->numA3,1)*$this->format->numSides)*$this->format->numA3*$this->num_sheets*$this->format->numSides);
        $this->addPriceOperation('Тиражування А4 (тіло)', $this->priceDoc->getPriceOperation(config('app.id_operation_replicationA4'), $this->num*$this->num_sheets*min($this->format->numA4,1)*$this->format->numSides)*$this->format->numA4*$this->num_sheets*$this->format->numSides);

        // прочие работы
        $this->addPriceOperation('Шиття скобами', $this->priceDoc->getPriceOperation(config('app.id_operation_staplering'), 1)*2);
        $this->addPriceOperation('Порізка', $this->priceDoc->getPriceOperation(config('app.id_operation_cutting'), 1));

        if($this->stitch){
            $this->addPriceOperation('Прошивка ниткою', $this->priceDoc->getPriceOperation(config('app.id_operation_stitching'), 1));
        }

        if($this->numering){
            if ($this->format->numA3 >0) {
                $this->last_error = "Нумерація для формату А3 не передбачена";
                return 0;
            }
            $this->addPriceOperation('Нумерація листів', $this->priceDoc->getPriceOperation(config('app.id_operation_numering'), 1)*$this->num_sheets*$this->format->numA4);
        }

        // суммирование статей и сбивание лога
        foreach($this->materials as $caption => $price)
            $this->full_price += $price;

        foreach($this->operations as $caption => $price)
            $this->full_price += $price;

        // скидка и округление
        $this->full_price = round($this->full_price, 1);
        $this->price = round($this->full_price*(100-$this->discount)/100, 1);

        if ($this->last_error)
            return 0;
        else
            return $this->price;

    }

    /***************************/
    public function calculateProduction($arr)
    {
        if ($this->prod_type->id == config('app.id_prod_type_form'))
            return $this->CalculateForm($arr);
        elseif ($this->prod_type->id == config('app.id_prod_type_journal'))
            return $this->CalculateJournal($arr);
        else
            $this->last_error = "Для зазначеного виду продукції не вказано алгоритму розрахунку ціни";
    }

    /***************************/
    public function fail()
    {
        if($this->last_error)
            return true;
        else
            return false;
    }

}