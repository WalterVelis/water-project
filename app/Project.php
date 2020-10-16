<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public static function nextNumber(){
        $year= date('y');
        $last= Project::where('project_number', 'like',$year.'%')->get()->last();
        if($last==""){
                return $year."01";
            }else{
                $divided_code=explode($year,$last->project_number);
                $n= intval($divided_code[1])+1;
            if($n<10){
                return $year."0".$n;
            }else{
                return $year.$n;
            }
        }
    }
}