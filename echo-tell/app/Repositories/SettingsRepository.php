<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SettingsRepository
{
    public function __construct(public Setting $setting)
    {
    }

    private function getDailyRecordCount($query)
    {
        return $query->whereDate('created_at', Carbon::now()->today())->count();
    }

    public function getTodaysStatistics($user)
    {
        return [
            'sent_messages' => $this->getDailyRecordCount($user->sentMessages()),
            'created_questions' => $this->getDailyRecordCount($user->question()),
            'recieved_responses' => $this->getDailyRecordCount($user->responses()),
            'recieved_messages' => $this->getDailyRecordCount($user->messages()),
        ];
    }

    public function getUsersForMail()
    {
        return User::whereHas('settings', function ($query) {
            $query->where('daily_mails_enabled', 1);
        })->get();
    }
    public function updateMailNotifications(array $status)
    {
        Auth::user()->settings()->update($status);
    }

    public function updateDailyMails(array $status)
    {
        Auth::user()->settings()->update($status);
    }
}
