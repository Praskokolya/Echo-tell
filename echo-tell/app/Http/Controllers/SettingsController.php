<?php

namespace App\Http\Controllers;

use App\Repositories\SettingsRepository;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * SettingsController constructor.
     *
     * @param SettingsRepository $settingsRepository
     */
    public function __construct(private SettingsRepository $settingsRepository, private SettingsService $settingsService) {}

    public function changeMailNotifications(Request $request): void
    {
        $this->settingsRepository
            ->updateMailNotifications($request->all());
    }

    public function changeDailyMails(Request $request): void
    {
        $this->settingsRepository
            ->updateDailyMails($request->all());
    }

    public function sendDailyStatistics(): void
    {
        $this->settingsService->sendMailToUser(Auth::user());
    }
}
