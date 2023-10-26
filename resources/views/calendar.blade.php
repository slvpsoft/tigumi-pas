<!-- calendar.blade.php -->

<table>
    <tr>
        <th>Sun</th>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
    </tr>
    <tr>
        {{-- @for($i = 1; $i < $firstDay; $i++)
            <td></td>
        @endfor --}}

        @for($day = 1; $day <= $daysInMonth; $day++)
            @if(($day + $firstDay - 1) % 7 == 1 && $day != 1)
                </tr><tr>
            @endif
            <td>{{ $day }}</td>
        @endfor
    </tr>
</table>
