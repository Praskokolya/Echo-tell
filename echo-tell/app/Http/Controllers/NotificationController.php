<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationsResource;
use App\Repositories\NotificationRepository;

class NotificationController extends Controller
{
    /**
     * NotificationController constructor.
     *
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(public NotificationRepository $notificationRepository) {}

    /**
     * Display the notifications page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('notifications');
    }

    /**
     * Retrieve all notifications.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function returnNotifications()
    {
        return NotificationsResource::collection(
            $this->notificationRepository->getAll()
        );
    }
}
