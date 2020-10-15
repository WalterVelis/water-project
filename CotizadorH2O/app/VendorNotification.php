<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorNotification extends Model
{
    //
    protected $fillable = [
        'vendor_id', 'user_id',
        'motive', 'revision_number', 'is_review',
        'update_by','created_by'
    ];

    public static function getMotives($revision_number,$vendor_id){

        $motives = VendorNotification::where('revision_number', $revision_number)->where('vendor_id', (int)$vendor_id)->where('motive', '!=', null)->get();
        return $motives;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
