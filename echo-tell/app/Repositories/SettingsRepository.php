<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SettingsRepository
{
    /**
     * Constructor to initialize Setting model.
     *
     * @param \App\Models\Setting $setting
     */
    public function __construct(public Setting $setting)
    {
    }

    /**
     * Retrieves the count of records created today for a given query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return int
     */
    public function getDailyRecordCount($query)
    {
        return $query->whereDate('created_at', Carbon::now()->today())->count();
    }

    /**
     * Retrieves today's statistics for a given user.
     *
     * @param \App\Models\User $user
     * @return array
     */
    public function getTodaysStatistics($user)
    {
        return [
            'sent_messages' => $this->getDailyRecordCount($user->sentMessages()),
            'created_questions' => $this->getDailyRecordCount($user->question()),
            'recieved_responses' => $this->getDailyRecordCount($user->responses()),
            'recieved_messages' => $this->getDailyRecordCount($user->messages()),
        ];
    }

    /**
     * Retrieves the users who have daily mail notifications enabled.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersForMail()
    {
        return User::whereHas('settings', function ($query) {
            $query->where('daily_mails_enabled', 1);
        })->get();
    }

    /**
     * Updates the mail notification settings for the authenticated user.
     *
     * @param array $status
     * @return void
     */
    public function updateMailNotifications(array $status)
    {
        Auth::user()->settings()->update($status);
    }

    /**
     * Updates the daily mail settings for the authenticated user.
     *
     * @param array $status
     * @return void
     */
    public function updateDailyMails(array $status)
    {
        Auth::user()->settings()->update($status);
    }
}
