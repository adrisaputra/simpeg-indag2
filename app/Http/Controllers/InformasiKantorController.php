<?php

namespace App\Http\Controllers;

use App\Models\InformasiKantor;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;

class InformasiKantorController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Informasi Kantor";
        $informasi_kantor =InformasiKantor::orderBy('id','ASC')->paginate(10);
		return view('admin.informasi_kantor.index',compact('title','informasi_kantor'));
    }

    ## Tampilkan Form Edit
    public function edit(InformasiKantor $informasi_kantor)
    {
        $title = "Informasi Kantor";
        $view=view('admin.informasi_kantor.edit', compact('title','informasi_kantor'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, InformasiKantor $informasi_kantor)
    {
         $this->validate($request, [
            'isi' => 'required'
        ]);

		$informasi_kantor->fill($request->all());
			
    	$informasi_kantor->save();
		
		return redirect('/informasi_kantor')->with('status', 'Data Berhasil Diubah');
    }
    
    ## Tampilkan Form Detail
    public function detail(InformasiKantor $informasi_kantor)
    {
        $title = "Informasi Kantor";
        $view=view('admin.informasi_kantor.detail', compact('title','informasi_kantor'));
        $view=$view->render();
        return $view;
    }

}
