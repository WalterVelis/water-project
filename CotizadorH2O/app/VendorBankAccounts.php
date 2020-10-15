<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorBankAccounts extends Model
{
    //
    protected $fillable = [
        'vendor_id', 'bank_account_id', 'is_status_complete',
        'update_by','created_by'
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }



}
