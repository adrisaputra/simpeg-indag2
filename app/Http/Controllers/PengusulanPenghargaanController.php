<?php

namespace App\Http\Controllers;

use App\Models\PengusulanPenghargaan;   //nama model
use App\Models\Pegawai;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengusulanPenghargaanController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Pengusulan Penghargaan";
		$pengusulan_penghargaan = PengusulanPenghargaan::orderBy('id','DESC')->paginate(10);
		return view('admin.pengusulan_penghargaan.index',compact('title','pengusulan_penghargaan'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Pengusulan Penghargaan";
        $pengusulan_penghargaan = $request->get('search');
		$pengusulan_penghargaan = PengusulanPenghargaan::
                where(function ($query) use ($pengusulan_penghargaan) {
                    $query->where('nip', 'LIKE', '%'.$pengusulan_penghargaan.'%')
                        ->orWhere('nama_pegawai', 'LIKE', '%'.$pengusulan_penghargaan.'%')
                        ->orWhere('jenis', 'LIKE', '%'.$pengusulan_penghargaan.'%')
                        ->orWhere('syarat', 'LIKE', '%'.$pengusulan_penghargaan.'%');
                })
                ->orderBy('id','DESC')->paginate(10);
		return view('admin.pengusulan_penghargaan.index',compact('title','pengusulan_penghargaan'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = "Pengusulan Penghargaan";
        $pegawai = Pegawai::where('status_hapus', 0)->orderBy('id','DESC')->get();
        $view=view('admin.pengusulan_penghargaan.create', compact('title','pegawai'));
        $view=$view->render();
        return $view;
    }
	
	## Simpan Data
	public function store(Request $request)
    {
		$this->validate($request, [
            'nama_pegawai' => 'required',
            'jenis' => 'required',
            'syarat' => 'required'
		]);
		
        $pegawai = Pegawai::where('nip', $request->nama_pegawai)->get();
        $pegawai->toArray();
        $input['nip'] = $pegawai[0]->nip;
        $input['nama_pegawai'] = $pegawai[0]->nama_pegawai;
        $input['jenis'] = $request->jenis;
        $input['syarat'] = $request->syarat;
        $input['user_id'] = Auth::user()->id;

        PengusulanPenghargaan::create($input);
		
		return redirect('/pengusulan_penghargaan')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(PengusulanPenghargaan $pengusulan_penghargaan)
    {
        $title = "Pengusulan Penghargaan";
        $pegawai = Pegawai::where('status_hapus', 0)->orderBy('id','DESC')->get();
        $view=view('admin.pengusulan_penghargaan.edit', compact('title','pengusulan_penghargaan','pegawai'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, PengusulanPenghargaan $pengusulan_penghargaan)
    {
		$this->validate($request, [
            'nama_pegawai' => 'required',
            'jenis' => 'required',
            'syarat' => 'required'
		]);
		
        $pengusulan_penghargaan->fill($request->all());
        $pegawai = Pegawai::where('nip', $request->nama_pegawai)->get();
        $pegawai->toArray();
        $pengusulan_penghargaan->nip = $pegawai[0]->nip;
        $pengusulan_penghargaan->nama_pegawai = $pegawai[0]->nama_pegawai;
        $pengusulan_penghargaan->user_id = Auth::user()->id;
        $pengusulan_penghargaan->save();
    
		return redirect('/pengusulan_penghargaan')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(PengusulanPenghargaan $pengusulan_penghargaan)
    {
		$pengusulan_penghargaan->delete();
		
		return redirect('/pengusulan_penghargaan')->with('status', 'Data Berhasil Dihapus');
    }
}
