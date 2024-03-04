<?php

namespace App\Helpers;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class EventScheduleHelper
 * @package App\Helpers
 */
class EventScheduleHelper
{
    /**
     * Contains *Illuminate\Support\Carbon* instance of the current date and time in DESC order
     *
     * @var Carbon[] $schedule
     */
    private static array $schedules = [];

    /**
     * @var Event|Model|Builder
     */
    private static Event|Model|Builder $event;

    /**
     * @var string|int
     */
    private static string|int $frequency;

    /**
     * @var Carbon
     */
    private static Carbon $eventCreated;

    /**
     * @var Carbon
     */
    private static Carbon $startDate;

    /**
     * @var Carbon
     */
    private static Carbon $lastSchedule;

    /**
     * @var string|int
     */
    private static string|int $dateDiff;

    /**
     * @var string|int
     */
    private static string|int $cycleCount;

    /**
     * Chronological order of the days of January
     * 01 02 03 04 05 06 07 08 09 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27 28 29 30 31
     * -- EC -- -- -- -- -- -- 7S -- -- -- -- -- TD 7S -- -- -- -- -- -- 7S -- -- -- -- -- -- LS SD
     *
     * @param Event|Model|Builder $event
     * @return EventScheduleHelper
     */
    public static function init(Event|Model|Builder $event): EventScheduleHelper
    {
        self::$event        = $event;
        self::$frequency    = $event->reminder;
        self::$eventCreated = $event->created_at;
        self::$startDate    = $event->start_date;

        self::$lastSchedule = self::$startDate->subDay();
        self::$dateDiff     = self::$eventCreated->diffInDays(self::$lastSchedule);
        self::$cycleCount   = floor(self::$dateDiff / self::$frequency);

        return new static();
    }

    /**
     * Checks if the event is scheduled for today
     *
     * @return bool
     */
    public function ifEventIsScheduledToday(): bool
    {
        if (self::$event->reminder == 1) {
            return true;
        }

        $todayIsScheduled = false;
        for ($i = 0; $i < self::$cycleCount; $i++) {
            $schedule = (clone self::$eventCreated)->addDays(self::$frequency * $i);
            if ($schedule->isToday()) {
                $todayIsScheduled = true;
                break;
            }
        }

        return $todayIsScheduled;
    }

    /**
     * Checks if the event last schedule is today
     *
     * @return bool
     */
    public function ifTodayIsLastScheduled(): bool
    {
        return self::$schedules[0] == Carbon::today();
    }

    /**
     * @return EventScheduleHelper
     */
    public function setSchedulesDESCOrder(): EventScheduleHelper
    {
        //$cycleReminder = $dateDiff % $frequency;
        //$first_schedule = $eventCreated->addDays($cycleReminder);

        for ($i = 0; $i < self::$cycleCount; $i++) {
            self::$schedules[] = (clone self::$lastSchedule)->subDays(self::$frequency * $i);
        }

        return $this;
    }

    /**
     * @return Carbon[]
     */
    public static function getSchedulesDESCOrder(): array
    {
        return self::$schedules;
    }
}
