<?php

namespace App\Http\Controllers;

use App\Models\RiwayatIbu;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatIbuController extends Controller
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

        $riwayat_ibu = RiwayatIbu::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_ibu.index',compact('riwayat_ibu','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_ibu = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_ibu = RiwayatIbu::where('pegawai_id',$id)->where('nama_ibu', 'LIKE', '%'.$riwayat_ibu.'%')->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_ibu.index',compact('riwayat_ibu','pegawai'));
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

       $view=view('admin.riwayat_ibu.create',compact('pegawai'));
       $view=$view->render();
       return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
       $this->validate($request, [
           'nama_ibu' => 'required'
       ]);

       $input['pegawai_id'] = $id;
       $input['nama_ibu'] = $request->nama_ibu;
       $input['tempat_lahir'] = $request->tempat_lahir;
       $input['tanggal_lahir'] = $request->tanggal_lahir;
       $input['user_id'] = Auth::user()->id;
       
       RiwayatIbu::create($input);

       return redirect('/riwayat_ibu/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatIbu $riwayat_ibu)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

       $view=view('admin.riwayat_ibu.edit', compact('pegawai','riwayat_ibu'));
       $view=$view->render();
       return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatIbu $riwayat_ibu)
   {
       $this->validate($request, [
           'nama_ibu' => 'required'
       ]);

       $riwayat_ibu->fill($request->all());
       
       $riwayat_ibu->user_id = Auth::user()->id;
       $riwayat_ibu->save();
       
       return redirect('/riwayat_ibu/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatIbu $riwayat_ibu)
   {
       if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

       $riwayat_ibu->delete();
       
       return redirect('/riwayat_ibu/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
