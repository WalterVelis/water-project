@component('mail::message')
# {{ config('app.name') }}

<p>
{{$text_msj1}} <b>{{$vendorName}}</b> {{$text_msj2}}
</p>

@component('mail::button', ['url' =>$urlEmail])
@lang('Review profile')
@endcomponent

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
