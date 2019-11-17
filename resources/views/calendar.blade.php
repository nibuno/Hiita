@extends('layouts.app')

@section('content')

<div class="container">
    <div class="text-center">
        {{ $nowYear }} / {{ $nowMonth }}
    </div>
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            @foreach ($weeks as $jaDayOfWeek => $enDayOfWeek)
            <th class="{{ $enDayOfWeek }} text-center bg-white">{{ $jaDayOfWeek }}</th>
            @endforeach
        </tr>
        </thead>
        <div class="row text-center">
            <a class="col" href="?Ym={{ $lastMonth }} ">前月</a>
            <a class="col" href="calendar">今月</a>
            <a class="col" href="?Ym={{ $nextMonth }} ">次月</a>
        </div>
            
        <tbody>
            <tr>
                <!-- 先月の部分 -->
                @foreach ($lastMonthDays as $value)
                <td class="bg-white"></td>
                @endforeach

                <!-- 今月 -->
                @foreach ($thisMonthTemplate as $key)
                    {!! $key !!}
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