<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorService extends Model
{
    //
    protected $fillable = [
        'vendor_id', 'service_id',
        'update_by','created_by'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
