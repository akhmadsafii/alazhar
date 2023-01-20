<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Helpers\StatusHelper;
use App\Models\Extermination;
use App\Models\Item;
use App\Models\Procurement;
use App\Models\Rental;
use App\Models\Stuff;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Json;

class DashboardController extends Controller
{
    public function admin()
    {

        $statistic = array(
            'rentals' => Rental::where([
                ['status', 1],
            ])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'procurement' => Procurement::where([
                ['status', 1],
            ])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'extermination' => Extermination::where([
                ['status', 1],
            ])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'stuff' => Stuff::where('status', 1)->count(),
            'item' => Item::where('status', 1)->count(),
            'broken_item' => Item::where([
                ['status', 1],
                ['condition', 'broken'],
            ])->count(),
            'rental_not_back' => Rental::where([
                ['status', 1],
                ['returned_date', null],
            ])->count(),
        );

        $item_sarana = $this->item_base_type('sarana');
        $rental_sarana = $this->rental_base_type('sarana');
        $item_prasarana = $this->item_base_type('prasarana');
        $rental_prasarana = $this->rental_base_type('prasarana');
        $statistic['item_sarana'] = 0;
        if ($item_sarana > 0 && $rental_sarana == 0) {
            $statistic['item_sarana'] = 100;
        }
        if ($item_sarana > 0 && $rental_sarana > 0) {
            $statistic['item_sarana'] = $item_sarana / $rental_sarana * 100;
        }

        $statistic['item_prasarana'] = 0;
        if ($item_prasarana > 0 && $rental_prasarana == 0) {
            $statistic['item_prasarana'] = 100;
        }
        if ($item_prasarana > 0 && $rental_prasarana > 0) {
            $statistic['item_prasarana'] = $item_prasarana / $rental_prasarana * 100;
        }

        return view('content.dashboard.v_admin', compact('statistic'));
    }

    public function user()
    {
        $statistic = array(
            'rentals' => Rental::where([
                ['id_user', Auth::guard('user')->id()],
                ['status', 1]
            ])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'procurement' => Procurement::where([
                ['id_user', Auth::guard('user')->id()],
                ['status', 1],
            ])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'item_not_back' => Rental::where([
                ['id_user', Auth::guard('user')->id()],
                ['status', 1],
                ['returned_date', null]
            ])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'item_back' => Rental::where([
                ['id_user', Auth::guard('user')->id()],
                ['status', 1],
                ['returned_date', '!=', null]
            ])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            // 'extermination' => Extermination::where([
            //     ['status', 1],
            // ])
            //     ->whereYear('created_at', Carbon::now()->year)
            //     ->whereMonth('created_at', Carbon::now()->month)
            //     ->count(),
            // 'stuff' => Stuff::where('status', 1)->count(),
            // 'item' => Item::where('status', 1)->count(),
            // 'broken_item' => Item::where([
            //     ['status', 1],
            //     ['condition', 'broken'],
            // ])->count(),
            // 'rental_not_back' => Rental::where([
            //     ['status', 1],
            //     ['returned_date', null],
            // ])->count(),
        );
        return view('content-users.dashboard.v_dashboard', compact('statistic'));
    }

    function item_base_type($group)
    {
        $item = DB::table('items as it')
            ->join('stuffs as st', 'st.id', '=', 'it.id_stuff')
            ->join('types as tp', 'tp.id', '=', 'st.id_type')
            ->where('it.status', '!=', 0)
            ->where('tp.group', $group)->count();
        return $item;
    }

    function rental_base_type($group)
    {
        $rental = DB::table('rentals as rt')
            ->join('stuffs as st', 'st.id', '=', 'rt.id_stuff')
            ->join('types as tp', 'tp.id', '=', 'st.id_type')
            ->where('rt.status', 1)
            ->where('tp.group', $group)->count();
        return $rental;
    }

    public function statistic_chart(Request $request)
    {
        $sarana = DB::table('items as it')
            ->join('stuffs as st', 'st.id', '=', 'it.id_stuff')
            ->join('types as tp', 'tp.id', '=', 'st.id_type')
            ->where('it.status', '!=', 0)
            ->where('tp.group', 'sarana')
            ->whereYear('it.created_at', '=', date("Y"))
            ->selectRaw('monthname(it.created_at) month, count(*) sarana')
            ->groupBy('month')
            ->get();
        $prasarana = DB::table('items as it')
            ->join('stuffs as st', 'st.id', '=', 'it.id_stuff')
            ->join('types as tp', 'tp.id', '=', 'st.id_type')
            ->where('it.status', '!=', 0)
            ->where('tp.group', 'prasarana')
            ->whereYear('it.created_at', '=', date("Y"))
            ->selectRaw('monthname(it.created_at) month, count(*) prasarana')
            ->groupBy('month')
            ->get();

        $merged = $sarana->merge($prasarana);
        $items = $merged->all();
        foreach ($items as $entry) {
            if (!isset($result[$entry->month])) {
                $result[$entry->month] = $entry;
            } else {
                foreach ($entry as $key => $value) {
                    $result[$entry->month]->$key = $value;
                }
            }
        }
        $area_chart = [];
        foreach ($result as $rs) {
            $area_chart[] = [
                'y' => $rs->month,
                'a' => $rs->prasarana ?? 0,
                'b' => $rs->sarana ?? 0,
            ];
        }
        return response()->json($area_chart);
    }


    public function not_back()
    {
        $rentals = Rental::select(['rentals.*'])->with('users', 'stuffs', 'items')->where([
            ['rentals.returned_date', '=', null],
            ['rentals.status', 1]
        ])->orderBy('id', 'desc');
        $table = datatables()->of($rentals)
            ->editColumn('detail', function ($rental) {
                return '<span class="m-widget4__text font-weight-bold">
                ' . $rental->stuffs->name . '  -  ' . $rental->items->name . '
            </span> <br>
            <small>Dipinjam tanggal ' . DateHelper::getTanggal($rental['rental_date']) . ' oleh ' . $rental->users->name . '</small>';
            })
            ->editColumn('status', function ($rental) {
                if (date("Y-m-d H:i:s") < $rental['return_date']) {
                    $status = '<span class="m-badge m-badge--primary m-badge--wide">Kembali ' . DateHelper::getTanggal($rental['return_date']) . '</span>';
                } else {
                    $date1 = new DateTime($rental['return_date']);
                    $date2 = new DateTime(date("Y-m-d H:i:s"));
                    $distance = $date2->diff($date1)->format('%a');
                    $status = '<span class="m-badge m-badge--danger m-badge--wide">Terlambat ' . $distance . ' hari</span>';
                }
                return $status;
            });
        $table->rawColumns(['detail', 'status']);
        $table->addIndexColumn();
        return $table->make(true);
    }

    public function last_procurement()
    {
        $procurements = Procurement::select(['procurements.*'])->with('stuffs')->where([
            ['procurements.status', '!=', 0]
        ])->orderBy('id', 'desc')->get();
        $table = datatables()->of($procurements)
            ->editColumn('priority', function ($procurement) {
                if ($procurement['priority'] == 'urgent') {
                    return '<span class="m--font-bold m--font-danger">Mendesak</span>';
                } else {
                    return '<span class="m--font-bold m--font-primary">Normal</span>';
                }
            })
            ->editColumn('date_of_filling', function ($procurement) {
                return DateHelper::getDay($procurement['date_of_filling']);
            })
            ->editColumn('status', function ($procurement) {
                return StatusHelper::procurements($procurement['status']);
            });
        $table->rawColumns(['priority', 'date_of_filling', 'status']);
        $table->addIndexColumn();
        return $table->make(true);
    }

    public function statistic_rental_chart()
    {
        $sarana = DB::table('rentals as rt')
            ->join('stuffs as st', 'st.id', '=', 'rt.id_stuff')
            ->join('types as tp', 'tp.id', '=', 'st.id_type')
            ->where('rt.status', 1)
            ->where('rt.id_user', Auth::guard('user')->id())
            ->where('tp.group', 'sarana')
            ->whereYear('rt.created_at', '=', date("Y"))
            ->selectRaw('monthname(rt.created_at) month, count(*) sarana')
            ->groupBy('month')
            ->get();
        $prasarana = DB::table('rentals as rt')
            ->join('stuffs as st', 'st.id', '=', 'rt.id_stuff')
            ->join('types as tp', 'tp.id', '=', 'st.id_type')
            ->where('rt.status', 1)
            ->where('rt.id_user', Auth::guard('user')->id())
            ->where('tp.group', 'prasarana')
            ->whereYear('rt.created_at', '=', date("Y"))
            ->selectRaw('monthname(rt.created_at) month, count(*) prasarana')
            ->groupBy('month')
            ->get();
        $merged = $sarana->merge($prasarana);
        $items = $merged->all();
        $result = [];
        foreach ($items as $entry) {
            if (!isset($result[$entry->month])) {
                $result[$entry->month] = $entry;
            } else {
                foreach ($entry as $key => $value) {
                    $result[$entry->month]->$key = $value;
                }
            }
        }
        $area_chart = [];
        foreach ($result as $rs) {
            $area_chart[] = [
                'y' => $rs->month,
                'a' => $rs->prasarana ?? 0,
                'b' => $rs->sarana ?? 0,
            ];
        }
        return response()->json($area_chart);
    }

    public function rental_day()
    {
        $current_date = date('Y-m-d');
        $target_date    = date('Y-m-d', strtotime('+7 days', strtotime($current_date)));
        $rentals = Rental::select(['rentals.*'])
            ->where([
                ['status', 1],
                ['id_user', Auth::guard('user')->id()],
            ])
            ->whereBetween('rentals.return_date', [$current_date, $target_date])
            ->with('stuffs', 'items')
            ->orderBy('return_date', 'asc')
            ->get();
        $table = datatables()->of($rentals)
            ->addColumn('detail', function ($rental) {
                return '<span class="m-widget4__text font-weight-bold">
                    ' . $rental->stuffs->name . '  -  ' . $rental->items->name . '
                </span> <br>
                <small>Dipinjam tanggal ' . DateHelper::getTanggal($rental['rental_date']) .'</small>';
            })
            ->editColumn('status', function ($rental) {
                $date1 = new DateTime($rental['return_date']);
                $date2 = new DateTime(date("Y-m-d H:i:s"));
                $distance = $date2->diff($date1)->format('%a');
                return '<span class="m-badge m-badge--danger m-badge--wide">Batas Waktu ' . $distance . ' hari lagi</span>';
            });
        $table->rawColumns(['detail', 'status']);
        $table->addIndexColumn();
        return $table->make(true);
    }
}
