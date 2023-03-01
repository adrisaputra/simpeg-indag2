<?php

namespace App\Http\Controllers;

use App\Models\PengusulanHukuman;   //nama model
use App\Models\Pegawai;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengusulanHukumanController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Penjatuhan Hukuman Disiplin";
		$pengusulan_hukuman = PengusulanHukuman::orderBy('id','DESC')->paginate(10);
		return view('admin.pengusulan_hukuman.index',compact('title','pengusulan_hukuman'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Penjatuhan Hukuman Disiplin";
        $pengusulan_hukuman = $request->get('search');
		$pengusulan_hukuman = PengusulanHukuman::
                where(function ($query) use ($pengusulan_hukuman) {
                    $query->where('nip', 'LIKE', '%'.$pengusulan_hukuman.'%')
                        ->orWhere('nama_pegawai', 'LIKE', '%'.$pengusulan_hukuman.'%')
                        ->orWhere('jenis', 'LIKE', '%'.$pengusulan_hukuman.'%')
                        ->orWhere('alasan', 'LIKE', '%'.$pengusulan_hukuman.'%')
                        ->orWhere('unit_kerja', 'LIKE', '%'.$pengusulan_hukuman.'%');
                })
                ->orderBy('id','DESC')->paginate(10);
		return view('admin.pengusulan_hukuman.index',compact('title','pengusulan_hukuman'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = "Penjatuhan Hukuman Disiplin";
        $pegawai = Pegawai::where('status_hapus', 0)->orderBy('id','DESC')->get();
        $view=view('admin.pengusulan_hukuman.create', compact('title','pegawai'));
        $view=$view->render();
        return $view;
    }
	
	## Simpan Data
	public function store(Request $request)
    {
		$this->validate($request, [
            'nama_pegawai' => 'required',
            'jenis' => 'required',
            'alasan' => 'required',
            'unit_kerja' => 'required'
		]);
		
        $pegawai = Pegawai::where('nip', $request->nama_pegawai)->get();
        $pegawai->toArray();
        $input['nip'] = $pegawai[0]->nip;
        $input['nama_pegawai'] = $pegawai[0]->nama_pegawai;
        $input['jenis'] = $request->jenis;
        $input['alasan'] = $request->alasan;
        $input['unit_kerja'] = $request->unit_kerja;
        $input['user_id'] = Auth::user()->id;

        PengusulanHukuman::create($input);
		
		return redirect('/pengusulan_hukuman')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(PengusulanHukuman $pengusulan_hukuman)
    {
        $title = "Penjatuhan Hukuman Disiplin";
        $pegawai = Pegawai::where('status_hapus', 0)->orderBy('id','DESC')->get();
        $view=view('admin.pengusulan_hukuman.edit', compact('title','pengusulan_hukuman','pegawai'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, PengusulanHukuman $pengusulan_hukuman)
    {
		$this->validate($request, [
            'nama_pegawai' => 'required',
            'jenis' => 'required',
            'alasan' => 'required',
            'unit_kerja' => 'required'
		]);
		
        $pengusulan_hukuman->fill($request->all());
        $pegawai = Pegawai::where('nip', $request->nama_pegawai)->get();
        $pegawai->toArray();
        $pengusulan_hukuman->nip = $pegawai[0]->nip;
        $pengusulan_hukuman->nama_pegawai = $pegawai[0]->nama_pegawai;
        $pengusulan_hukuman->user_id = Auth::user()->id;
        $pengusulan_hukuman->save();
    
		return redirect('/pengusulan_hukuman')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(PengusulanHukuman $pengusulan_hukuman)
    {
		$pengusulan_hukuman->delete();
		
		return redirect('/pengusulan_hukuman')->with('status', 'Data Berhasil Dihapus');
    }
}
