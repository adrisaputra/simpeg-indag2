<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;   //nama model
use App\Models\Jabatan;   //nama model
use App\Models\Bidang;   //nama model
use App\Models\Seksi;   //nama model
use App\Models\User;   //nama model
use App\Models\RiwayatJabatan;   //nama model
use App\Models\RiwayatAngkaKredit;   //nama model
use App\Models\RiwayatKepangkatan;   //nama model
use App\Models\RiwayatLhkpn;   //nama model
use App\Models\RiwayatKompetensi;   //nama model
use App\Models\RiwayatPendidikan;   //nama model
use App\Models\RiwayatSeminar;   //nama model
use App\Models\RiwayatDiklat;   //nama model
use App\Models\RiwayatTugas;   //nama model
use App\Models\RiwayatKaryaIlmiah;   //nama model
use App\Models\RiwayatPenghargaan;   //nama model
use App\Models\RiwayatCuti;   //nama model
use App\Models\RiwayatHukuman;   //nama model
use App\Models\RiwayatKursus;   //nama model
use App\Models\RiwayatGaji;   //nama model
use App\Models\RiwayatKgb;   //nama model
use App\Models\RiwayatTugasLuarNegeri;   //nama model
use App\Models\RiwayatPajak;   //nama model
use App\Models\RiwayatOrangTua;   //nama model
use App\Models\RiwayatPasangan;   //nama model
use App\Models\RiwayatAnak;   //nama model
use App\Imports\PegawaiImport;     // Import data Pegawai
use Maatwebsite\Excel\Facades\Excel; // Excel Library
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Image;
use PDF;

class PegawaiController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        if(Auth::user()->group==1){

            $pegawai = Pegawai::where('status_hapus', 0)->orderBy('jabatan_id','ASC')->paginate(25)->onEachSide(1);
        
            $i=0;
            foreach($pegawai as $v){ 
                $absen = DB::table('absen_tbl')->where('pegawai_id',$v->id)->where('tanggal',date('Y-m-d'))->get()->toArray();
                if(count($absen)>0){
                    $status_kehadiran[$i] = $absen[0]->kehadiran;
                } else {
                    $status_kehadiran[$i] = "Belum Absen";       
                } 
                $i++;
            }	

            return view('admin.pegawai.index',compact('pegawai','status_kehadiran'));

        } else if(Auth::user()->group==3){
            $pegawai = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->orderBy('id','DESC')->get()->toArray();
            return view('admin.pegawai.index2',compact('pegawai'));
        }
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $pegawai = $request->get('search');
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('status_hapus', 0)
            ->where(function ($query) use ($pegawai) {
                $query->where('nip', 'LIKE', '%'.$pegawai.'%')
                    ->orWhere('nama_pegawai', 'LIKE', '%'.$pegawai.'%')
                    ->orWhere('golongan', 'LIKE', '%'.$pegawai.'%');
            })
            ->orderBy('jabatan_id','ASC')->paginate(25)->onEachSide(1);
        } else if(Auth::user()->group==2){
            $pegawai = Pegawai::where('bidang_id', Auth::user()->bidang_id)->where('status_hapus', 0)->where('nama_pegawai', 'LIKE', '%'.$pegawai.'%')->orderBy('jabatan_id','ASC')->paginate(25)->onEachSide(1);
        }
        
        $i=0;
        if(count($pegawai)>0){
            foreach($pegawai as $v){ 
                $absen = DB::table('absen_tbl')->where('pegawai_id',$v->id)->where('tanggal',date('Y-m-d'))->get()->toArray();
                if(count($absen)>0){
                    $status_kehadiran[$i] = $absen[0]->kehadiran;
                } else {
                    $status_kehadiran[$i] = "Belum Absen";       
                } 
                $i++;
            }
        } else {
            $status_kehadiran[0] = "Belum Absen";   
        }	
        return view('admin.pegawai.index',compact('pegawai','status_kehadiran'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $jabatan = jabatan::get();
        $bidang = Bidang::get();
        $seksi = Seksi::get();
		$view=view('admin.pegawai.create', compact('jabatan','bidang','seksi'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'nip' => 'required|unique:pegawai_tbl|numeric|digits:18',
            'nama_pegawai' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'jabatan_id' => 'required',
            'bidang_id' => 'required',
            'seksi_id' => 'required_if:jabatan_id,4|required_if:jabatan_id,5|required_if:jabatan_id,7',
            'status' => 'required',
			'foto_formal' => 'mimes:jpg,jpeg,png|max:500',
			'foto_kedinasan' => 'mimes:jpg,jpeg,png|max:500',
            'no_ktp' => 'required|digits:16',
			'ktp' => 'mimes:jpg,jpeg,png|max:500',
			'bpjs' => 'mimes:jpg,jpeg,png|max:500',
            'no_npwp' => 'required',
			'npwp' => 'mimes:jpg,jpeg,png|max:500',
			'karpeg' => 'mimes:jpg,jpeg,png|max:500',
			'karsu' => 'mimes:jpg,jpeg,png|max:500',
			'taspen' => 'mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

		$input['nip'] = $request->nip;
		$input['nama_pegawai'] = $request->nama_pegawai;
		$input['tempat_lahir'] = $request->tempat_lahir;
		$input['tanggal_lahir'] = $request->tanggal_lahir;
		$input['jenis_kelamin'] = $request->jenis_kelamin;
		$input['alamat'] = $request->alamat;
		$input['agama'] = $request->agama;
		$input['gol_darah'] = $request->gol_darah;
		$input['no_ktp'] = $request->no_ktp;
        $input['no_bpjs'] = $request->no_bpjs;
        $input['no_npwp'] = $request->no_npwp;
        $input['no_karpeg'] = $request->no_karpeg;
        $input['no_karsu'] = $request->no_karsu;
        $input['no_taspen'] = $request->no_taspen;
        $input['email'] = $request->email;
        $input['status'] = $request->status;
        $input['jabatan_id'] = $request->jabatan_id;
        if($request->jabatan_id==3 || $request->jabatan_id==5){
            $input['bidang_id'] = $request->bidang_id;
        }
        else if($request->jabatan_id==4){
            $input['seksi_id'] = $request->seksi_id;
        }
        else if($request->jabatan_id==7){
            $input['bidang_id'] = $request->bidang_id;
            $input['seksi_id'] = $request->seksi_id;
        }
        
		if($request->file('foto_formal')){
            // $input['foto_formal'] = time().'.'.$request->file('foto_formal')->getClientOriginalExtension();
 
            // $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai', $input['foto_formal']);
            // $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai/thumbnail', $input['foto_formal']);
     
            // $thumbnailpath = public_path('storage/upload/foto_formal_pegawai/thumbnail/'.$input['foto_formal']);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // File information
            $uploaded_file = $request->file('foto_formal');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/foto_formal_pegawai/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $input['foto_formal'] = $target_file;
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
        
		if($request->file('foto_kedinasan')){
            // $input['foto_kedinasan'] = time().'.'.$request->file('foto_kedinasan')->getClientOriginalExtension();
 
            // $request->file('foto_kedinasan')->storeAs('public/upload/foto_kedinasan_pegawai', $input['foto_kedinasan']);
            // $request->file('foto_kedinasan')->storeAs('public/upload/foto_kedinasan_pegawai/thumbnail', $input['foto_kedinasan']);
     
            // $thumbnailpath = public_path('storage/upload/foto_kedinasan_pegawai/thumbnail/'.$input['foto_kedinasan']);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // File information
            $uploaded_file = $request->file('foto_kedinasan');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/foto_kedinasan_pegawai/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $input['foto_kedinasan'] = $target_file;
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
        
		if($request->file('ktp')){
            // $input['ktp'] = time().'.'.$request->file('ktp')->getClientOriginalExtension();
 
            // $request->file('ktp')->storeAs('public/upload/ktp', $input['ktp']);
            // $request->file('ktp')->storeAs('public/upload/ktp/thumbnail', $input['ktp']);
     
            // $thumbnailpath = public_path('storage/upload/ktp/thumbnail/'.$input['ktp']);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // File information
            $uploaded_file = $request->file('ktp');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/ktp/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $input['ktp'] = $target_file;
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
        
		if($request->file('bpjs')){
            // $input['bpjs'] = time().'.'.$request->file('bpjs')->getClientOriginalExtension();
 
            // $request->file('bpjs')->storeAs('public/upload/bpjs', $input['bpjs']);
            // $request->file('bpjs')->storeAs('public/upload/bpjs/thumbnail', $input['bpjs']);
     
            // $thumbnailpath = public_path('storage/upload/bpjs/thumbnail/'.$input['bpjs']);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // File information
            $uploaded_file = $request->file('bpjs');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/bpjs/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $input['bpjs'] = $target_file;
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
        
		if($request->file('npwp')){
            // $input['npwp'] = time().'.'.$request->file('npwp')->getClientOriginalExtension();
 
            // $request->file('npwp')->storeAs('public/upload/npwp', $input['npwp']);
            // $request->file('npwp')->storeAs('public/upload/npwp/thumbnail', $input['npwp']);
     
            // $thumbnailpath = public_path('storage/upload/npwp/thumbnail/'.$input['npwp']);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);
            
            // File information
            $uploaded_file = $request->file('npwp');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/npwp/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $input['npwp'] = $target_file;
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
        
		if($request->file('karpeg')){
            // $input['karpeg'] = time().'.'.$request->file('karpeg')->getClientOriginalExtension();
 
            // $request->file('karpeg')->storeAs('public/upload/karpeg', $input['karpeg']);
            // $request->file('karpeg')->storeAs('public/upload/karpeg/thumbnail', $input['karpeg']);
     
            // $thumbnailpath = public_path('storage/upload/karpeg/thumbnail/'.$input['karpeg']);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // File information
            $uploaded_file = $request->file('karpeg');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/karpeg/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $input['karpeg'] = $target_file;
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
        
		if($request->file('karsu')){
            // $input['karsu'] = time().'.'.$request->file('karsu')->getClientOriginalExtension();
 
            // $request->file('karsu')->storeAs('public/upload/karsu', $input['karsu']);
            // $request->file('karsu')->storeAs('public/upload/karsu/thumbnail', $input['karsu']);
     
            // $thumbnailpath = public_path('storage/upload/karsu/thumbnail/'.$input['karsu']);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // File information
            $uploaded_file = $request->file('karsu');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/karsu/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $input['karsu'] = $target_file;
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
        
		if($request->file('taspen')){
            // $input['taspen'] = time().'.'.$request->file('taspen')->getClientOriginalExtension();
 
            // $request->file('taspen')->storeAs('public/upload/taspen', $input['karsu']);
            // $request->file('taspen')->storeAs('public/upload/taspen/thumbnail', $input['karsu']);
     
            // $thumbnailpath = public_path('storage/upload/taspen/thumbnail/'.$input['karsu']);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // File information
            $uploaded_file = $request->file('taspen');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/taspen/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $input['taspen'] = $target_file;
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
		
        Pegawai::create($input);
        
		$input2['name'] = $request->nip;
		$input2['email'] = $request->nip.'@gmail.com';
		$input2['password'] = Hash::make($request->nip);
		$input2['group'] = 3;
        User::create($input2);
        
		return redirect('/pegawai')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit(Pegawai $pegawai)
    {
        if(Auth::user()->group==3){
            $id_pegawai = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('id',$id_pegawai)->first();
        }
        $jabatan = jabatan::get();
        $bidang = Bidang::get();
        $seksi = Seksi::get();
        $view=view('admin.pegawai.edit', compact('pegawai','jabatan','bidang','seksi'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, Pegawai $pegawai)
    {
        $this->validate($request, [
            'nip' => 'required|numeric|digits:18',
            'nama_pegawai' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'jabatan_id' => 'required',
            'bidang_id' => 'required',
            'seksi_id' => 'required_if:jabatan_id,4|required_if:jabatan_id,5|required_if:jabatan_id,7',
            'status' => 'required',
			'foto_formal' => 'mimes:jpg,jpeg,png|max:500',
			'foto_kedinasan' => 'mimes:jpg,jpeg,png|max:500',
            'no_ktp' => 'required|digits:16',
			'ktp' => 'mimes:jpg,jpeg,png|max:500',
			'bpjs' => 'mimes:jpg,jpeg,png|max:500',
            'no_npwp' => 'required',
			'npwp' => 'mimes:jpg,jpeg,png|max:500',
			'karpeg' => 'mimes:jpg,jpeg,png|max:500',
			'karsu' => 'mimes:jpg,jpeg,png|max:500',
			'taspen' => 'mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($pegawai->foto_formal && $request->file('foto_formal')!=""){
            // $image_path = public_path().'/storage/upload/foto_formal_pegawai/thumbnail/'.$pegawai->foto_formal;
            // $image_path2 = public_path().'/storage/upload/foto_formal_pegawai/'.$pegawai->foto_formal;
            // unlink($image_path);
            // unlink($image_path2);

            $pathToYourFile = public_path('upload/foto_formal_pegawai/'.$pegawai->foto_formal);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        if($pegawai->foto_kedinasan && $request->file('foto_kedinasan')!=""){
            // $image_path = public_path().'/storage/upload/foto_kedinasan_pegawai/thumbnail/'.$pegawai->foto_kedinasan;
            // $image_path2 = public_path().'/storage/upload/foto_kedinasan_pegawai/'.$pegawai->foto_kedinasan;
            // unlink($image_path);
            // unlink($image_path2);

            $pathToYourFile = public_path('upload/foto_kedinasan_pegawai/'.$pegawai->foto_kedinasan);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        if($pegawai->ktp && $request->file('ktp')!=""){
            // $image_path3 = public_path().'/storage/upload/ktp/thumbnail/'.$pegawai->ktp;
            // $image_path4 = public_path().'/storage/upload/ktp/'.$pegawai->ktp;
            // unlink($image_path3);
            // unlink($image_path4);
            
            $pathToYourFile = public_path('upload/ktp/'.$pegawai->ktp);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        if($pegawai->bpjs && $request->file('bpjs')!=""){
            // $image_path5 = public_path().'/storage/upload/bpjs/thumbnail/'.$pegawai->bpjs;
            // $image_path6 = public_path().'/storage/upload/bpjs/'.$pegawai->bpjs;
            // unlink($image_path5);
            // unlink($image_path6);

            $pathToYourFile = public_path('upload/bpjs/'.$pegawai->bpjs);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        if($pegawai->npwp && $request->file('npwp')!=""){
            // $image_path7 = public_path().'/storage/upload/npwp/thumbnail/'.$pegawai->npwp;
            // $image_path8 = public_path().'/storage/upload/npwp/'.$pegawai->npwp;
            // unlink($image_path7);
            // unlink($image_path8);
            $pathToYourFile = public_path('upload/npwp/'.$pegawai->npwp);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        if($pegawai->karpeg && $request->file('karpeg')!=""){
            // $image_path9 = public_path().'/storage/upload/karpeg/thumbnail/'.$pegawai->karpeg;
            // $image_path10 = public_path().'/storage/upload/karpeg/'.$pegawai->karpeg;
            // unlink($image_path9);
            // unlink($image_path10);
            $pathToYourFile = public_path('upload/karpeg/'.$pegawai->karpeg);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        if($pegawai->karsu && $request->file('karsu')!=""){
            // $image_path11 = public_path().'/storage/upload/karsu/thumbnail/'.$pegawai->karsu;
            // $image_path12 = public_path().'/storage/upload/karsu/'.$pegawai->karsu;
            // unlink($image_path11);
            // unlink($image_path12);
            $pathToYourFile = public_path('upload/karsu/'.$pegawai->karsu);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $pegawai->fill($request->all());
        
		if($request->file('foto_formal')){

            // $filename = time().'.'.$request->file('foto_formal')->getClientOriginalExtension();
           
            // $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai', $filename);
            // $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai/thumbnail', $filename);
     
            // $thumbnailpath = public_path('storage/upload/foto_formal_pegawai/thumbnail/'.$filename);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // $pegawai->foto_formal = $filename;

            // File information
            $uploaded_file = $request->file('foto_formal');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/foto_formal_pegawai/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $pegawai->foto_formal = $target_file;
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
        
		if($request->file('foto_kedinasan')){

            // $filename = time().'.'.$request->file('foto_kedinasan')->getClientOriginalExtension();
           
            // $request->file('foto_kedinasan')->storeAs('public/upload/foto_kedinasan_pegawai', $filename);
            // $request->file('foto_kedinasan')->storeAs('public/upload/foto_kedinasan_pegawai/thumbnail', $filename);
     
            // $thumbnailpath = public_path('storage/upload/foto_kedinasan_pegawai/thumbnail/'.$filename);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // $pegawai->foto_kedinasan = $filename;

            // File information
            $uploaded_file = $request->file('foto_kedinasan');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/foto_kedinasan_pegawai/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $pegawai->foto_kedinasan = $target_file;
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
        
		if($request->file('ktp')){

            // $filename = time().'.'.$request->file('ktp')->getClientOriginalExtension();
           
            // $request->file('ktp')->storeAs('public/upload/ktp', $filename);
            // $request->file('ktp')->storeAs('public/upload/ktp/thumbnail', $filename);
     
            // $thumbnailpath = public_path('storage/upload/ktp/thumbnail/'.$filename);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // $pegawai->ktp = $filename;

            // File information
            $uploaded_file = $request->file('ktp');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/ktp/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
			        $pegawai->ktp = $target_file;
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
        
		if($request->file('bpjs')){

            // $filename = time().'.'.$request->file('bpjs')->getClientOriginalExtension();
           
            // $request->file('bpjs')->storeAs('public/upload/bpjs', $filename);
            // $request->file('bpjs')->storeAs('public/upload/bpjs/thumbnail', $filename);
     
            // $thumbnailpath = public_path('storage/upload/bpjs/thumbnail/'.$filename);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // $pegawai->bpjs = $filename;

            // File information
            $uploaded_file = $request->file('bpjs');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/bpjs/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
                    $pegawai->bpjs = $target_file;
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
        
		if($request->file('npwp')){

            // $filename = time().'.'.$request->file('npwp')->getClientOriginalExtension();
           
            // $request->file('npwp')->storeAs('public/upload/npwp', $filename);
            // $request->file('npwp')->storeAs('public/upload/npwp/thumbnail', $filename);
     
            // $thumbnailpath = public_path('storage/upload/npwp/thumbnail/'.$filename);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // $pegawai->npwp = $filename;

            // File information
            $uploaded_file = $request->file('npwp');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/npwp/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
                    $pegawai->npwp = $target_file;
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
        
		if($request->file('karpeg')){

            // $filename = time().'.'.$request->file('karpeg')->getClientOriginalExtension();
           
            // $request->file('karpeg')->storeAs('public/upload/karpeg', $filename);
            // $request->file('karpeg')->storeAs('public/upload/karpeg/thumbnail', $filename);
     
            // $thumbnailpath = public_path('storage/upload/karpeg/thumbnail/'.$filename);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // $pegawai->karpeg = $filename;

            
            // File information
            $uploaded_file = $request->file('karpeg');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/karpeg/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
                    $pegawai->karpeg = $target_file;
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
        
		if($request->file('karsu')){

            // $filename = time().'.'.$request->file('karsu')->getClientOriginalExtension();
           
            // $request->file('karsu')->storeAs('public/upload/karsu', $filename);
            // $request->file('karsu')->storeAs('public/upload/karsu/thumbnail', $filename);
     
            // $thumbnailpath = public_path('storage/upload/karsu/thumbnail/'.$filename);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // $pegawai->karsu = $filename;

            
            // File information
            $uploaded_file = $request->file('karsu');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/karsu/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
                    $pegawai->karsu = $target_file;
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

		if($request->file('taspen')){

            // $filename = time().'.'.$request->file('taspen')->getClientOriginalExtension();
           
            // $request->file('taspen')->storeAs('public/upload/taspen', $filename);
            // $request->file('taspen')->storeAs('public/upload/taspen/thumbnail', $filename);
     
            // $thumbnailpath = public_path('storage/upload/taspen/thumbnail/'.$filename);
            // $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save($thumbnailpath);

            // $pegawai->taspen = $filename;

            // File information
            $uploaded_file = $request->file('taspen');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/taspen/');
            $encrypt = Crypt::encrypt($uploaded_name);
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
                    $pegawai->taspen = $target_file;
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
        
        if($request->jabatan_id==4 || $request->jabatan_id==5 || $request->jabatan_id==7 || $request->jabatan_id==8){
            $pegawai->bidang_id = $request->bidang_id;
            if(!$request->seksi_id){
                $pegawai->seksi_id = 0;
            } else {
                $pegawai->seksi_id = $request->seksi_id;
            }
        } else {
            $pegawai->seksi_id = 0;
        }
		$pegawai->user_id = Auth::user()->id;
    	$pegawai->save();
		
        $cek_user = User::where('name',$request->nip2)->get();
        $cek_user->toArray();

        $user = User::find($cek_user[0]->id);
        $user->name = $request->nip;
    	$user->save();
        
		return redirect('/pegawai')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(Pegawai $pegawai)
    {
        if(Request()->segment(2)=='pensiun'){
            $pegawai->status_hapus = 1;
        } else if(Request()->segment(1)=='meninggal'){
            $pegawai->status_hapus = 2;
        } else if(Request()->segment(2)=='pindah_tugas'){
            $pegawai->status_hapus = 3;
        } 
        $pegawai->user_id = Auth::user()->id;
    	$pegawai->save();

        return redirect('/pegawai')->with('status', 'Data Berhasil Dihapus');
    }

    public function import_excel(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_pegawai',$nama_file);
 
		// import data
		Excel::import(new PegawaiImport, public_path('/file_pegawai/'.$nama_file));
 
        return redirect('/pegawai')->with('status', 'Data Pegawai Berhasil Diimport');
	}

    public function download_cv($id)
    {
    	$pegawai = Pegawai::where('id',$id)->get();
    	$pegawai->toArray();

        $riwayat_jabatan = RiwayatJabatan::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_angka_kredit = RiwayatAngkaKredit::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_kepangkatan = RiwayatKepangkatan::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_lhkpn = RiwayatLhkpn::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_kompetensi = RiwayatKompetensi::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_pendidikan = RiwayatPendidikan::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_seminar = RiwayatSeminar::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_diklat = RiwayatDiklat::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_tugas = RiwayatTugas::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_karya_ilmiah = RiwayatKaryaIlmiah::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_penghargaan = RiwayatPenghargaan::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_cuti = RiwayatCuti::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_hukuman = RiwayatHukuman::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_kursus = RiwayatKursus::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_gaji = RiwayatGaji::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_kgb = RiwayatKgb::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_tugas_luar_negeri = RiwayatTugasLuarNegeri::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_pajak = RiwayatPajak::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_orang_tua = RiwayatOrangTua::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_pasangan = RiwayatPasangan::where('pegawai_id',$id)->orderBy('id','DESC')->get();
        $riwayat_anak = RiwayatAnak::where('pegawai_id',$id)->orderBy('id','DESC')->get();
 
    	$pdf = PDF::loadview('admin.pegawai.download_cv',[
                                'pegawai'=>$pegawai,
                                'riwayat_jabatan'=>$riwayat_jabatan,
                                'riwayat_angka_kredit'=>$riwayat_angka_kredit,
                                'riwayat_kepangkatan'=>$riwayat_kepangkatan,
                                'riwayat_lhkpn'=>$riwayat_lhkpn,
                                'riwayat_kompetensi'=>$riwayat_kompetensi,
                                'riwayat_pendidikan'=>$riwayat_pendidikan,
                                'riwayat_seminar'=>$riwayat_seminar,
                                'riwayat_diklat'=>$riwayat_diklat,
                                'riwayat_tugas'=>$riwayat_tugas,
                                'riwayat_karya_ilmiah'=>$riwayat_karya_ilmiah,
                                'riwayat_penghargaan'=>$riwayat_penghargaan,
                                'riwayat_cuti'=>$riwayat_cuti,
                                'riwayat_hukuman'=>$riwayat_hukuman,
                                'riwayat_kursus'=>$riwayat_kursus,
                                'riwayat_gaji'=>$riwayat_gaji,
                                'riwayat_kgb'=>$riwayat_kgb,
                                'riwayat_tugas_luar_negeri'=>$riwayat_tugas_luar_negeri,
                                'riwayat_pajak'=>$riwayat_pajak,
                                'riwayat_orang_tua'=>$riwayat_orang_tua,
                                'riwayat_pasangan'=>$riwayat_pasangan,
                                'riwayat_anak'=>$riwayat_anak
                            ]);
    	return $pdf->download($pegawai[0]->nama_pegawai.'.pdf');

        // $view=view('admin.pegawai.download_cv', compact('pegawai',
        //                                                 'riwayat_jabatan',
        //                                                 'riwayat_angka_kredit',
        //                                                 'riwayat_kepangkatan',
        //                                                 'riwayat_kepangkatan',
        //                                                 'riwayat_lhkpn',
        //                                                 'riwayat_kompetensi',
        //                                                 'riwayat_pendidikan',
        //                                                 'riwayat_seminar',
        //                                                 'riwayat_diklat',
        //                                                 'riwayat_tugas',
        //                                                 'riwayat_karya_ilmiah',
        //                                                 'riwayat_penghargaan',
        //                                                 'riwayat_cuti',
        //                                                 'riwayat_hukuman',
        //                                                 'riwayat_kursus',
        //                                                 'riwayat_gaji',
        //                                                 'riwayat_kgb',
        //                                                 'riwayat_tugas_luar_negeri',
        //                                                 'riwayat_pajak',
        //                                                 'riwayat_orang_tua',
        //                                                 'riwayat_pasangan',
        //                                                 'riwayat_anak'));
        // $view=$view->render();
        // return $view;

    }

    public function naik_pangkat()
    {
        $title = "Naik Pangkat";

        if(Auth::user()->group==1){
            $pegawai = Pegawai::select('*', DB::raw("tmt + INTERVAL '4' YEAR AS naikpangkat_berikutnya"), DB::raw(" DATEDIFF(tmt + INTERVAL '4' YEAR,CURDATE()) as hari"))
                      ->where('status_hapus', 0)
                      ->whereRaw('YEAR(tmt) = YEAR(DATE_SUB(CURDATE(), INTERVAL 4 YEAR))')
                      ->paginate(25)->onEachSide(1);

            if(count($pegawai)>0){
                foreach($pegawai as $v){
                    if($v->golongan){
                       
                        if($v->golongan=="Golongan I/a"){
                            $golongan_selanjutnya = "Golongan I/b";
                        } else if($v->golongan=="Golongan I/b"){
                            $golongan_selanjutnya = "Golongan I/c";
                        } else if($v->golongan=="Golongan I/c"){
                            $golongan_selanjutnya = "Golongan I/d";
                        } else if($v->golongan=="Golongan I/d"){
                            $golongan_selanjutnya = "Golongan II/a";
                        } else if($v->golongan=="Golongan II/a"){
                            $golongan_selanjutnya = "Golongan II/b";
                        } else if($v->golongan=="Golongan II/b"){
                            $golongan_selanjutnya = "Golongan II/c";
                        } else if($v->golongan=="Golongan II/c"){
                            $golongan_selanjutnya = "Golongan II/d";
                        } else if($v->golongan=="Golongan II/d"){
                            $golongan_selanjutnya = "Golongan III/a";
                        } else if($v->golongan=="Golongan III/a"){
                            $golongan_selanjutnya = "Golongan III/b";
                        } else if($v->golongan=="Golongan III/b"){
                            $golongan_selanjutnya = "Golongan III/c";
                        } else if($v->golongan=="Golongan III/c"){
                            $golongan_selanjutnya = "Golongan III/d";
                        } else if($v->golongan=="Golongan III/d"){
                            $golongan_selanjutnya = "Golongan IV/a";
                        } else if($v->golongan=="Golongan IV/a"){
                            $golongan_selanjutnya = "Golongan IV/b";
                        } else if($v->golongan=="Golongan IV/b"){
                            $golongan_selanjutnya = "Golongan IV/c";
                        } else if($v->golongan=="Golongan IV/c"){
                            $golongan_selanjutnya = "Golongan IV/d";
                        } else if($v->golongan=="Golongan IV/d"){
                            $golongan_selanjutnya = "Golongan IV/e";
                        } else {
                            $golongan_selanjutnya = "Tidak Ada";
                        }
                        
                        $naikpangkat=$v->naikpangkat_berikutnya;
                    } else {
                        //$naikpangkat[0]="Tidak ada";
                        $golongan_selanjutnya="Tidak ada";
                        $naikpangkat="Tidak ada";
                    } 

                    
                }
            
            } else {
                $golongan_selanjutnya="Tidak ada";
                $naikpangkat="Tidak ada";
            }

            return view('admin.pegawai.naik_pangkat',compact('title','pegawai','naikpangkat','golongan_selanjutnya'));

        } else {

            $pegawai = Pegawai::select('*', DB::raw("tmt + INTERVAL '4' YEAR AS naikpangkat_berikutnya"), DB::raw(" DATEDIFF(tmt + INTERVAL '4' YEAR,CURDATE()) as hari"))
                      ->where('nip', Auth::user()->name)->get();
            $pegawai->toArray();

            if(count($pegawai)>0){
                
                if($pegawai[0]->golongan=="Golongan I/a"){
                    $golongan_selanjutnya = "Golongan I/b";
                } else if($pegawai[0]->golongan=="Golongan I/b"){
                    $golongan_selanjutnya = "Golongan I/c";
                } else if($pegawai[0]->golongan=="Golongan I/c"){
                    $golongan_selanjutnya = "Golongan I/d";
                } else if($pegawai[0]->golongan=="Golongan I/d"){
                    $golongan_selanjutnya = "Golongan II/a";
                } else if($pegawai[0]->golongan=="Golongan II/a"){
                    $golongan_selanjutnya = "Golongan II/b";
                } else if($pegawai[0]->golongan=="Golongan II/b"){
                    $golongan_selanjutnya = "Golongan II/c";
                } else if($pegawai[0]->golongan=="Golongan II/c"){
                    $golongan_selanjutnya = "Golongan II/d";
                } else if($pegawai[0]->golongan=="Golongan II/d"){
                    $golongan_selanjutnya = "Golongan III/a";
                } else if($pegawai[0]->golongan=="Golongan III/a"){
                    $golongan_selanjutnya = "Golongan III/b";
                } else if($pegawai[0]->golongan=="Golongan III/b"){
                    $golongan_selanjutnya = "Golongan III/c";
                } else if($pegawai[0]->golongan=="Golongan III/c"){
                    $golongan_selanjutnya = "Golongan III/d";
                } else if($pegawai[0]->golongan=="Golongan III/d"){
                    $golongan_selanjutnya = "Golongan IV/a";
                } else if($pegawai[0]->golongan=="Golongan IV/a"){
                    $golongan_selanjutnya = "Golongan IV/b";
                } else if($pegawai[0]->golongan=="Golongan IV/b"){
                    $golongan_selanjutnya = "Golongan IV/c";
                } else if($pegawai[0]->golongan=="Golongan IV/c"){
                    $golongan_selanjutnya = "Golongan IV/d";
                } else if($pegawai[0]->golongan=="Golongan IV/d"){
                    $golongan_selanjutnya = "Golongan IV/e";
                } 
                
                $naikpangkat=$pegawai[0]->naikpangkat_berikutnya;
            } else {
                $naikpangkat[0]="Tidak ada";
                $golongan_selanjutnya="Tidak ada";
            } 
            
            return view('admin.pegawai.naik_pangkat',compact('title','pegawai','naikpangkat','golongan_selanjutnya'));
        }
        
    }

    public function pensiun()
    {
        $title = "Pensiun";

        if(Auth::user()->group==1){
            $pegawai = Pegawai::select('*', DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) AS umur'), DB::raw("tanggal_lahir + INTERVAL '58' YEAR AS pensiun"))
                      ->where('status_hapus', 0)
                      ->whereRaw('YEAR(tanggal_lahir) = YEAR(DATE_SUB(CURDATE(), INTERVAL 58 YEAR))')
                      ->paginate(25)->onEachSide(1);

            return view('admin.pegawai.pensiun',compact('title','pegawai'));
        } else {
           
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
    
            $pensiun = Pegawai::select('*', DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) AS umur'), DB::raw("tanggal_lahir + INTERVAL '58' YEAR AS pensiun"))
                             ->where('nip',Auth::user()->name)->get();	
            $pensiun->toArray();	
    
            return view('admin.pegawai.pensiun',compact('title','pegawai','pensiun'));
        }
        
    }

    public function kgb()
    {
        $title = "Kenaikan Gaji Berkala";

        if(Auth::user()->group==1){

            $pegawai = Pegawai::where('status_hapus', 0)
                    ->whereRaw('YEAR(kgb_saat_ini) = YEAR(DATE_SUB(CURDATE(), INTERVAL 2 YEAR))')
                    ->paginate(25)->onEachSide(1);
            
            $i=0;
            if(count($pegawai)>0){
                foreach($pegawai as $v){ 
                    
                    if($v->kgb_saat_ini){
                        $kgb = RiwayatKgb::select('*', DB::raw("kgb_saat_ini + INTERVAL '2' YEAR AS kgb_berikutnya"), DB::raw(" DATEDIFF(kgb_saat_ini + INTERVAL '2' YEAR,CURDATE()) as hari"))
                                     ->where('pegawai_id',$v->id)->orderBy('kgb_saat_ini','DESC')->get();	
                        $kgb->toArray();	
                        $kgb_terakhir[$i] = $kgb[0]->kgb_terakhir;
                        $kgb_saat_ini[$i] = $kgb[0]->kgb_saat_ini;
                        $kgb_berikutnya[$i] = $kgb[0]->kgb_berikutnya;
                    } else {
                        $kgb_terakhir[$i] = "Tidak ada";   
                        $kgb_saat_ini[$i] = "Tidak ada";   
                        $kgb_berikutnya[$i] = "Tidak ada";   
                    } 
                    $i++;
                }	
            } else {
                $gaji[0]="Tidak ada";
                $kgb_terakhir[0] = "Tidak ada";   
                $kgb_saat_ini[0] = "Tidak ada";   
                $kgb_berikutnya[0] = "Tidak ada";  
            }
            

        } else {
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
    
            if($pegawai[0]->kgb_saat_ini){
                $kgb = RiwayatKgb::select('*', DB::raw("kgb_saat_ini + INTERVAL '2' YEAR AS kgb_berikutnya"), DB::raw(" DATEDIFF(kgb_saat_ini + INTERVAL '2' YEAR,CURDATE()) as hari"))
                       ->where('pegawai_id',$pegawai[0]->id)->orderBy('kgb_saat_ini','DESC')->get();	
                $kgb->toArray();	
                $kgb_terakhir[0] = $kgb[0]->kgb_terakhir;
                $kgb_terakhir[0] = $kgb[0]->kgb_terakhir;
                $kgb_saat_ini[0] = $kgb[0]->kgb_saat_ini;
                $kgb_berikutnya[0] = $kgb[0]->kgb_berikutnya;
            } else {
                $gaji[0]="Tidak ada";
                $kgb_terakhir[0] = "Tidak ada";   
                $kgb_saat_ini[0] = "Tidak ada";   
                $kgb_berikutnya[0] = "Tidak ada";  
            } 
        }
        
        return view('admin.pegawai.kgb',compact('title','pegawai','kgb_terakhir','kgb_saat_ini','kgb_berikutnya',));
    }

    
}
