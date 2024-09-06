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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::channel('aerator_status')->info('Aerator Manage Command Starting');

        // Get the current machine status from cache, default is 'off'
        $machineStatus = Cache::get('machine_status', 'off');
        $lastSwitchTime = Cache::get('last_switch_time', Carbon::now());

        if (Cache::get('machine_status') == null && Cache::get('last_switch_time') == null) {
            Cache::put('machine_status', $machineStatus);
            Cache::put('last_switch_time', $lastSwitchTime);
            Log::channel('aerator_status')->info('When empty then store off and current time machine status: '. Cache::get('machine_status'). ', last_switch_time: '. Cache::get('last_switch_time'));
        }

        // Get the current time
        $currentTime = Carbon::now();
        // Check the time difference between now and the last switch
        $elapsedMinutes = $currentTime->diffInMinutes($lastSwitchTime);

        // If the machine is off and it's been 80 minutes, turn it on
        if ($machineStatus === 'off' && $elapsedMinutes >= 40) {
            $this->switchMachineOn($currentTime);
        } // If the machine is on and it's been 40 minutes, turn it off
        elseif ($machineStatus === 'on' && $elapsedMinutes >= 80) {
            $this->switchMachineOff($currentTime);
        }
    }

    // Function to switch machine on
    protected function switchMachineOn($currentTime)
    {
        Log::channel('aerator_status')->info('Aerator On at ' . $currentTime);
        Cache::put('machine_status', 'on');  // Update machine status to 'on'
        Cache::put('last_switch_time', $currentTime);  // Update the last switch time
    }

    // Function to switch machine off
    protected function switchMachineOff($currentTime)
    {
        Log::channel('aerator_status')->info('Aerator Off at ' . $currentTime);
        Cache::put('machine_status', 'off');  // Update machine status to 'off'
        Cache::put('last_switch_time', $currentTime);  // Update the last switch time
    }


}
