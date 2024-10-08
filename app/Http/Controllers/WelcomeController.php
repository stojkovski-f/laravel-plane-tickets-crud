<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Inertia\Inertia;
use Illuminate\Support\Facades\Config;

class WelcomeController extends Controller
{
    public function index()
    {
        $flights = Flight::all();
        
        return Inertia::render('Welcome', [
            'flights' => $flights,
            'appUrl' => Config::get('app.url')
        ]);
    }
}