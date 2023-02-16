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
        $settings = Settings::get()->first();
        $data['url'] = URL::to('/');
        return Mail::send($template, $data, function($message) use ($to, $toClientName, $subject, $settings) {
           $message->to($to, $toClientName)->subject('[' . env('APP_NAME') . '] - ' . $subject);
           $message->from(env('MAIL_FROM_ADDRESS'), $settings->company_name);
        });
    }
}
