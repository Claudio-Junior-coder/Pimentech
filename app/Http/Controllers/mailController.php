<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class mailController extends Controller
{
    //
    public static function sendMail($data, $template, $to, $toClientName, $subject) {
        $settings = Settings::get();
        $data['url'] = URL::to('/');
        return Mail::send($template, $data, function($message) use ($to, $toClientName, $subject) {
           $message->to($to, $toClientName)->subject('[' . env('APP_NAME') . '] - ' . $subject);
           $message->from($settings->company_email, $settings->company_name);
        });
    }
}
