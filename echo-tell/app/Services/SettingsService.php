<?php

namespace App\Services;

use App\Mail\StatisticMail;
use App\Repositories\SettingsRepository;
use Illuminate\Support\Facades\Mail;

class SettingsService
{
    public function __construct(public SettingsRepository $settingsRepository) {}

    public function sendMails()
    {
        $usersForMailing = $this->settingsRepository->getUsersForMail();

        foreach ($usersForMailing as $user) {
            Mail::to($user->email)->send(new StatisticMail($this->settingsRepository->getTodaysStatistics($user)));
        };
    }

    public function sendMailToUser($user)
    {
        Mail::to($user->email)->send(new StatisticMail($this->settingsRepository->getTodaysStatistics($user)));
    }
}
