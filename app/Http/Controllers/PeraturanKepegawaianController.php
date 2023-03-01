<?php

namespace App\Http\Controllers;

use App\Models\PeraturanKepegawaian;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;

class PeraturanKepegawaianController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Peraturan Kepegawaian";
        $peraturan_kepegawaian =PeraturanKepegawaian::orderBy('id','ASC')->paginate(10);
		return view('admin.peraturan_kepegawaian.index',compact('title','peraturan_kepegawaian'));
    }

    ## Tampilkan Form Edit
    public function edit(PeraturanKepegawaian $peraturan_kepegawaian)
    {
        $title = "Peraturan Kepegawaian";
        $view=view('admin.peraturan_kepegawaian.edit', compact('title','peraturan_kepegawaian'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, PeraturanKepegawaian $peraturan_kepegawaian)
    {
        $this->validate($request, [
            'isi' => 'required'
        ]);

		$peraturan_kepegawaian->fill($request->all());
			
    	$peraturan_kepegawaian->save();
		
		return redirect('/peraturan_kepegawaian')->with('status', 'Data Berhasil Diubah');
    }
    
    ## Tampilkan Form Detail
    public function detail(PeraturanKepegawaian $peraturan_kepegawaian)
    {
        $title = "Peraturan Kepegawaian";
        $view=view('admin.peraturan_kepegawaian.detail', compact('title','peraturan_kepegawaian'));
        $view=$view->render();
        return $view;
    }
}
