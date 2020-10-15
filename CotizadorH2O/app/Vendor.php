<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'id','user_id', 'name', 'legal_name', 'contact_name','is_status_complete', 'is_external','path_address_proof',
        'street','inner_number','outer_number','suburb','delegation','postal_code','city','state_id',
        'country_id','path_official_identification',
        'path_32', 'key_rfc', 'path_cover_rfc', 'mobile', 'phone',
        'update_by','created_by', 'status', 'color_status', 'revision_number'

    ];

    public function vendorBankAccounts()
    {
        return $this->hasMany(VendorBankAccounts::class);
    }

    public function vendorBudgetAccounts()
    {
        return $this->hasMany(BudgetVendorAccount::class);
    }

    public function vendorServices(){
        return $this->hasMany(VendorService::class);
    }

    public function vendorNotifications(){
        return $this->hasMany(VendorNotification::class);
    }

    public static function vendorReviews($id, $number){
        $reviews = VendorNotification::where('vendor_id', $id)->where('revision_number', $number)->get();
        return $reviews;
    }

    public static function vendorReviewsMotives($id, $number){
        $reviews = VendorNotification::where('vendor_id', $id)->where('revision_number', $number)->where('is_review', true)->where('motive', '!=', null)->get();
        return $reviews;
    }

    public static function hasReview($id){
        $vendor = Vendor::findorFail($id);
        $vendorNotifications = VendorNotification::where('vendor_id', $vendor->id)->where('revision_number', $vendor->revision_number)->get();
        foreach($vendorNotifications as $review){
            if($review->user_id == auth()->user()->id ){
                return true;
            }
        }
        return false;
    }


    public static function hasReviewStatus($id){
        $vendor = Vendor::findorFail($id);
        $vendorNotifications = VendorNotification::where('vendor_id', $vendor->id)->where('revision_number', $vendor->revision_number)->get();
        foreach($vendorNotifications as $review){
            if($review->user_id == auth()->user()->id ){
                if($review->is_review == false){
                    return true;
                }else{
                    return false;
                }
            }
        }
        return false;
    }

    public static function hasReviewAnswer($id){
        $vendor = Vendor::findorFail($id);
        $vendorNotifications = VendorNotification::where('vendor_id', $vendor->id)->where('revision_number', $vendor->revision_number)->where('is_review', 1)->get();
        foreach($vendorNotifications as $review){
            if($review->user_id == auth()->user()->id ){
                if($review->motive == null){
                    return true;
                }else{
                    return false;
                }
            }
        }
        return false;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }



}