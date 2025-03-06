<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationsResource;
use App\Repositories\NotificationRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NotificationController extends Controller
{
    
    public function __construct(private NotificationRepository $notificationRepository) {}

    public function index(): View
    {
        return view('notifications');
    }

    public function notifications(): AnonymousResourceCollection
    {
        return NotificationsResource::collection(
            $this->notificationRepository->getAll()
        );
    }
}
