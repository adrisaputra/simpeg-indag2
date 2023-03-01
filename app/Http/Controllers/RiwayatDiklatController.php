<?php

namespace App\Http\Controllers;

use App\Models\RiwayatDiklat;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatDiklatController extends Controller
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

        $riwayat_diklat = RiwayatDiklat::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);

        return view('admin.riwayat_diklat.index',compact('riwayat_diklat','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_diklat = $request->get('search');
        
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_diklat = RiwayatDiklat::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_diklat) {
                                $query->where('kelompok_diklat', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('jenis_diklat', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('nama_diklat', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('negara', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('lokasi', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('kota', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('tmt_mulai', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('tmt_selesai', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('hari', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('jam', 'LIKE', '%'.$riwayat_diklat.'%')
                                    ->orWhere('kualitas', 'LIKE', '%'.$riwayat_diklat.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_diklat.index',compact('riwayat_diklat','pegawai'));
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

        $view=view('admin.riwayat_diklat.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'kelompok_diklat' => 'required',
            'jenis_diklat' => 'required',
            'nama_diklat' => 'required',
            'negara' => 'required',
            'lokasi' => 'required',
            'kota' => 'required',
            'tmt_mulai' => 'required',
            'tmt_selesai' => 'required',
            'hari' => 'required|numeric',
            'jam' => 'required|numeric',
            'kualitas' => 'required',
            'arsip_diklat' => 'required|mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        $input['pegawai_id'] = $id;
        $input['kelompok_diklat'] = $request->kelompok_diklat;
        $input['jenis_diklat'] = $request->jenis_diklat;
        $input['nama_diklat'] = $request->nama_diklat;
        $input['negara'] = $request->negara;
        $input['lokasi'] = $request->lokasi;
        $input['kota'] = $request->kota;
        $input['tmt_mulai'] = $request->tmt_mulai;
        $input['tmt_selesai'] = $request->tmt_selesai;
        $input['hari'] = $request->hari;
        $input['jam'] = $request->jam;
        $input['kualitas'] = $request->kualitas;
        $input['arsip_diklat'] = $request->arsip_diklat;
        
		if($request->file('arsip_diklat')){
			// $input['arsip_diklat'] = time().'.'.$request->arsip_diklat->getClientOriginalExtension();
			// $request->arsip_diklat->move(public_path('upload/arsip_diklat'), $input['arsip_diklat']);

            // File information
            $uploaded_file = $request->file('arsip_diklat');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_diklat/');
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
			        $input['arsip_diklat'] = $target_file;
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
       
        RiwayatDiklat::create($input);

        return redirect('/riwayat_diklat/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatDiklat $riwayat_diklat)
   {
        
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_diklat.edit', compact('pegawai','riwayat_diklat'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatDiklat $riwayat_diklat)
   {
        $this->validate($request, [
            'kelompok_diklat' => 'required',
            'jenis_diklat' => 'required',
            'nama_diklat' => 'required',
            'negara' => 'required',
            'lokasi' => 'required',
            'kota' => 'required',
            'tmt_mulai' => 'required',
            'tmt_selesai' => 'required',
            'hari' => 'required|numeric',
            'jam' => 'required|numeric',
            'kualitas' => 'required',
            'arsip_diklat' => 'mimes:jpg,jpeg,png|max:500'
        ]);
        
        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('arsip_diklat') && $riwayat_diklat->arsip_diklat){
            $pathToYourFile = public_path('upload/arsip_diklat/'.$riwayat_diklat->arsip_diklat);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_diklat->fill($request->all());
       
        if($request->file('arsip_diklat')){
            // $filename = time().'.'.$request->arsip_diklat->getClientOriginalExtension();
            // $request->arsip_diklat->move(public_path('upload/arsip_diklat'), $filename);
            // $riwayat_diklat->arsip_diklat = $filename;

            // File information
            $uploaded_file = $request->file('arsip_diklat');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_diklat/');
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
			        $riwayat_diklat->arsip_diklat = $target_file;
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

        $riwayat_diklat->user_id = Auth::user()->id;
        $riwayat_diklat->save();
       
        return redirect('/riwayat_diklat/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatDiklat $riwayat_diklat)
   {
        
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_diklat/'.$riwayat_diklat->arsip_diklat);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_diklat->delete();
       
        return redirect('/riwayat_diklat/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
