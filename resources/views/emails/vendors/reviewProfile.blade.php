@component('mail::message')
# {{ config('app.name') }}

<p>{{$text_msj1}}
@if ($statusApproved)
<b>@lang('Agreed')</b>    
@else
<b>@lang('Decline')</b>    
@endif
{{$text_msj2}}
</p><br>

@if ($statusVendor == '1')
@php
$motives=App\VendorNotification::getMotives($revision_number, $vendorId);
$countMotives = count($motives);
@endphp
{{ __('Feedback') }}: <br>
<ul>
@foreach ($motives as $motive)
<li><i>{{$motive->motive}}</i></li>
@endforeach
</ul>

@endif



@component('mail::button', ['url' => $urlEmail])
@lang('My Profile')
@endcomponent

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
