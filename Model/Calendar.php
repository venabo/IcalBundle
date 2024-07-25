<?php

namespace BOMO\IcalBundle\Model;

use Kigkonsult\Icalcreator\IcalInterface;
use Kigkonsult\Icalcreator\Pc;
use Kigkonsult\Icalcreator\Vcalendar;

class Calendar
{
    private vCalendar $cal;

    private Timezone $tz;

    /**
     * Calendar constructor.
     *
     * For compatibility with Outlook, we need to allow creating calendars without Timezone. This is due to the Property
     * "x-wr-timezone" is not supported, and using it derives in obtaining the following error:
     * "not supported calendar message"
     *
     * @param Timezone|null $tz
     */
    public function __construct(Timezone $tz = null)
    {
        $this->cal = new Vcalendar();
        if(isset($tz)) {
            $this->tz = $tz;
            $this->cal->setXprop(IcalInterface::X_WR_TIMEZONE, $tz->getTzid());
            $this->cal->setComponent($tz->getTimezone());
        }
    }

    public function setMethod(null|string $method): static
    {
        $this->cal->setMethod($method);

        return $this;
    }

    public function setUniqueId(null|int|string|Pc $uniqId): static
    {
        $this->cal->setUid($uniqId);

        return $this;
    }

    public function setName(null|int|float|string|Pc $name): static
    {
        $this->cal->setXprop(IcalInterface::X_WR_CALNAME, $name);

        return $this;
    }

    public function setDescription(null|int|float|string|Pc $desc): static
    {
        $this->cal->setXprop(IcalInterface::X_WR_CALDESC, $desc);

        return $this;
    }

    public function newEvent(): Event
    {
        return new Event($this->cal->newVevent());
    }

    public function attachEvent(Event $event): static
    {
        $this->cal->setComponent($event->getEvent());

        return $this;
    }

    public function getCalendar(): Vcalendar
    {
        return $this->cal;
    }

    public function returnCalendar(): string
    {
        $str = $this->cal->vtimezonePopulate()->createCalendar();

        if (false === mb_check_encoding($str, 'UTF-8')) {
            $str = utf8_encode($str);
        }

        return $str;
    }
}
