<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		$date = Carbon::now()->format('Y-m-d');
		$log = storage_path('logs') . '/backups/' . Carbon::now()->format('Y-m') . '.log';
		$schedule->command(
			'db:backup --database=mysql --destination=local --destinationPath=/backups/' . $date . ' --compression=gzip'
		)
			->dailyAt(2)
			->appendOutputTo($log);
		$schedule->command(
			'db:restore --database=mysql --source=local --sourcePath="/backups/genesis.gz" --compression=gzip'
		)
			->dailyAt(3)
			->appendOutputTo($log);
    }
}
