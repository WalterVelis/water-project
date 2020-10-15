@component('mail::message')
# {{ config('app.name') }}

<p>
    @lang('The vendor ')
    <b>{{$vendorName}}</b>
    @lang(' has edited information on its profile:')    
</p>
<ul>
@foreach ($dataChanges as $data)
@php
    $text = str_replace('blue', 'black', $data);
    $text = str_replace('underline', 'none', $text);
@endphp
<li>{!! $text !!}</li>    
@endforeach
</ul>
<p>@lang('Click the button to review the modifications.')</p>

@component('mail::button', ['url' =>$urlEmail])
@lang('Review profile')
@endcomponent

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent

