<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;


Route::post('/tickets', [TicketController::class, 'store']);
Route::delete('/tickets/{id}', [TicketController::class, 'destroy']);
Route::get('/tickets', [TicketController::class, 'index']);
Route::put('/tickets/{id}/seat', [TicketController::class, 'update']);
Route::post('/tickets/reset', [TicketController::class, 'reset']);