<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Rental;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $item = Item::where([
            ['code', $_GET['item']],
            ['status', 1],
        ])->with(['stuffs', 'locations', 'sources', 'stuffs.categories'])->first();

        $rentals = Rental::where([
            ['status', 1],
            ['id_item', $item['id']],
            ['returned_date', '!=', null],
        ])->with('users')->orderBy('rental_date', 'DESC')->get();
        // dd($rentals);
        return view('public.v_detail_item', compact(['item', 'rentals']));
    }
}
