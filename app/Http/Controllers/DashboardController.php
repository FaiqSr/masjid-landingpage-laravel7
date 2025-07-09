<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDF;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home.home');
    }

    public function ganti_setting()
    {
        return view('home.ganti_setting');
    }

    public function reset_usersetting(Request $request)
    {

        DB::table('tbl_setting')
            ->where('id', '=', '1')
            ->update([
                'tentang_kami' => $request->tentang_kami,
            ]);

        return redirect()->back()->with('edit_sukses', 1);
    }
}
