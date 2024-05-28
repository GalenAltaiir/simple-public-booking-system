<?php
// API route definitions
use App\Controller\AppointmentController;

$r->addRoute('GET', '/appointments', [AppointmentController::class, 'index']);
$r->addRoute('GET', '/available-times', [AppointmentController::class, 'getAvailableTimes']);
$r->addRoute('POST', '/create-appointment', [AppointmentController::class, 'create']);