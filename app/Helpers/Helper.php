<?php

namespace App\Helpers;

class Helper
{
    public static function formatMoney($money) {
        $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $number = $formatter->formatCurrency($money, 'USD');
        // dd($number);
        $number = str_replace("$", " ", $number);
        return $number;
    }

    public static function boolString($bool) {
        if($bool)
            return 'Sí';
        return 'No';
    }
}
