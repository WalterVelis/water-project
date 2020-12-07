<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    const STATUS_AUTOSAVE = 0;
    const STATUS_IN_PROCESS = 1;
    const STATUS_NO_FACTIBLE = 2;
    const STATUS_FACTIBLE = 3;
    const STATUS_QUOTED = 4;
    const STATUS_NEGOTIATION = 5;
    const STATUS_ADVANCE = 6;

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
            self::STATUS_QUOTED => 'Cotizado',
            self::STATUS_NEGOTIATION => 'Negociación',
            self::STATUS_ADVANCE => 'Anticipo',
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

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
    public function admin()
    {
        return $this->belongsTo('App\User', 'admin_assigned');
    }
    public function vendor()
    {
        return $this->belongsTo('App\User', 'vendor_assigned');
    }
    public function tech()
    {
        return $this->belongsTo('App\User', 'tech_assigned');
    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    // protected $dates = ['date', 'created_at'];
}
