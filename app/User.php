<?php
/*

=========================================================
* Argon Dashboard PRO - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro-laravel
* Copyright 2018 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)

* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'activate_2fa_google', 'name', 'email', 'email_2fa', 'password', 'picture' ,'role_id', 'status','created_by', 'updated_by', 'change_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the role of the user
     *
     * @return \App\Role
     */
    public static function search($status){
        return User::status($status)->orderBy('name')->get();
    }
          
    public function scopeStatus($query, $status){
        $query->where('status',$status);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    /**
     * Get the path to the profile picture
     *
     * @return string
     */
    public function profilePicture()
    {
        if ($this->picture) {
            return "/storage/{$this->picture}";
        }

        return "/material/img/licons/no-image.png";
    }

    public static function hasPermissions($search){
        $roles=auth()->user()->role->rolePermission;
        foreach($roles as $role){
            if($role->permission->name==$search){
                return true;
            }
        }
        return false;
    }

    public static function hasBudgetPermissions($budget_type,$action,$budget_id){
        if($budget_type==0 && auth()->user()->role->name=='General Producer'){ //General budget/General prooducer
            if($budget_id==0){                                                
                if($action=='index' || $action=='create'){
                    return true;
                }
            }else{
                if($action=='duplicate'){
                    return true;
                }
            }
        }
        if($budget_type==0 && auth()->user()->role->name=='Executive Producer'){ //General budget/General prooducer
            if($budget_id==0){                                                
                if($action=='index' && Budget::where('budget_type',0)->where('executive_producer_id',auth()->user()->id)->count()>0){
                    return true;
                }
            }
        }
        if($budget_type==0){ //Agreed budget
            if($budget_id!=0){
                $budget=Budget::find($budget_id);
                if($budget->created_by==auth()->user()->id && ($action=='approve')){
                    return true;
                }
                if($action=='edit' && Budget::where('parent_budget',$budget->id)->count()==0 && $budget->created_by==auth()->user()->id){
                    return true;                }
            }
            if($budget_id==0){
                if($action=='index'){
                    if(Budget::where('budget_type',1)->where('executive_producer_id',auth()->user()->id)->orWhere('created_by',auth()->user()->id)->count()>0)
                    return true;
                }
            }
            if($budget_id!=0){
                $budget=Budget::find($budget_id);
                if(($budget->executive_producer_id==auth()->user()->id) && ($action=='show')){
                    return true;
                }
                if($budget->created_by!=auth()->user()->id && auth()->user()->role->name=='General Producer'&& ($action=='show')){
                    return true;
                }
                if(Budget::where('parent_budget',$budget->id)->count()>0 && auth()->user()->role->name=='General Producer' && $action=='show'){
                    return true;
                }
            }
        }

        if($budget_type==1){ //Agreed budget
            if($budget_id==0){
                if($action=='index'){
                    if(Budget::where('budget_type',1)->where('executive_producer_id',auth()->user()->id)->orWhere('created_by',auth()->user()->id)->count()>0)
                    return true;
                }
            }
            if($budget_id!=0){
                $budget=Budget::find($budget_id);
                if(($budget->executive_producer_id==auth()->user()->id || $budget->created_by==auth()->user()->id) && ($action=='edit')){
                    return true;
                }
            }
        }
    }

}