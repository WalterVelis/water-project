<?php

namespace App\Http\Controllers;

use App\Mail\TokenConfirmation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Google2FA;
use Response;

class DfaController extends Controller
{
    //
    public function checkDoubleFactor(Request $request){

      #error_log('Correo es:');
      #error_log($request['email']);
      #error_log($request['password']);

        $user = User::where('email',$request['email'])->where('activate_2fa','1')->where('status', '1')->get()->first();
        $user2 = User::where('email',$request['email'])->where('activate_2fa_google','1')->where('status', '1')->get()->first();
        error_log($user);

        if( ($user != null) || ($user2 != null) ){

          if($user != null){

            if($user->activate_2fa == true){
              if(Hash::check($request['password'], $user->password)){
                $user->token_login = random_int(100000,999999);
                //6 digitos solo numericos
                $user->save();
                try{
                  Mail::to($user->email_2fa)->send(new TokenConfirmation($user));
                } catch(\Exception $e){
                  return ['is_user_found' => false, 'refreshPage' => true];
                }
                return ['is_user_found' => true, 'user_id' => $user->id, 'is_google_factor' => false];
              }else{
                return ['is_user_found' => false, 'refreshPage' => false];
              }
            }

          }


          if($user2 != null){

            if($user2->activate_2fa_google == true){
              if(Hash::check($request['password'], $user2->password)){
                return ['is_user_found' => true, 'user_id' => $user2->id, 'is_google_factor' => true];
              }else{
                return ['is_user_found' => false, 'refreshPage' => false];
              }
            }

          }




        }else{

          return ['is_user_found' => false, 'refreshPage' => false];




        }

    }

    public function tokenByEmail(Request $request){

      $user = User::findorFail((int)$request['user_id']);

      if( $user->token_login == $request['token_login_view'] ){
        return ['token_code_controller' => true];
      }else{
        return ['token_code_controller' => false];
      }

    }


    public function tokenByGoogle(Request $request){

      $user = User::findorFail((int)$request['user_id']);

      if ((new Google2FA())->verifyKey($user->token_login_google, $request['token_login_view'])) {
        return ['token_code_controller' => true];
      }else{
        return ['token_code_controller' => false];
      }

    }




}
