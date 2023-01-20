<?php

namespace App\Http\Controllers;

use App\Exports\LocationExample;
use App\Imports\LocationImport;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Ruang Lokasi');
        $location = Location::where('status', '!=', 0);
        if ($request->ajax()) {
            return DataTables::of($location)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="editData(' . $row['id'] . ')"><i class="la la-edit"></i> Edit</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')"><i class="la la-trash"></i> Hapus</a>
                    </div>
                </span>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // dd($type);
        $import = array(
            'template' => route('location.template'),
            'upload' => route('location.import')
        );
        return view('content.locations.v_index', compact('import'));
    }

    public function store(Request $request)
    {
        // dd($request);
        Location::updateOrCreate(
            ['id' => $request->id],
            $request->toArray()
        );
        return response()->json([
            'message' => 'Ruangan berhasil disimpan',
            'status' => true,
        ], 200);
    }

    public function detail(Request $request)
    {
        return response()->json(Location::find($request['id']));
    }

    public function delete(Request $request)
    {
        $location = Location::find($request->id);
        $location->update(array('status' => 0));
        return response()->json([
            'message' => 'Ruangan berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function template()
    {
        return Excel::download(new LocationExample, '' . Carbon::now()->timestamp . '_template_ruang_import.xls');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $error_tampil = [];

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
            ], 302);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            try {
                $import = Excel::import(new LocationImport, $file);

                return response()->json([
                    'message' => 'Lokasi barang imported',
                    'status' => true,
                    'data' => []
                ], 200);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();

                foreach ($failures as $failure) {
                    $error_tampil = '' . $failure->errors()[0] . 'pada baris ke-' . $failure->row() . '';
                }

                return response()->json([
                    'message' => $error_tampil
                ], 302);
            }
        }
    }
}
