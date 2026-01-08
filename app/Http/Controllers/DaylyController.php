<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DaylyController extends Controller
{
    public function index()
    {
        $todayFormatted = Carbon::now()->locale('id')
            ->translatedFormat('l, d F Y');

        return view('dayly', compact('todayFormatted'));
    }

    public function process(Request $request)
    {
        $result = [];

        /* =============================
           1. Hari Kerja / Hari Libur
        ==============================*/
        if ($request->work_date) {
            $date = Carbon::parse($request->work_date);
            $day = $date->dayOfWeek;

            $result['workday'] = ($day >= 1 && $day <= 5)
                ? 'Hari Kerja'
                : 'Hari Libur';
        }

        /* =============================
        2. Hitung Umur
        ==============================*/
        if ($request->birth_date) {
            $birth = Carbon::parse($request->birth_date);
            $now = Carbon::now();

            $diff = $birth->diff($now);

            $years  = $diff->y;
            $months = $diff->m;

            $result['age'] = "$years Tahun $months Bulan";
        }

        /* =============================
           3. Validasi Tanggal
        ==============================*/
        if ($request->validate_date) {
            try {
                $date = Carbon::parse($request->validate_date);
                $year = $date->year;

                if ($year < 1900 || $year > 2100) {
                    $result['validation'] = '❌ Tahun harus 1900–2100';
                } else {
                    $result['validation'] = '✅ Tanggal valid';
                }
            } catch (\Exception $e) {
                $result['validation'] = '❌ Format tanggal tidak valid';
            }
        }

        /* =============================
           4. Hitung Jumlah Hari Kerja
        ==============================*/
        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date);
            $end   = Carbon::parse($request->end_date);

            $workdays = 0;

            while ($start <= $end) {
                if ($start->isWeekday()) {
                    $workdays++;
                }
                $start->addDay();
            }

            $result['workdays_count'] = $workdays;
        }

        return redirect('/')->with('result', $result);
    }
}