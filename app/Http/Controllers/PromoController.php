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
       
        session()->forget('flash_notification');
        
        $message = new Message;
        $message->name = $request['name'];
        $message->email = $request['email'];
        $message->message= $request['message'];
        if($message->save())
            
            return redirect()->back()->with('success', 'Дякую! Ваше повідомлення надіслано!');
        else
            
            return redirect()->back()->with('error', 'Помилка! Повідомлення не надіслано!');


        return back();
    }

}
