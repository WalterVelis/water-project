@component('mail::message')
# {{ config('app.name') }}

<p>
    @lang('The vendor ')
    <b>{{$vendorName}}</b>
    @lang(' has completed its profile and has submitted it for review. Click on the button for review it.')    

</p>

@component('mail::button', ['url' =>$urlEmail])
@lang('Review profile')
@endcomponent

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
