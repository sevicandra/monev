@props(['colspan' => 1, 'rowspan' => 1, 'class' => null])
<td colspan= "{{ $colspan }}" rowspan="{{ $rowspan }}"
    class="@if (isset($class)) {{ $class }} @endif">
    {{ $slot }}</td>
