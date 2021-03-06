@component('mail::message')
# Cotizador AguaH2O

@lang('We welcome you, these are your account details'):<br>
@lang('The user is: ') {{ $email }}<br>
@lang('The password is: ') {{ $password }}<br>
@if ($typeRol)
@lang('We invite you to enter our site and complete your vendor profile.')
@endif

@component('mail::button', ['url' => config('app.url')])
@lang('Lets Go')
@endcomponent

@lang('Thanks'),<br>
Cotizador AguaH2O
@endcomponent
