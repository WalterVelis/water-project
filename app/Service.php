<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable =[
        'name','category_id',
        'update_by','created_by'
    ];

    public static function searchOptions($category){
        $servicesOptions = Service::where('category_id', $category)->get();
        return $servicesOptions;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function vendor_services()
    {
        return $this->hasMany(VendorService::class);
    }
}
