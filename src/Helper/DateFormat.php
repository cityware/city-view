<?php

namespace Cityware\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DateFormat extends AbstractHelper {

    public function __invoke($value, $format = 'd/m/Y', $dateTime = false) {
        $timeValue = $dateValue = null;
        if ($dateTime) {
            $dateTime = explode(' ', $value);
            $dateValue = $dateTime[0];
            $timeValue = $dateTime[1];
        } else {
            $dateValue = $value;
        }

        $dateOperations = new \Cityware\Format\DateOperations();
        $return = $dateOperations->setDate($dateValue)->format($format);

        if ($dateTime) {
            return $return . ' ' . $timeValue;
        } else {
            return $return;
        }
    }

}
