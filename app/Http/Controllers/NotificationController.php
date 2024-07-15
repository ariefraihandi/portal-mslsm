<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $factory = (new Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));

        $messaging = $factory->createMessaging();

        $message = CloudMessage::withTarget('token', $request->input('token'))
            ->withNotification(Notification::create($request->input('title'), $request->input('body')));

        $messaging->send($message);

        return response()->json(['status' => 'Notification sent!']);
    }
}
