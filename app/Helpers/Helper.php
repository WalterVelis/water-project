<?php

namespace App\Helpers;

class Helper
{
    public static function formatMoney($money) {
        $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($money, 'USD');
    }
}
