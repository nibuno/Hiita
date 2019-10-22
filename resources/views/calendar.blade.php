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
            <th class="{{ $enDayOfWeek }} text-center bg-white">{{ $jaDayOfWeek }}</th>
            @endforeach
        </tr>
        </thead>
        <div class="row text-center">
            <a class="col" href="?Ym={{ $lastYearMonth }} ">前月へ</a>
            <a class="col" href="calendar">今月</a>
            <a class="col" href="?Ym={{ $nextYearMonth }} ">次月へ</a>
        </div>
            
        <tbody>
            <tr>
                <!-- 先月の部分 -->
                @foreach ($lastMonthDays as $value)
                <td class="bg-white"></td>
                @endforeach

                <!-- 今月 -->
                @foreach ($days as $key => $value)
                    @if ($value == 7)
                        <td  class="bg-white">{{ $key + 1 }}</td>
                        </tr>
                    @else
                        <td  class="bg-white">{{ $key + 1 }}</td>
                    @endif
                @endforeach

                <!-- 次月 -->
                @for ($i = 0; $i < $nextMonthDays; $i++)
                <td  class="bg-white"></td>
                @endfor

            </tr>
        </tbody>
    </table>
 
</div>

@endsection