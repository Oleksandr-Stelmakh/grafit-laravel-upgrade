<?php

namespace Grafit;

use Illuminate\Database\Eloquent\Model;

class ProdType extends Model
{
    protected $table = "spr_prod_types";

    public $timestamps = false;

    /**
     * Получаем класс иконки Bootstrap Icons
     */
    public function getIconClassAttribute()
    {
        $icon = $this->icon ?? '';

        $map = [
            // 📄 Документы / списки
            'glyphicon-list-alt' => 'bi-card-list',
            'glyphicon-book' => 'bi-book',
            'glyphicon-picture' => 'bi-image',
        ];

        return $map[$icon] ?? null;
    }
}