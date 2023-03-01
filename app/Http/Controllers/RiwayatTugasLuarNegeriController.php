<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTugasLuarNegeri;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatTugasLuarNegeriController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_tugas_luar_negeri = RiwayatTugasLuarNegeri::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_tugas_luar_negeri.index',compact('riwayat_tugas_luar_negeri','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_tugas_luar_negeri = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_tugas_luar_negeri = RiwayatTugasLuarNegeri::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_tugas_luar_negeri) {
                                $query->where('tipe_kunjungan', 'LIKE', '%'.$riwayat_tugas_luar_negeri.'%')
                                ->orWhere('tujuan', 'LIKE', '%'.$riwayat_tugas_luar_negeri.'%')
                                ->orWhere('negara', 'LIKE', '%'.$riwayat_tugas_luar_negeri.'%')
                                ->orWhere('tanggal_mulai', 'LIKE', '%'.$riwayat_tugas_luar_negeri.'%')
                                ->orWhere('tanggal_selesai', 'LIKE', '%'.$riwayat_tugas_luar_negeri.'%')
                                ->orWhere('asal_dana', 'LIKE', '%'.$riwayat_tugas_luar_negeri.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_tugas_luar_negeri.index',compact('riwayat_tugas_luar_negeri','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_tugas_luar_negeri.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'tipe_kunjungan' => 'required',
            'tujuan' => 'required',
            'negara' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'asal_dana' => 'required'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        $input['pegawai_id'] = $id;
        $input['tipe_kunjungan'] = $request->tipe_kunjungan;
        $input['tujuan'] = $request->tujuan;
        $input['negara'] = $request->negara;
        $input['tanggal_mulai'] = $request->tanggal_mulai;
        $input['tanggal_selesai'] = $request->tanggal_selesai;
        $input['asal_dana'] = $request->asal_dana;
        $input['user_id'] = Auth::user()->id;
    
        RiwayatTugasLuarNegeri::create($input);

        return redirect('/riwayat_tugas_luar_negeri/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatTugasLuarNegeri $riwayat_tugas_luar_negeri)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_tugas_luar_negeri.edit', compact('pegawai','riwayat_tugas_luar_negeri'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatTugasLuarNegeri $riwayat_tugas_luar_negeri)
   {
        $this->validate($request, [
            'tipe_kunjungan' => 'required',
            'tujuan' => 'required',
            'negara' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'asal_dana' => 'required'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        $riwayat_tugas_luar_negeri->fill($request->all()); 
        $riwayat_tugas_luar_negeri->user_id = Auth::user()->id;
        $riwayat_tugas_luar_negeri->save();
    
        return redirect('/riwayat_tugas_luar_negeri/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatTugasLuarNegeri $riwayat_tugas_luar_negeri)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_tugas_luar_negeri->delete();
       
        return redirect('/riwayat_tugas_luar_negeri/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
