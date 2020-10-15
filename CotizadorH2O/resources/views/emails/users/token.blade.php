@component('mail::message')
# {{ config('app.name') }}

@lang('This is the confirmation token for you to log in'). <br>
@lang('Token Confirmation'): {{ $token_login }} 



@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
