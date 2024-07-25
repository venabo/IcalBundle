<?php

namespace BOMO\IcalBundle\Model;

use DateInterval;
use DateTimeInterface;
use Kigkonsult\Icalcreator\Pc;
use Kigkonsult\ICalcreator\Valarm;

class Alarm
{
    private vAlarm $alarm;

    public function __construct($object = null)
    {
        if ($object instanceof Valarm) {
            $this->alarm = $object;

        } else {
            $this->alarm = new Valarm();
        }
    }

    public function setAction(string $action): static
    {
        switch ($action) {
            case 'DISPLAY':
                $this->alarm->setDescription('Need to be setted');
                $this->alarm->setTrigger('-PT1H', array('VALUE' => 'DURATION'));
                break;

            default:
                throw new \InvalidArgumentException('Only [DISPLAY] options are available');
                break;
        }

        $this->alarm->setAction($action);

        return $this;
    }

    public function setDescription(null|string|Pc $desc): static
    {
        $this->alarm->setDescription($desc);

        return $this;
    }

    public function setTrigger(null|string|Pc|DateTimeInterface|DateInterval $str): static
    {
        $this->alarm->setTrigger($str, array('VALUE' => 'DURATION'));

        return $this;
    }

    public function getAlarm(): Valarm
    {
        return $this->alarm;
    }
}
