<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'user/doubleFactor',
        'user/doubleFactor/tokenEmail/verificate',
        'user/doubleFactor/tokenGoogle/verificate',
        'vendor/vendorAdd',
        'budgetsection/addSection',
        'budgetBlock/addBlock',
        'budgetAccount/addAccount',
        'budgetsection/editSection',
        'budgetBlock/editBlock',
        'budgetAccount/editAccount',
        'profile/auth-google-sendEmail',
        'profile/auth-google-sendEmailCode',
        'vendor/accountsAdd',
        'vendor/accountsDelete',
        'vendor/accountsEdit',
        'vendor/updateProfile',
        'vendor/checkVendorProfile',
        'vendor/completeProfile',
        'vendor/assignUser',
        'vendor/approveDataVendor',
        'vendor/vendorFilter',
        'vendor/updateTwo',
        'vendor/deactivateFeedBackVendors',
        'vendor/deleteVendor',
        'vendor/resendReviewsEmail',
        'vendor/resendVendorEmail',
        'taxfeebudget/taxFeeAdd',
        'vendor/updateProfileChanges',
        'vendor/addBankChanges',
    ];
}