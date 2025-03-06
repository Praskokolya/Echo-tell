<?php

namespace App\Console\Commands;

use App\Services\SettingsService;
use Illuminate\Console\Command;

class SendDailyMessages extends Command
{
    public function __construct(public SettingsService $settingsService){
        parent::__construct();
    }

    protected $signature = 'send:daily-messages';

    protected $description = 'Command description';

    public function handle()
    {
        $this->settingsService->sendMails();
    }
}
