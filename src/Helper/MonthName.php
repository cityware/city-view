<?php

namespace Cityware\View\Helper;

use Zend\View\Helper\AbstractHelper;

class MonthName extends AbstractHelper {

    public function __invoke($value) {
        return \Cityware\Format\Date::extensionMonth($value);
    }

}
