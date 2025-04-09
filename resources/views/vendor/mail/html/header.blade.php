@props(['url'])
<tr>
<td class="header-td">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img style="height: 24px!important;width: auto!important;" src="https://lexpertetatdeslieux.fr/wp-content/uploads/logo-1.png" class="logo" alt="Opper logo" height="32px">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
