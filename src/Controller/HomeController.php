<?php

namespace App\Controller;

use App\Helpers;
use App\Manager\AppointmentManager;

class HomeController{
    public static function show(){
        Helpers::view('home');
    }
}