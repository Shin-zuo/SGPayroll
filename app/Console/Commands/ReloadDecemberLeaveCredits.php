<?php

namespace SGpayroll\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use SGpayroll\LeaveCreditLedger;

class ReloadDecemberLeaveCredits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:reload-december {year? : Target year to reload credits for (defaults to current year)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload annual leave credits to 11 (6 Vacation Leave, 5 Sick Leave) for all active employees every 2nd week of December';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $year = $this->argument('year') ? (int) $this->argument('year') : Carbon::now()->year;

        $this->info("Reloading annual leave credits for year {$year} to 11 (6 VL, 5 SL)...");

        $count = LeaveCreditLedger::reloadAnnualCredits($year);

        $this->info("Successfully reloaded annual leave credits for {$count} active employee(s).");

        return 0;
    }
}
