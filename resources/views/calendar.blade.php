@extends('layouts.app')

@section('content')

<div class="container">
    <div class="text-center">
        {{ $year }} - {{ $month }}
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            @foreach ($weeks as $jaDayOfWeek => $enDayOfWeek)
            <th class="{{ $enDayOfWeek }} text-center">{{ $jaDayOfWeek }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach ($dates as $date)
            @if ($date->dayOfWeek == 0)
                <tr>
            @endif
                <td
                    @if ($date->year != $currentYear || $date->month != $currentMonth)
                        class="bg-secondary"
                    
                    @elseif ($date->year == $currentYear && $date->month == $currentMonth && $date->day == $currentDay)
                        class="bg-primary"
                    
                    @endif
                >
                {{ $date->day }}
                </td>
            @if ($date->dayOfWeek == 6)
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

@endsection