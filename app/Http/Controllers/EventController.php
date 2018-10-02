<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Event;
use App\Events\OrderPayment;

class EventController extends Controller
{
    public function testEvent()
    {
        var_dump(2222);
        event(new OrderPayment());
        var_dump(3333);
        dd(33);
    }
}
