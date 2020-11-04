<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'denomination',
        'contact_name',
        'job_title',
        'email',
        'phone',
        'product_type'
    ];

    public function productTypeLabels() {
        return $this->product_type == 0 ? 'Materiales extra' : 'Material Isla Urbana';
    }
}
