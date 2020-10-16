@component('mail::message')
# {{ config('app.name') }}

{{$text_msj}} <br>
<b>@lang('Commentary'):</b> &nbsp;<i>{{$feedback}}</i>

@component('mail::button', ['url' =>$urlEmail])
@lang('Review profile')
@endcomponent

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
