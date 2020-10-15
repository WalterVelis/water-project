<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    protected $fillable =[
        'table_name','record_id', 'path_document', 'record_column_name',
        'update_by','created_by'
    ];
}
