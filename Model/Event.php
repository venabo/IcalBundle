<?php

namespace BOMO\IcalBundle\Model;

use DateTimeInterface;
use Kigkonsult\Icalcreator\Pc;
use Kigkonsult\Icalcreator\Vevent;

class Event
{
    private vEvent $event;

    /**
     * To ignore hours
     */
    private bool $isAllDayEvent;

    public function __construct($object = null)
    {
        if ($object instanceOf Vevent) {
            $this->event = $object;
        } else {
            $this->event = new Vevent();
        }
    }

    public function setStartDate(null|string|DateTimeInterface|Pc $date): static
    {
        $params = array();
        if (true === $this->isAllDayEvent) {
            $params = array("VALUE" => "DATE");
        }

        $this->event->setDtstart($date, $params);

        return $this;
    }

    public function setEndDate(null|string|DateTimeInterface|Pc $date): static
    {
        $params = array();
        if (true === $this->isAllDayEvent) {
            $params = array("VALUE" => "DATE");
        }

        $this->event->setDtend($date, $params);

        return $this;
    }

    public function setIsAllDayEvent(bool $bool = true): static
    {
        $this->isAllDayEvent = $bool;

        return $this;
    }

    public function setName(null|string|Pc $name): static
    {
        $this->event->setSummary($name);

        return $this;
    }

    public function setLocation(null|string|Pc $loc): static
    {
        $this->event->setLocation($loc);

        return $this;
    }

    public function setDescription(null|string|Pc $desc): static
    {
        $this->event->setDescription($desc);

        return $this;
    }

    public function setComment(null|string|Pc $comment): static
    {
        $this->event->setComment($comment);

        return $this;
    }

    public function setAttendee(null|string|Pc $attendee): static
    {
        $this->event->setAttendee($attendee);

        return $this;
    }

    public function setOrganizer(null|string|Pc $organizer): static
    {
        $this->event->setOrganizer($organizer);

        return $this;
    }

    public function setStatus(null|string|Pc $status): static
    {
        $this->event->setStatus($status);

        return $this;
    }

    public function setTransparent(null|string|Pc $name): static
    {
        $this->event->setTransp($name);

        return $this;
    }

    public function setPriority(null|int|string|Pc $value): static
    {
        $this->event->setPriority($value);

        return $this;
    }

    public function setSequence(null|int|string|Pc $value): static
    {
        $this->event->setSequence($value);

        return $this;
    }

    public function setUrl(null|string|Pc $url): static
    {
        $this->event->setUrl($url);

        return $this;
    }

    public function newAlarm(): Alarm
    {
        return new Alarm($this->event->newValarm());
    }

    public function attachAlarm(Alarm $alarm): static
    {
        $this->event->setComponent($alarm->getAlarm());

        return $this;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->event, $name)) {
            return call_user_func_array(array($this->event, $name), $arguments);
        }
    }

    public function getEvent(): Vevent
    {
        return $this->event;
    }

    private function datetimeToArray(\Datetime $datetime): array
    {
        $str = $datetime->format('Y-m-d H:i:s');

        $date = date_parse($str);
        $date['min'] = $date['minute'];
        $date['sec'] = $date['second'];
        unset($date['minute'], $date['second']);

        $date['tz'] = $datetime->format('e');

        return $date;
    }
}
