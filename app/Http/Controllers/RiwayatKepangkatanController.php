<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKepangkatan;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatKepangkatanController extends Controller
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

        $riwayat_kepangkatan = RiwayatKepangkatan::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_kepangkatan.index',compact('riwayat_kepangkatan','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_kepangkatan = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_kepangkatan = RiwayatKepangkatan::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_kepangkatan) {
                                $query->where('periode_kp', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('golongan', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('status', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('nama_pangkat', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('tmt', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('mk_tahun', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('mk_bulan', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('no_sk', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('tanggal_sk', 'LIKE', '%'.$riwayat_kepangkatan.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_kepangkatan.index',compact('riwayat_kepangkatan','pegawai'));
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

        $view=view('admin.riwayat_kepangkatan.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'periode_kp' => 'required',
            'periode_kp_sebelumnya' => 'required',
            'periode_kp_saat_ini' => 'required',
            'golongan' => 'required',
            'tmt' => 'required',
            'mk_bulan' => 'required|numeric',
            'mk_tahun' => 'required|numeric',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'pejabat' => 'required',
            'arsip_kepangkatan' => 'required|mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        $input['pegawai_id'] = $id;
        $input['periode_kp'] = $request->periode_kp;
        $input['periode_kp_sebelumnya'] = $request->periode_kp_sebelumnya;
        $input['periode_kp_saat_ini'] = $request->periode_kp_saat_ini;
        $input['golongan'] = $request->golongan;
        if($request->golongan=="Golongan I/a"){
            $input['jenis_golongan'] = 1;
            $input['nama_pangkat'] = 'Juru Muda';
        } else if($request->golongan=="Golongan I/b"){
            $input['jenis_golongan'] = 2;
            $input['nama_pangkat'] = 'Juru Muda  Tingkat 1';
        } else if($request->golongan=="Golongan I/c"){
            $input['jenis_golongan'] = 3;
            $input['nama_pangkat'] = 'Juru';
        } else if($request->golongan=="Golongan I/d"){
            $input['jenis_golongan'] = 4;
            $input['nama_pangkat'] = 'Juru Tingkat 1';
        } else if($request->golongan=="Golongan II/a"){
            $input['jenis_golongan'] = 5;
            $input['nama_pangkat'] = 'Pengatur Muda';
        } else if($request->golongan=="Golongan II/b"){
            $input['jenis_golongan'] = 6;
            $input['nama_pangkat'] = 'Pengatur Muda Tingkat 1';
        } else if($request->golongan=="Golongan II/c"){
            $input['jenis_golongan'] = 7;
            $input['nama_pangkat'] = 'Pengatur';
        } else if($request->golongan=="Golongan II/d"){
            $input['jenis_golongan'] = 8;
            $input['nama_pangkat'] = 'Pengatur Tingkat 1';
        } else if($request->golongan=="Golongan III/a"){
            $input['jenis_golongan'] = 9;
            $input['nama_pangkat'] = 'Penata Muda';
        } else if($request->golongan=="Golongan III/b"){
            $input['jenis_golongan'] = 10;
            $input['nama_pangkat'] = 'Penata Muda Tingkat 1';
        } else if($request->golongan=="Golongan III/c"){
            $input['jenis_golongan'] = 11;
            $input['nama_pangkat'] = 'Penata';
        } else if($request->golongan=="Golongan III/d"){
            $input['jenis_golongan'] = 12;
            $input['nama_pangkat'] = 'Penata Tingkat 1';
        } else if($request->golongan=="Golongan IV/a"){
            $input['jenis_golongan'] = 13;
            $input['nama_pangkat'] = 'Pembina';
        } else if($request->golongan=="Golongan IV/b"){
            $input['jenis_golongan'] = 14;
            $input['nama_pangkat'] = 'Pembina Tingkat 1';
        } else if($request->golongan=="Golongan IV/c"){
            $input['jenis_golongan'] = 15;
            $input['nama_pangkat'] = 'Pembina Utama Muda';
        } else if($request->golongan=="Golongan IV/d"){
            $input['jenis_golongan'] = 16;
            $input['nama_pangkat'] = 'Pembina Utama Madya';
        }  else if($request->golongan=="Golongan IV/e"){
            $input['jenis_golongan'] = 17;
            $input['nama_pangkat'] = 'Pembina Utama';
        }   

        $input['tmt'] = $request->tmt;
        $input['mk_tahun'] = $request->mk_tahun;
        $input['mk_bulan'] = $request->mk_bulan;
        $input['no_sk'] = $request->no_sk;
        $input['tanggal_sk'] = $request->tanggal_sk;
        $input['pejabat'] = $request->pejabat;

		if($request->file('arsip_kepangkatan')){
			// $input['arsip_kepangkatan'] = time().'.'.$request->arsip_kepangkatan->getClientOriginalExtension();
			// $request->arsip_kepangkatan->move(public_path('upload/arsip_kepangkatan'), $input['arsip_kepangkatan']);

            // File information
            $uploaded_file = $request->file('arsip_kepangkatan');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_kepangkatan/');
            $encrypt = Hash::make($uploaded_name);
            $target_file = md5(uniqid() . $encrypt) . '.' . $uploaded_ext;
            $temp_file = sys_get_temp_dir() . '/' . md5(uniqid() . $encrypt) . '.' . $uploaded_ext;

            // // Is it an image?
            if (( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) &&
                ($uploaded_size <= 500000) &&
                ($uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png') &&
                getimagesize($uploaded_tmp)) {

                // Strip any metadata, by re-encoding image
                if ($uploaded_type == 'image/jpeg') {
                    $img = imagecreatefromjpeg($uploaded_tmp);
                    imagejpeg($img, $temp_file, 100);
                } else {
                    $img = imagecreatefrompng($uploaded_tmp);
                    imagepng($img, $temp_file, 9);
                }
                imagedestroy($img);

                // Can we move the file to the web root from the temp folder?
                if (rename($temp_file, ($target_path . $target_file))) {
                    // Yes!
                    // echo "<pre><a href='${target_path}${target_file}'>${target_path}${target_file}</a> succesfully uploaded!</pre>";
			        $input['arsip_kepangkatan'] = $target_file;
                } else {
                    // No
                    echo '<pre>Your image was not uploaded.</pre>';
                }

                // Delete any temp files
                if (file_exists($temp_file)) {
                    unlink($temp_file);
                }
            } else {
                // Invalid file
                echo '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>';
            }
    	}	
		
        $input['user_id'] = Auth::user()->id;
       
        RiwayatKepangkatan::create($input);

        $golongan = RiwayatKepangkatan::where('pegawai_id',$id)->orderBy('jenis_golongan','DESC')->limit(1)->get();
        $golongan->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->tmt = $golongan[0]->tmt;
        $pegawai->golongan = $golongan[0]->golongan;
        $pegawai->save();
        
        return redirect('/riwayat_kepangkatan/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatKepangkatan $riwayat_kepangkatan)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_kepangkatan.edit', compact('pegawai','riwayat_kepangkatan'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatKepangkatan $riwayat_kepangkatan)
   {
        $this->validate($request, [
            'periode_kp' => 'required',
            'golongan' => 'required',
            'tmt' => 'required',
            'mk_bulan' => 'required|numeric',
            'mk_tahun' => 'required|numeric',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'pejabat' => 'required',
            'arsip_kepangkatan' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);
        
        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('arsip_kepangkatan') && $riwayat_kepangkatan->arsip_kepangkatan){
            $pathToYourFile = public_path('upload/arsip_kepangkatan/'.$riwayat_kepangkatan->arsip_kepangkatan);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_kepangkatan->fill($request->all());
       
        if($request->golongan=="Golongan I/a"){
            $riwayat_kepangkatan->jenis_golongan = 1;
            $riwayat_kepangkatan->nama_pangkat = 'Juru Muda';
        } else if($request->golongan=="Golongan I/b"){
            $riwayat_kepangkatan->jenis_golongan = 2;
            $riwayat_kepangkatan->nama_pangkat = 'Juru Muda Tingkat 1';
        } else if($request->golongan=="Golongan I/c"){
            $riwayat_kepangkatan->jenis_golongan = 3;
            $riwayat_kepangkatan->nama_pangkat = 'Juru';
        } else if($request->golongan=="Golongan I/d"){
            $riwayat_kepangkatan->jenis_golongan = 4;
            $riwayat_kepangkatan->nama_pangkat = 'Juru Tingkat 1';
        } else if($request->golongan=="Golongan II/a"){
            $riwayat_kepangkatan->jenis_golongan = 5;
            $riwayat_kepangkatan->nama_pangkat = 'Pengatur Muda';
        } else if($request->golongan=="Golongan II/b"){
            $riwayat_kepangkatan->jenis_golongan = 6;
            $riwayat_kepangkatan->nama_pangkat = 'Pengatur Muda Tingkat 1';
        } else if($request->golongan=="Golongan II/c"){
            $riwayat_kepangkatan->jenis_golongan = 7;
            $riwayat_kepangkatan->nama_pangkat = 'Pengatur';
        } else if($request->golongan=="Golongan II/d"){
            $riwayat_kepangkatan->jenis_golongan = 8;
            $riwayat_kepangkatan->nama_pangkat = 'Pengatur Tingkat 1';
        } else if($request->golongan=="Golongan III/a"){
            $riwayat_kepangkatan->jenis_golongan = 9;
            $riwayat_kepangkatan->nama_pangkat = 'Penata Muda';
        } else if($request->golongan=="Golongan III/b"){
            $riwayat_kepangkatan->jenis_golongan = 10;
            $riwayat_kepangkatan->nama_pangkat = 'Penata Muda Tingkat 1';
        } else if($request->golongan=="Golongan III/c"){
            $riwayat_kepangkatan->jenis_golongan = 11;
            $riwayat_kepangkatan->nama_pangkat = 'Penata';
        } else if($request->golongan=="Golongan III/d"){
            $riwayat_kepangkatan->jenis_golongan = 12;
            $riwayat_kepangkatan->nama_pangkat = 'Penata Tingkat 1';
        } else if($request->golongan=="Golongan IV/a"){
            $riwayat_kepangkatan->jenis_golongan = 13;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina';
        } else if($request->golongan=="Golongan IV/b"){
            $riwayat_kepangkatan->jenis_golongan = 14;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina Tingkat 1';
        } else if($request->golongan=="Golongan IV/c"){
            $riwayat_kepangkatan->jenis_golongan = 15;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina Utama Muda';
        } else if($request->golongan=="Golongan IV/d"){
            $riwayat_kepangkatan->jenis_golongan = 16;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina Utama Madya';
        } else if($request->golongan=="Golongan IV/e"){
            $riwayat_kepangkatan->jenis_golongan = 17;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina Utama';
        }   

        if($request->file('arsip_kepangkatan')){
            // $filename = time().'.'.$request->arsip_kepangkatan->getClientOriginalExtension();
            // $request->arsip_kepangkatan->move(public_path('upload/arsip_kepangkatan'), $filename);
            // $riwayat_kepangkatan->arsip_kepangkatan = $filename;

            // File information
            $uploaded_file = $request->file('arsip_kepangkatan');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_kepangkatan/');
            $encrypt = Hash::make($uploaded_name);
            $target_file = md5(uniqid() . $encrypt) . '.' . $uploaded_ext;
            echo  $target_file;
            $temp_file = sys_get_temp_dir() . '/' . md5(uniqid() . $encrypt) . '.' . $uploaded_ext;

            // // Is it an image?
            if (( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) &&
                ($uploaded_size <= 500000) &&
                ($uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png') &&
                getimagesize($uploaded_tmp)) {

                // Strip any metadata, by re-encoding image
                if ($uploaded_type == 'image/jpeg') {
                    $img = imagecreatefromjpeg($uploaded_tmp);
                    imagejpeg($img, $temp_file, 100);
                } else {
                    $img = imagecreatefrompng($uploaded_tmp);
                    imagepng($img, $temp_file, 9);
                }
                imagedestroy($img);

                // Can we move the file to the web root from the temp folder?
                if (rename($temp_file, ($target_path . $target_file))) {
                    // Yes!
                    // echo "<pre><a href='${target_path}${target_file}'>${target_path}${target_file}</a> succesfully uploaded!</pre>";
			        $riwayat_kepangkatan->arsip_kepangkatan = $target_file;
                } else {
                    // No
                    echo '<pre>Your image was not uploaded.</pre>';
                }

                // Delete any temp files
                if (file_exists($temp_file)) {
                    unlink($temp_file);
                }
            } else {
                // Invalid file
                echo '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>';
            }
            
		}

        $riwayat_kepangkatan->user_id = Auth::user()->id;
        $riwayat_kepangkatan->save();
       
        $golongan = RiwayatKepangkatan::where('pegawai_id',$id)->orderBy('jenis_golongan','DESC')->limit(1)->get();
        $golongan->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->tmt = $golongan[0]->tmt;
        $pegawai->golongan = $golongan[0]->golongan;
    	$pegawai->save();

        return redirect('/riwayat_kepangkatan/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatKepangkatan $riwayat_kepangkatan)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        if($riwayat_kepangkatan->arsip_kepangkatan){
            $pathToYourFile = public_path('upload/arsip_kepangkatan/'.$riwayat_kepangkatan->arsip_kepangkatan);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $riwayat_kepangkatan->delete();
       
        $golongan = RiwayatKepangkatan::where('pegawai_id',$id)->orderBy('jenis_golongan','DESC')->limit(1)->get();
        $golongan->toArray();
        
        if(count($golongan)>0){
            
            if($golongan){
                $pegawai = Pegawai::find($id);
                $pegawai->tmt = $golongan[0]->tmt;
                $pegawai->golongan = $golongan[0]->golongan;
            } else {
                $pegawai = Pegawai::find($id);
                $pegawai->tmt = '';
                $pegawai->golongan = '';
            }

            $pegawai->save();
        
        }

        return redirect('/riwayat_kepangkatan/'.$id)->with('status', 'Data Berhasil Dihapus');
   }

}