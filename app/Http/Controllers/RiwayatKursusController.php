<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKursus;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatKursusController extends Controller
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

        $riwayat_kursus = RiwayatKursus::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_kursus.index',compact('riwayat_kursus','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_kursus = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_kursus = RiwayatKursus::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_kursus) {
                                $query->where('nama_kursus', 'LIKE', '%'.$riwayat_kursus.'%')
                                    ->orWhere('tempat', 'LIKE', '%'.$riwayat_kursus.'%')
                                    ->orWhere('penyelenggara', 'LIKE', '%'.$riwayat_kursus.'%')
                                    ->orWhere('no_sertifikat', 'LIKE', '%'.$riwayat_kursus.'%')
                                    ->orWhere('tanggal_sertifikat', 'LIKE', '%'.$riwayat_kursus.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_kursus.index',compact('riwayat_kursus','pegawai'));
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

        $view=view('admin.riwayat_kursus.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'lokasi_tes' => 'required',
            'tanggal_tes' => 'required',
            'score' => 'required|numeric',
            'listening' => 'required|numeric',
            'structure' => 'required|numeric',
            'reading' => 'required|numeric',
            'writing' => 'required|numeric',
            'speaking' => 'required|numeric',
            'arsip_toefl' => 'required|mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

       $input['pegawai_id'] = $id;
       $input['lokasi_tes'] = $request->lokasi_tes;
       $input['tanggal_tes'] = $request->tanggal_tes;
       $input['score'] = $request->score;
       $input['listening'] = $request->listening;
       $input['structure'] = $request->structure;
       $input['reading'] = $request->reading;
       $input['writing'] = $request->writing;
       $input['speaking'] = $request->speaking;
       
       if($request->file('arsip_toefl')){
            // $input['arsip_toefl'] = time().'.'.$request->arsip_toefl->getClientOriginalExtension();
            // $request->arsip_toefl->move(public_path('upload/arsip_toefl'), $input['arsip_toefl']);
            // $input['arsip_jabatan'] = time().'.'.$request->arsip_jabatan->getClientOriginalExtension();
			// $request->arsip_jabatan->move(public_path('upload/arsip_jabatan'), $input['arsip_jabatan']);
            
            // File information
            $uploaded_file = $request->file('arsip_toefl');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_toefl/');
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
			        $input['arsip_toefl'] = $target_file;
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
    
        RiwayatKursus::create($input);

        return redirect('/riwayat_kursus/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatKursus $riwayat_kursus)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_kursus.edit', compact('pegawai','riwayat_kursus'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatKursus $riwayat_kursus)
   {
        $this->validate($request, [
            'lokasi_tes' => 'required',
            'tanggal_tes' => 'required',
            'score' => 'required|numeric',
            'listening' => 'required|numeric',
            'structure' => 'required|numeric',
            'reading' => 'required|numeric',
            'writing' => 'required|numeric',
            'speaking' => 'required|numeric',
            'arsip_toefl' => 'mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('arsip_toefl') && $riwayat_kursus->arsip_toefl){
            $pathToYourFile = public_path('upload/arsip_toefl/'.$riwayat_kursus->arsip_toefl);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $riwayat_kursus->fill($request->all());
       
        if($request->file('arsip_toefl')){
            // $filename = time().'.'.$request->arsip_toefl->getClientOriginalExtension();
            // $request->arsip_toefl->move(public_path('upload/arsip_toefl'), $filename);
            // $riwayat_kursus->arsip_toefl = $filename;

            // File information
            $uploaded_file = $request->file('arsip_toefl');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_toefl/');
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
			        $riwayat_kursus->arsip_toefl = $target_file;
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
        
        $riwayat_kursus->user_id = Auth::user()->id;
        $riwayat_kursus->save();
    
        return redirect('/riwayat_kursus/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatKursus $riwayat_kursus)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_toefl/'.$riwayat_kursus->arsip_toefl);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }
        $riwayat_kursus->delete();
       
        return redirect('/riwayat_kursus/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
