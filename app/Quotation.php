<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'version',
        'validity',
        'currency',
        'web',
        'delivery',
        'payment',
        'notes',
        'utility',
        'indirect',
        'format_id',
    ];

    public function format()
    {
        return $this->belongsTo('App\Format');
        // return $this->hasOne('App\Format', 'id', 'format_id');
    }

}
