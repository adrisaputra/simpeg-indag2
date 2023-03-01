<?php

namespace App\Http\Controllers;

use App\Models\RiwayatCuti;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatCutiController extends Controller
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

        $riwayat_cuti = RiwayatCuti::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_cuti.index',compact('riwayat_cuti','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_cuti = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_cuti = RiwayatCuti::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_cuti) {
                                $query->where('jenis_cuti', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('keterangan', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('mulai', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('selesai', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('no_sk', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('tanggal_sk', 'LIKE', '%'.$riwayat_cuti.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_cuti.index',compact('riwayat_cuti','pegawai'));
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

        $view=view('admin.riwayat_cuti.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
       $this->validate($request, [
           'jenis_cuti' => 'required',
           'mulai' => 'required',
           'selesai' => 'required',
           'no_sk' => 'required',
           'tanggal_sk' => 'required',
           'arsip_cuti' => 'required|mimes:jpg,jpeg,png|max:500'
       ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

       $input['pegawai_id'] = $id;
       $input['jenis_cuti'] = $request->jenis_cuti;
       $input['keterangan'] = $request->keterangan;
       $input['mulai'] = $request->mulai;
       $input['selesai'] = $request->selesai;
       $input['no_sk'] = $request->no_sk;
       $input['tanggal_sk'] = $request->tanggal_sk;
       
		if($request->file('arsip_cuti')){
			// $input['arsip_cuti'] = time().'.'.$request->arsip_cuti->getClientOriginalExtension();
			// $request->arsip_cuti->move(public_path('upload/arsip_cuti'), $input['arsip_cuti']);
            // $input['arsip_jabatan'] = time().'.'.$request->arsip_jabatan->getClientOriginalExtension();
			// $request->arsip_jabatan->move(public_path('upload/arsip_jabatan'), $input['arsip_jabatan']);
            
            // File information
            $uploaded_file = $request->file('arsip_cuti');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_cuti/');
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
			        $input['arsip_cuti'] = $target_file;
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
   
       RiwayatCuti::create($input);

       return redirect('/riwayat_cuti/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatCuti $riwayat_cuti)
   {
        
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_cuti.edit', compact('pegawai','riwayat_cuti'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatCuti $riwayat_cuti)
   {
        $this->validate($request, [
            'jenis_cuti' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'arsip_cuti' => 'mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('arsip_cuti') && $riwayat_cuti->arsip_cuti){
            $pathToYourFile = public_path('upload/arsip_cuti/'.$riwayat_cuti->arsip_cuti);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_cuti->fill($request->all());
       
        if($request->file('arsip_cuti')){
            // $filename = time().'.'.$request->arsip_cuti->getClientOriginalExtension();
            // $request->arsip_cuti->move(public_path('upload/arsip_cuti'), $filename);
            // $riwayat_cuti->arsip_cuti = $filename;

            // File information
            $uploaded_file = $request->file('arsip_cuti');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_cuti/');
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
			        $riwayat_cuti->arsip_cuti = $target_file;
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

        $riwayat_cuti->user_id = Auth::user()->id;
        $riwayat_cuti->save();
    
        return redirect('/riwayat_cuti/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatCuti $riwayat_cuti)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_cuti/'.$riwayat_cuti->arsip_cuti);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_cuti->delete();
       
        return redirect('/riwayat_cuti/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
