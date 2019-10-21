<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $requestYm = $request->input('Ym');

        // 実行した年月日を取得
        $currentDays = new Carbon();
        $currentYear = $currentDays->format('Y');
        $currentMonth = $currentDays->format('m');
        $currentDay = $currentDays->format('d');

        if (!$request->has('Ym')) {
            $year = Carbon::today()->format('Y');
            $month = Carbon::today()->format('m');
            $day = Carbon::today()->format('d');
            $yearMonth = Carbon::today()->format('Ym');
        } else {
            $requestDay = new Carbon($requestYm);
            $year = $requestDay->format('Y');
            $month = $requestDay->format('m');
            $day = $requestDay->format('d');
            $yearMonth = $requestDay->format('Ym');
        }

        $weeks = [
            '日' => 'sunday',
            '月' => 'monday',
            '火' => 'tuesday',
            '水' => 'wednesday',
            '木' => 'thursday',
            '金' => 'friday',
            '土' => 'saturday',
          ];

        /**
         * https://crieit.net/posts/Laravel-Carbon
         * こちらを利用させてもらう
         */
        $dateStr = sprintf('%04d-%02d-01', $year, $month);
        $date = new Carbon($dateStr);

        // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
        $date->subDay($date->dayOfWeek);
        // 同上。右下の隙間のための計算。
        $count = 31 + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $dates = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            // copyしないと全部同じオブジェクトを入れてしまうことになる
            $dates[] = $date->copy();
        }

        return view('calendar', [
            'dates' => $dates,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'currentYear' => $currentYear,
            'currentMonth' => $currentMonth,
            'currentDay' => $currentDay,
            'weeks' => $weeks,
        ]);
    }
}
