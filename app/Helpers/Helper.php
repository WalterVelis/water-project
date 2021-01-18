<?php

namespace App\Helpers;

class Helper
{
    public static function formatMoney($money, $sign = true) {
        $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $number = $formatter->formatCurrency($money, 'USD');
        // dd($number);
        if(!$sign)
            $number = str_replace("$", " ", $number);
        return $number;
    }

    public static function boolString($bool) {
        if($bool)
            return 'Sí';
        return 'No';
    }
}
