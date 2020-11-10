<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    const STATUS_AUTOSAVE = 0;
    const STATUS_IN_PROCESS = 1;
    const STATUS_NO_FACTIBLE = 2;
    const STATUS_FACTIBLE = 3;

    /**
     * Return list of status codes and labels

     * @return array
     */
    public static function listStatus()
    {
        return [
            self::STATUS_AUTOSAVE => 'Borrador',
            self::STATUS_IN_PROCESS => 'En proceso',
            self::STATUS_NO_FACTIBLE => 'No factible',
            self::STATUS_FACTIBLE => 'Factible',
        ];
    }
/**
     * Returns label of actual status

     * @param string
     */
    public function statusLabel()
    {
        $list = self::listStatus();

        // little validation here just in case someone mess things
        // up and there's a ghost status saved in DB
        return isset($list[$this->status])
            ? $list[$this->status]
            : $this->status;
    }
}
