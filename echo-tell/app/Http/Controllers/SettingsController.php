<?php

namespace App\Http\Controllers;

use App\Mail\StatisticMail;
use App\Repositories\SettingsRepository;
use App\Services\SettingsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    /**
     * SettingsController constructor.
     *
     * @param SettingsRepository $settingsRepository
     */
    public function __construct(public SettingsRepository $settingsRepository, public SettingsService $settingsService) {}

    /**
     * Change the mail notifications settings.
     *
     * @param Request $request
     * @return void
     */
    public function changeMailNotifications(Request $request)
    {
        $this->settingsRepository
            ->updateMailNotifications($request->all());
    }

    /**
     * Change the daily mail notifications settings.
     *
     * @param Request $request
     * @return void
     */
    public function changeDailyMails(Request $request)
    {
        $this->settingsRepository
            ->updateDailyMails($request->all());
    }

    public function sendDailyStatistics()
    {
        $this->settingsService->startSendingMail(Auth::user());
    }
}
