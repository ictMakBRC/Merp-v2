@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('assets/images/logos/merp-logo.png') }}" class="logo" alt="Merp Logo">
@else
<img src="{{ asset('assets/images/logos/merp-logo.png') }}" class="logo" alt="Merp Logo">
{{ $slot }}
@endif
</a>
</td>
</tr>
