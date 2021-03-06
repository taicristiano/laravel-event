<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Jobs\SendWelcomeEmail;

class QueueController extends Controller
{
    public function testQueue()
    {
        $user = User::find(1);
        var_dump(22);
        $job = (new SendWelcomeEmail($user));
        // command php artisan queue:work
        dispatch($job);
        dd(333);
    }
}
