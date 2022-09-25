<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Article;
use App\Models\Tour;
use App\Models\TourBook;
use App\Models\Contact;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        //Cập nhập lại session login
        $user = \App\Models\User::where(["id" => Auth::user()->id])->first();
        $temp_permission = [];
        $roles = $user->roles;
        foreach ($roles as $k => $v) {
            $permissions = $v->permissions;
            foreach ($permissions as $v2) {
                if ($v2['parent_id'] == 22) {
                    $temp_permission[] = $v2['key_code'];
                }
            }
        }
        setcookie('authImagesManager', json_encode(array(
            'domain' => env('APP_URL_UPLOAD'),
            'email' => $user->email,
            'permission' => $temp_permission,
            'folder_upload' => ($user->id * 168) * 168 + 168,
        )), time() + (86400 * 30), '/');
        //end

        $module = 'dashboard';
        $totalProduct = Product::where(['alanguage' => config('app.locale')])->count();
        $totalArticle = Article::where(['alanguage' => config('app.locale')])->count();
        $totalTour = Tour::where(['alanguage' => config('app.locale')])->count();
        $totalTourBook = TourBook::count();
        $totalContact = Contact::where(['type' => 'contact'])->count();
        $totalOrder = Order::count();
        $dropdown = getFunctions();
        //7 ngày qua
        $data = [];
        $date = date('Y-m-d');
        $date = strtotime($date);
        $dateStart = date('Y-m-d', strtotime("-6 day", $date));
        $dayOfWeek = [];
        for ($i = 0; $i <= 6; $i++) {
            $dayOfWeek[] = date('Y-m-d', strtotime("+$i day", strtotime($dateStart)));
        }
        if (!empty($dayOfWeek)) {
            $dayOfWeekQuery = Order::where('created_at', '>=', current($dayOfWeek) . " 00:00:00")->where('created_at', '<=', end($dayOfWeek) . " 23:59:59")
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                ->orderBy('created_at', 'asc')
                ->get(array(
                    DB::raw('Date(created_at) as date'),
                    DB::raw('COUNT(*) as "count"')
                ));

            foreach ($dayOfWeek as $k => $value) {
                $data[$value]['x'] = $value;
                $data[$value]['y'] = 0;
            }
            if (count($dayOfWeekQuery) > 0) {
                foreach ($dayOfWeekQuery as $day) {
                    $data[$day->date]['x'] = $day->date;
                    $data[$day->date]['y'] = $day->count;
                }
            }
        }
        //end

        return view('dashboard.home.index', compact('module', 'dropdown', 'totalProduct', 'totalArticle', 'totalTour', 'totalContact', 'data', 'totalTourBook', 'totalOrder'));
    }
    public function searchBookTour(Request $request)
    {
        $value = $request->value;
        $data = [];
        if ($value == 'week') {
            //7 ngày qua
            $date = date('Y-m-d');
            $date = strtotime($date);
            $dateStart = date('Y-m-d', strtotime("-6 day", $date));
            $dayOfWeek = [];
            for ($i = 0; $i <= 6; $i++) {
                $dayOfWeek[] = date('Y-m-d', strtotime("+$i day", strtotime($dateStart)));
                // echo strtotime( '+1 days' )->format('Y-m-d') . '<br>';
            }
            //endif
            if (!empty($dayOfWeek)) {
                $dayOfWeekQuery = Order::where('created_at', '>=', current($dayOfWeek) . " 00:00:00")->where('created_at', '<=', end($dayOfWeek) . " 23:59:59")
                    ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                    ->orderBy('created_at', 'asc')
                    ->get(array(
                        DB::raw('Date(created_at) as date'),
                        DB::raw('COUNT(*) as "count"')
                    ));

                foreach ($dayOfWeek as $k => $value) {
                    $data[$value]['x'] = $value;
                    $data[$value]['y'] = 0;
                }
                if (count($dayOfWeekQuery) > 0) {
                    foreach ($dayOfWeekQuery as $day) {
                        $data[$day->date]['x'] = $day->date;
                        $data[$day->date]['y'] = $day->count;
                    }
                }
            }
        } else if ($value == 'month') {
            $dayOfMonthQuery = Order::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)
                ->select(DB::raw("DAY(created_at) day"), DB::raw("count('day') as count"))
                ->groupby('day')
                ->get();
            $start_date =  Carbon::now()->firstOfMonth();
            $end_date =  Carbon::now()->copy()->endOfMonth();
            $start_date_format = Carbon::parse($start_date)->format('d');
            $end_date_format = Carbon::parse($end_date)->format('d');
            for ($i = $start_date_format; $i <= $end_date_format; $i++) {
                $data[str_pad($i, 2, "0", STR_PAD_LEFT)]['x'] = '2022-08-' . (int)str_pad($i, 2, "0", STR_PAD_LEFT);
                $data[str_pad($i, 2, "0", STR_PAD_LEFT)]['y'] = 0;
            }
            if (count($dayOfMonthQuery) > 0) {
                foreach ($dayOfMonthQuery as $day) {
                    $data[$day->day]['y'] = $day->count;
                }
            }
        } else if ($value == 'month_before') {
            //lấy tháng trước
            $month = (int)Carbon::now()->month - 1;
            $dayOfMonthQuery = Order::whereMonth('created_at', $month)->whereYear('created_at', Carbon::now()->year)
                ->select(DB::raw("DAY(created_at) day"), DB::raw("count('day') as count"))
                ->groupby('day')
                ->get();
            $start_date = Carbon::now()->startOfMonth()->subMonth()->toDateString();
            $end_date =  Carbon::now()->subMonth()->endOfMonth()->toDateString();
            $start_date_format = Carbon::parse($start_date)->format('d');
            $end_date_format = Carbon::parse($end_date)->format('d');
            for ($i = $start_date_format; $i <= $end_date_format; $i++) {
                $data[str_pad($i, 2, "0", STR_PAD_LEFT)]['x'] = '2022-' . $month . '-' . (int)str_pad($i, 2, "0", STR_PAD_LEFT);
                $data[str_pad($i, 2, "0", STR_PAD_LEFT)]['y'] = 0;
            }
            if (count($dayOfMonthQuery) > 0) {
                foreach ($dayOfMonthQuery as $day) {
                    $data[$day->day]['y'] = $day->count;
                }
            }
        } else if ($value == 'year') {
            $totalMonthOfYear = Order::whereYear('created_at', Carbon::now()->year)
                ->select(DB::raw("MONTH(created_at) month"), DB::raw("count('month') as count"))
                ->groupby('month')
                ->get();
            for ($i = 1; $i <= 12; $i++) {
                $data[$i]['x'] = $i . '-' . date('Y');
                $data[$i]['y'] = 0;
            }
            if (count($totalMonthOfYear) > 0) {
                foreach ($totalMonthOfYear as $month) {
                    $data[$month->month]['y'] = $month->count;
                }
            }
        }
        return response()->json([
            'data' => $data
        ]);
    }
}
