<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationsResource;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(public NotificationRepository $notificationRepository) {}

    public function index()
    {
        return view('notifications');
    }

    public function returnNotifications()
    {
        return NotificationsResource::collection($this->notificationRepository->getAll());
    }
}
