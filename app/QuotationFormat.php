<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationFormat extends Model
{

    protected $table = "quotation_format";

    protected $fillable = [
        'description',
        'qty',
        'cost',
        'utility',
        'indirect',
        'format_id',
    ];

    public function format()
    {
        return $this->belongsTo('App\Format');
        // return $this->hasOne('App\Format', 'id', 'format_id');
    }

    public $timestamps = false;


}
