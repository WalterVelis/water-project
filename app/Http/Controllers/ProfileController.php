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
namespace App\Http\Controllers;

use Gate;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Writer as BaconQrCodeWriter;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Http\Request;
use App\Mail\TokenConfirmation;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public static function edit()
    {
        return view('profile.edit');
    }


    public function viewDoubleFactorAuth(){
        if(auth()->user()->role->name == 'Vendor'){
            if(auth()->user()->vendor->is_status_complete){
                return view('profile.vieDoubleFactor');
            }else{
                return redirect('/vendor/'.auth()->user()->vendor->id.'/edit')->withStatus(__('Completa el perfil'));
            }
        }else{
            return view('profile.vieDoubleFactor');
        }
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update(
            $request->merge(['picture' => $request->photo ? $request->photo->store('profile', 'public') : null])
                ->except([$request->hasFile('photo') ? '' : 'picture'])
        );
        auth()->user()->save();

        return back()->withStatus(__('Profile successfully updated.'));
    }

    public function doubleFactorAuthenticationActivate(Request $request){

        $user = User::findorFail(auth()->user()->id);
        $user->activate_2fa = "1";
        $user->email_2fa = $request->email_2fa;
        $user->update();

        return back()->withStatus(__('Activated Double Factor Authentication.'));


    }

    public function sendEmailDoubleFactor(Request $request){
        $user = User::findorFail(auth()->user()->id);
        $user->token_login = random_int(100000,999999);
        //6 digitos solo numericos
        $user->save();
        try{
            Mail::to($request->email_2fa)->send(new TokenConfirmation($user));
        } catch(\Exception $e){
            return ['emailSend' => false];
        }
        return ['emailSend' => true];

    }

    public function tokenEmailCode(Request $request){

        $user = User::findorFail(auth()->user()->id);

        if( $user->token_login == $request['code'] ){
          return ['token_code_controller' => true];
        }else{
          return ['token_code_controller' => false];
        }

      }

    public function doubleFactorAuthenticationDeactivate(Request $request){

        $user = User::findorFail(auth()->user()->id);
        $user->activate_2fa_google = "0";
        $user->activate_2fa = "0";
        $user->email_2fa = '';
        $user->update();

        return back()->withStatus(__('Deactivated Double Factor Authentication.'));


    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password')),
        'change_password' => 1
        ]);

        return back()->withStatus(__('Password successfully updated.'));
    }

    public function doubleFactorGoogle(){
        auth()->user()->token_login_google = (new Google2FA)->generateSecretKey();
        auth()->user()->update();
        $user = auth()->user();


        $urlQR = $this->createUserUrlQR($user);
        return ['urlQR' => $urlQR, 'user' =>$user];
    }


    public function createUserUrlQR($user)
{
    $bacon = new BaconQrCodeWriter(new ImageRenderer(
        new RendererStyle(200),
        new ImagickImageBackEnd()
    ));

    $data = $bacon->writeString(
        (new Google2FA)->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->token_login_google
        ), 'utf-8');

    return 'data:image/png;base64,' . base64_encode($data);
}

public function login2FA(Request $request)
{
    $user = User::findorFail(auth()->user()->id);

    if ((new Google2FA())->verifyKey($user->token_login_google, $request['code_verification'])) {
        $user->activate_2fa_google = "1";
        $user->update();
        return ['statusCode' => true];
    }else{

        return ['statusCode' => false];
    }

    //return redirect()->back()->withErrors(['error'=> 'Código de verificación incorrecto']);
}

public function activateGoogle(){

    return back()->withStatus(__('Activated Double Factor Authentication.'));

}



}
