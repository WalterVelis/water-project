<?php

namespace App\Helpers;

class Helper
{
    public static function formatMoney($money) {
        $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($money, 'USD');
    }

    public static function boolString($bool) {
        if($bool)
            return 'Sí';
        return 'No';
    }
}
