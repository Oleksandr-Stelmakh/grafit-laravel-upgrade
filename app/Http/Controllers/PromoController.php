<?php

namespace Grafit\Http\Controllers;

use Illuminate\Http\Request;
use Grafit\Message;
use Excel;

class PromoController extends Controller
{
    //
    public function index()
    {
        //
        return view("Promo");
    }

    public function sendMessage(Request $request)
    {
        //  dd('Я тут!');
        session()->forget('flash_notification');
        
        $message = new Message;
        $message->name = $request['name'];
        $message->email = $request['email'];
        $message->message= $request['message'];
        if($message->save())
            // flash()->overlay('Ваше сообщение отправлено!', 'Спасибо!');
            // flash('Спасибо! Ваше сообщение отправлено!')->success();
            return redirect()->back()->with('success', 'Спасибо! Ваше сообщение отправлено!');
        else
            // flash('Ошибка! Сообщение не отправлено!')->error()->important();
            return redirect()->back()->with('error', 'Ошибка! Сообщение не отправлено!');


        return back();
    }

}
