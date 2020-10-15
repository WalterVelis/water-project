@component('mail::message')
# {{ config('app.name') }}

<p>{{$text_msj}}</p>

@component('mail::button', ['url' =>$urlEmail])
@lang('Review profile')
@endcomponent

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
