@component('mail::message')
# Cotizador AguaH2O

@lang('We help you recover your data'):<br>
@lang('The user is: ') {{ $email }}<br>
@lang('The password is: ') {{ $password }}

{{-- @component('mail::button', ['url' => config('app.url')]) --}}
@component('mail::button', ['url' => "http://scall.isinet.mx"])
@lang('Lets Go')
@endcomponent

@lang('Thanks'),<br>
Cotizador AguaH2O
@endcomponent
