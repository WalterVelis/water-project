@component('mail::message')
# {{ config('app.name') }}

@lang('We help you recover your data'):<br>
@lang('The user is: ') {{ $email }}<br>
@lang('The password is: ') {{ $password }}

@component('mail::button', ['url' => config('app.url')])
@lang('Lets Go')
@endcomponent

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
