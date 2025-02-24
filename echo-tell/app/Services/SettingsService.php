<?php

namespace App\Services;

use App\Mail\StatisticMail;
use App\Repositories\SettingsRepository;
use Illuminate\Support\Facades\Mail;

class SettingsService
{
    public function __construct(public SettingsRepository $settingsRepository) {}

    /**
     * If a parameter is not passed to the method, then the mail is sending to all users
     *
     * @param [type] $user
     * @return void
     */
    public function startSendingMail($user = null)
    {
        $usersForMailing = $this->settingsRepository->getUsersForMail();
        
        if($user){
            $usersForMailing = [$user];
        }

        foreach ($usersForMailing as $user) {
            Mail::to($user->email)->send(new StatisticMail($this->settingsRepository->getTodaysStatistics($user)));
        };
    }
}
