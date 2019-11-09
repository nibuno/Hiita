<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Point;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $requestYm = $request->input('Ym');

        // 実行した年月日を取得
        $currentDays = new Carbon();
        $currentYear = $currentDays->format('Y');
        $currentMonth = $currentDays->format('m');
        $currentYearMonth = $currentDays->format('Y-m');
        $currentDay = $currentDays->format('d');
        $daysInMonth = $currentDays->daysInMonth;

        // 月の初日を取得
        // '2019-10'にはYmがあればYmを なければ当日の日を入れる

        if ($request->has('Ym')) {
            $requestDay = new Carbon($requestYm);
            $year = $requestDay->format('Y');
            $month = $requestDay->format('m');
            $day = $requestDay->format('d');
            $yearMonth = $requestDay->format('Y-m');
            $currentMonthDays = $requestDay->daysInMonth;

            // 月の初日を取得
            // '2019-10'にはYmがあればYmを なければ当日の日を入れる
            $firstDayOfMonth = $requestDay->format('N');
            $daysInMonth = $requestDay->daysInMonth;

            $lastYearMonth = $requestDay->subMonth(1)->format('Y-m');
            $nextYearMonth = $requestDay->addMonth(2)->format('Y-m');
        } else {
            $year = Carbon::today()->format('Y');
            $month = Carbon::today()->format('m');
            $day = Carbon::today()->format('d');
            $yearMonth = Carbon::today()->format('Ym');
            $firstDayOfMonth = $currentDays->format('N');
            $currentMonthDays = $currentDays->daysInMonth;

            $lastYearMonth = $currentDays->subMonth(1)->format('Y-m');
            $nextYearMonth = $currentDays->addMonth(2)->format('Y-m');
        }

        // 前月の表示日数の取得
        $lastMonthDays = [];
        $i = 1;
        if ($firstDayOfMonth != 1) {
            for ($i = 1; $i < $firstDayOfMonth; $i++) {
                $lastMonthDays[] = $i;
            }
        }
        $weekNumber = $i;

        // 今月の表示日数の取得
        $days = [];
        for ($i = 1; $i <= $currentMonthDays; $i++) {
            // 日曜日を超えたらリセットする
            if ($weekNumber == 8) {
                $weekNumber = 1;
            }
            array_push($days, $weekNumber);
            $weekNumber++;
        }

        // 次月の表示日数の取得
        $nextMonthDays = '';
        if ($weekNumber != 8) {
            $nextMonthDays = 8 - $weekNumber;
        }

        $user = Auth::user();

        // ここで日付を指定することで希望のデータを取得できるはず
        $pointsMyDates = DB::table('points')
        ->whereRaw("user_id = $user->id")
        ->whereYear('date', '=', "$year")
        ->whereMonth('date', '=', "$month")
        ->orderBy('date')
        ->get();

        $myDates = [];
        foreach ($pointsMyDates as $value) {
            array_push($myDates, $value->date);
        }

        $practiceDays = [];

        foreach ($myDates as $value) {
            $practiceDay = new Carbon($value);
            $practiceDays[] = $practiceDay->format('d');
        }

        $practiceDays = array_unique($practiceDays);



        $myDates = array_unique($myDates);

        $weeks = [
            '月' => 'monday',
            '火' => 'tuesday',
            '水' => 'wednesday',
            '木' => 'thursday',
            '金' => 'friday',
            '土' => 'saturday',
            '日' => 'sunday',
          ];

        return view('calendar', [
            'daysInMonth' => $daysInMonth,
            'firstDayOfMonth' => $firstDayOfMonth,
            'lastYearMonth' => $lastYearMonth,
            'lastMonthDays' => $lastMonthDays,
            'nextYearMonth' => $nextYearMonth,
            'currentYearMonth' => $currentYearMonth,
            'nextMonthDays' => $nextMonthDays,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'days' => $days,
            'currentYear' => $currentYear,
            'currentMonth' => $currentMonth,
            'currentMonthDays' => $currentMonthDays,
            'currentDay' => $currentDay,
            'weeks' => $weeks,
            'myDates' => $myDates,
            'practiceDays' => $practiceDays,
        ]);
    }
}
