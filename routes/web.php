<?php

declare(strict_types=1);

use App\Controllers\HealthController;
use App\Controllers\LandingController;
use App\Controllers\LeadController;
use App\Support\Router;

$router = new Router();

// Landing page
$router->get('/', [LandingController::class, 'index']);

// API: Leads
$router->post('/api/leads', [LeadController::class, 'store']);
$router->get('/api/leads',  [LeadController::class, 'index']);

// API: Health
$router->get('/api/health', [HealthController::class, 'index']);

$router->dispatch();
