<?php

namespace App\Http\Controllers;

use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        return auth()->user()->notifications()->get(['data', 'read_at']);
    }

    public function unreadAll()
    {
        auth()->user()->readNotifications->markAsUnRead();

        return [
            'success' => "All available notifications marked as unread for " . auth()->user()->name,
            'status' => 200
        ];

    }

    public function readAll(User $user)
    {
        auth()->user()->unreadNotifications->markAsRead();

        return [
            'success' => "All available notifications marked as read for " . auth()->user()->name,
            'status' => 200
        ];

    }

    public function getReadNotifications()
    {
        return [
            'readNotifications' =>
                auth()->user()
                    ->readNotifications()
                    ->get([
                        'data',
                        'read_at'
                    ])
        ];
    }

    public function getUnreadNotifications()
    {

        return [
            'unreadNotifications' =>
                auth()->user()
                    ->unreadNotifications()
                    ->get([
                        'data',
                        'read_at'
                    ])

        ];

    }


}
