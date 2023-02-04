<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class settingsController extends Controller
{
    //
    public function index () {
        $data = Settings::get();
        return view('settings.index', compact('data'));
    }
}
