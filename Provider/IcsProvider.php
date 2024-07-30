<?php

namespace BOMO\IcalBundle\Provider;


use BOMO\IcalBundle\Model\Timezone,
    BOMO\IcalBundle\Model\Calendar,
    BOMO\IcalBundle\Model\Event,
    BOMO\IcalBundle\Model\Alarm
    ;

class IcsProvider
{
    public function createTimezone(array $config = array()): Timezone
    {
        return new Timezone($config);
    }

    public function createCalendar(Timezone $tz = null, $allowNullTimezone = FALSE): Calendar
    {
        if (is_null($tz) && false === $allowNullTimezone) {
            $tz = $this->createTimezone();
        }
        return new Calendar($tz);
    }

    public function createEvent(): Event
    {
        return new Event();
    }

    public function createAlarm(): Alarm
    {
        return new Alarm();
    }
}
