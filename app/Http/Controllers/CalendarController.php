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
        /**
         * 表示する年月の取得を行う
         * 2019-11のような形でCarbonへ渡し、取得する
         */
        if ($request->has('Ym')) {
            $targetDate = new Carbon($request->input('Ym'));
        } else {
            $getToday = Carbon::today();
            $targetDate = new Carbon($getToday->format('Y-m'));
        }

        $nowYear = $targetDate->format('Y');
        $nowMonth = $targetDate->format('m');
        $nowYearMonth = $targetDate->format('Y-m');
        $currentMonthDays = $targetDate->daysInMonth;
        // 月初めの曜日番号
        $firstDayNumberOfNowMonth = $targetDate->format('N');
        $lastMonth = $targetDate->subMonth(1)->format('Y-m');
        $nextMonth = $targetDate->addMonthsNoOverflow(2)->format('Y-m');

        $user = Auth::user();

        /**
         *  練習記録を全て取得する
         *  
         * ユーザー数や練習記録の日が増えたら処理が遅くなるのではないか？
         */
        $practiceAllMyDates = DB::table('points')
        ->whereRaw("user_id = $user->id")
        ->whereYear('date', '=', "$nowYear")
        ->whereMonth('date', '=', "$nowMonth")
        ->orderBy('date')
        ->get();

        /**
         * 練習記録から重複を削除し、練習日の重複しない一覧を取得する
         * 
         * before : 1,1,2,3,3,3,4....
         * after : 1,2,3,4...
         */
        $practiceMyDates = [];
        foreach ($practiceAllMyDates as $value) {
            array_push($practiceMyDates, $value->date);
        }

        /**
         * 練習した年月日から練習した日だけを取得する
         */
        $practiceDays = [];
        foreach ($practiceMyDates as $value) {
            $practiceDay = new Carbon($value);
            $practiceDays[] = $practiceDay->format('d');
        }
        $practiceDays = array_unique($practiceDays);

        /**
         * カレンダーの一行目の前月の空白部分になる日数の取得を行う
         */
        $lastMonthDays = [];
        if ($firstDayNumberOfNowMonth != 1) {
            for ($i = 1; $i < $firstDayNumberOfNowMonth; $i++) {
                $lastMonthDays[] = $i;
            }
        }
        $weekNumber = $i;
 
        // 今月の表示日数の取得
        $days = [];
        $thisMonthTemplate = [];
        for ($i = 1; $i <= $currentMonthDays; $i++) {

            // 日曜日を超えてしまった場合月曜日にする
            if ($weekNumber == 8) {
                $weekNumber = 1;
            }

            // 練習しているかどうかの日付のチェックを行う
            $day = $i;
            $firstValue = reset($practiceDays);

            $href = 'href="dashboard?Ymd=' . $nowYear. '-' . $nowMonth . '-' . $day . '"';
            $textWhiteClass = 'class="text-white"';

            if ($firstValue == $day) {
                $thisMonthTemplate[] = '<td class="bg-info text-center">' . "<a $href $textWhiteClass >$day</a></td>";
                array_shift($practiceDays);
            } else {
                $thisMonthTemplate[] = '<td class="bg-white text-center">' . "<a $href>$day</a></td>";
            }

            // 日曜日の場合改行をする
            if ($weekNumber == 7) {
                $thisMonthTemplate[] = "</tr>";
            }
            
            array_push($days, $weekNumber);
            $weekNumber++;
        }
         
        // 次月の表示日数の取得
        $nextMonthDays = '';
        if ($weekNumber != 8) {
            $nextMonthDays = 8 - $weekNumber;
        }

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
            'lastMonth' => $lastMonth,
            'lastMonthDays' => $lastMonthDays,
            'nextMonth' => $nextMonth,
            'nextMonthDays' => $nextMonthDays,
            'nowYear' => $nowYear,
            'nowMonth' => $nowMonth,
            'weeks' => $weeks,
            'thisMonthTemplate' => $thisMonthTemplate,
        ]);
    }
}
