<?php
use App\Controller\AppointmentController;
use App\Controller\HomeController as HomeController;

    $r->addRoute('GET', '/', [HomeController::class, 'show']);
