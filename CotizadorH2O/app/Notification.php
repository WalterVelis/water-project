<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Notification extends Model
{
    //
    public static function countNotificationActive(){
        $query1 = 'SELECT COUNT(targeted_user) AS notifications FROM notifications WHERE targeted_user = '.auth()->user()->id.' AND is_status_activated = 1';
        $notifications =DB::select( DB::raw($query1));
        return $notifications;
    }

    public static function textNotificationActive(){
        $query1 = 'SELECT action, description, action_url, COUNT(id) AS total FROM notifications WHERE targeted_user = '.auth()->user()->id.' AND is_status_activated = 1 GROUP BY action ORDER BY action ASC';
        $notifications =DB::select( DB::raw($query1));
        return $notifications;

    }
}
