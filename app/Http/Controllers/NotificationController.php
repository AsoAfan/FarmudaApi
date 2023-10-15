<?php

namespace App\Http\Controllers;

use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        return auth()->user()->notifications()->get(['id', 'data', 'read_at']);
    }

    public function unreadAll()
    {
        auth()->user()->readNotifications->markAsUnRead();

        return [
            'success' => "All available notifications marked as unread for " . auth()->user()->name,
        ];

    }

    public function readAll(User $user)
    {
        auth()->user()->unreadNotifications->markAsRead();

        return [
            'success' => "All available notifications marked as read for " . auth()->user()->name,
        ];

    }

    public function getReadNotifications()
    {
        return auth()->user()
            ->readNotifications()
            ->get([
                'id',
                'data',
                'read_at'
            ]);
    }

    public function getUnreadNotifications()
    {

        return auth()->user()
            ->unreadNotifications()
            ->get(
                [
                    'id',
                    'data',
                    'read_at'
                ]
            );

    }


}
