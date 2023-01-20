<?php

namespace App\Http\Controllers;

use App\Models\BrokenAction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BrokenActionController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Tindakan Pemusnahan');
        $broken_action = BrokenAction::where('status', '!=', 0);
        if ($request->ajax()) {
            return DataTables::of($broken_action)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
                    <a href="javascript:void(0)" class="m-portlet__nav-link m-dropdown__toggle btn m-btn m-btn--link">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="m-dropdown__wrapper" style="width: 120px">
                        <span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner" style="width: 120px">
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">
                                        <li class="m-nav__item">
                                            <a href="javascript:void(0)" onclick="editData(' . $row['id'] . ')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-edit"></i>
                                                <span class="m-nav__link-text">Edit</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-delete"></i>
                                                <span class="m-nav__link-text">Hapus</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('content.broken_actions.v_index');
    }

    public function store(Request $request)
    {
        BrokenAction::updateOrCreate(
            ['id' => $request->id],
            $request->toArray()
        );
        return response()->json([
            'message' => 'Tindakan Pemusnahan berhasil disimpan',
            'status' => true,
        ], 200);

    }

    public function detail(Request $request)
    {
        return response()->json(BrokenAction::find($request['id']));
    }

    public function delete(Request $request)
    {
        $broken_action = BrokenAction::find($request->id);
        $broken_action->update(array('status' => 0));
        return response()->json([
            'message' => 'Tindakan Pemusnahan berhasil dihapus',
            'status' => true,
        ], 200);
    }
}
