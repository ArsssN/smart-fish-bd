<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AeratorManageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aerator:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var array - machine status options (on, off)
     */
    const machineStatus = [
        'on' => 'on',
        'off' => 'off'
    ];

    /**
     * @var int - start after time in min: 40
     */
    const onAfterOff = 1 * 60; // seconds

    /**
     * @var int - stop after time in min: 80
     */
    const offAfterOn = 1 * 60; // seconds

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        Log::channel('aerator_status')->info('Aerator Manage Command Starting');

        // Get the current machine status from cache, default is 'on'
        $machineStatus = Cache::get('machine_status', 'on');
        // Get the last switch time from cache, default is now
        $lastSwitchTime = Cache::get('last_switch_time', now());

        // Assume the machine is on if the status is not 'on' or 'off'
        Cache::put('machine_status', $machineStatus);
        // Assume the last switch time is now if it's not set
        Cache::put('last_switch_time', $lastSwitchTime);

        Log::channel('aerator_status')->info('Current Machine Status: ' . $machineStatus);
        Log::channel('aerator_status')->info('Last Switch Time: ' . $lastSwitchTime);

        // Check the time difference between now and the last switch time
        $elapsedSeconds = Carbon::parse($lastSwitchTime)->subSeconds(5)->diffInSeconds(now());

        Log::channel('aerator_status')->info('Elapsed Seconds: ' . $elapsedSeconds);

        // If the machine is off, and it's been 40 minutes, turn it on
        if (self::machineStatus[$machineStatus] === 'off' && $elapsedSeconds >= self::onAfterOff) {
            $this->switchMachineOn();
        } // If the machine is on, and it's been 80 minutes, turn it off
        else if (self::machineStatus[$machineStatus] === 'on' && $elapsedSeconds >= self::offAfterOn) {
            $this->switchMachineOff();
        }

        Log::channel('aerator_status')->info('Aerator Manage Command Ending' . PHP_EOL);
    }


    /**
     * To switch machine on and update the cache
     *
     * @return void
     */
    protected function switchMachineOn(): void
    {
        $currentTime = now();
        Cache::put('machine_status', 'on');  // Update machine status to 'on'
        Cache::put('last_switch_time', $currentTime);  // Update the last switch time
        Log::channel('aerator_status')->info('Aerator status: On - at: ' . $currentTime);
    }


    /**
     * To switch machine off and update the cache
     *
     * @return void
     */
    protected function switchMachineOff(): void
    {
        $currentTime = now();
        Cache::put('machine_status', 'off');  // Update machine status to 'off'
        Cache::put('last_switch_time', $currentTime);  // Update the last switch time
        Log::channel('aerator_status')->info('Aerator status: Off - at: ' . $currentTime);
    }
}
