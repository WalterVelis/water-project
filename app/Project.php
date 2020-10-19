<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{


    const STATUS_IN_PROCESS = 1;
    // const STATUS_ACTIVE = 2;
    // const STATUS_INACTIVE  = 3;

    /**
     * Return list of status codes and labels

     * @return array
     */
    public static function listStatus()
    {
        return [
            self::STATUS_IN_PROCESS => 'In Process',
            // self::STATUS_ACTIVE    => 'Active',
            // self::STATUS_INACTIVE  => 'Inactive'
        ];
    }

    protected $fillable = [
        'name',
        'description'
    ];

    public static function boot()
    {
        parent::boot();
        // it will automatically add authenticate user to created_by column of selected model
        static::creating(function ($model){
            $model->status = 1;
            $model->created_by = auth()->user()->id;
            $model->updated_by = auth()->user()->id;
        });
    }

    /**
     * Get the format record associated with the project.
     */
    public function format()
    {
        return $this->hasOne('App\Format');
    }

    // public static function nextNumber(){
    //     $year= date('y');
    //     $last= Project::where('project_number', 'like',$year.'%')->get()->last();
    //     if($last==""){
    //             return $year."01";
    //         }else{
    //             $divided_code=explode($year,$last->project_number);
    //             $n= intval($divided_code[1])+1;
    //         if($n<10){
    //             return $year."0".$n;
    //         }else{
    //             return $year.$n;
    //         }
    //     }
    // }
}
