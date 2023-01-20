<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Consumable;
use App\Models\Extermination;
use App\Models\Item;
use App\Models\Procurement;
use App\Models\Rental;
use App\Models\Stuff;
use App\Models\Type;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function stuff()
    {
        session()->put('title', 'Barang');
        $stuffs = [];
        $type = Type::where('status', '!=', 0)->get();
        foreach ($type as $tp) {
            $stuff = Stuff::where([
                ['id_type', $tp->id],
                ['status', '!=', 0],
            ])->with(['suppliers', 'categories'])->orderBy('stuffs.id_category', 'asc')->get();
            $stuffs[] = [
                'id' => $tp->id,
                'type' => $tp->name,
                'group' => $tp->group,
                'stuff' => $stuff
            ];
        }
        return view('content.report.stuffs.v_stuff', compact('stuffs'));
    }

    public function item()
    {
        session()->put('title', 'Item');
        $categories = [];

        $type = Type::where('status', '!=', 0)->get();

        foreach ($type as $tp) {
            $categories[] = [
                'id' => $tp->id,
                'type' => $tp->name,
                'group' => $tp->group,
                'categories' => Category::where([
                    ['status', '!=', 0],
                    ['id_type', $tp->id]
                ])->select('id', 'name')->get()
            ];
        }
        // dd($categories);

        $item = collect($categories)->map(function ($a) {
            return (array) $a;
        })->toArray();
        // dd($item);
        foreach ($item as $tak => $tav) {
            $other_categories = [];
            foreach ($tav['categories'] as $cat) {
                $items = Item::join('stuffs as st', 'st.id', '=', 'items.id_stuff')
                    ->where([
                        ['st.id_category', $cat->id],
                        ['st.status', '!=', 0],
                    ])
                    // ->orderBy('st.name', 'ASC')
                    ->orderBy('items.id', 'ASC')
                    ->select('items.*')
                    ->with('stuffs', 'stuffs.categories', 'locations')
                    ->get();

                $other_categories[] = [
                    'id' => $cat->id,
                    'name' => $cat->nama,
                    'total_item' => count($items),
                    'items' => $items
                ];
            }
            $item[$tak]['categories'] = $other_categories;
        }
        // dd($item);
        return view('content.report.items.v_item', compact('item'));
    }

    public function consumable(Request $request)
    {
        session()->put('title', 'Penggunaan Barang Habis Pakai');
        $consumable = Consumable::where([
            ['status', '!=', 0],
        ])->with(['stuffs', 'users'])->get();
        if ($request->has('download')) {
            $pdf = PDF::loadView('content.report.consumables.v_print_consumable', compact("consumable"));
            return $pdf->stream();
        }
        return view('content.report.consumables.v_consumable', compact('consumable'));
    }

    public function rental(Request $request)
    {
        session()->put('title', 'Peminjaman Barang');
        $rental = Rental::where([
            ['status', '!=', 0],
        ])->with(['stuffs', 'users', 'items'])->get();
        if ($request->has('download')) {
            $pdf = PDF::loadView('content.report.rentals.v_print_rental', compact("rental"));
            return $pdf->stream();
        }
        return view('content.report.rentals.v_rental', compact('rental'));
    }

    public function procurement(Request $request)
    {
        session()->put('title', 'Usulan Pengadaan');
        $procurement = Procurement::where([
            ['status', '!=', 0],
        ])->with(['stuffs', 'users'])->get();
        if ($request->has('download')) {
            $pdf = PDF::loadView('content.report.procurements.v_print_procurement', compact("procurement"));
            return $pdf->stream();
        }
        return view('content.report.procurements.v_procurement', compact('procurement'));
    }

    public function extermination(Request $request)
    {
        session()->put('title', 'Pemusnahan Barang');
        $extermination = Extermination::where([
            ['status', '!=', 0],
        ])->with(['stuffs', 'items', 'stuffs.categories', 'stuffs.types'])->get();
        if ($request->has('download')) {
            $pdf = PDF::loadView('content.report.exterminations.v_print_extermination', compact("extermination"));
            return $pdf->stream();
        }
        return view('content.report.exterminations.v_extermination', compact('extermination'));
    }
}
