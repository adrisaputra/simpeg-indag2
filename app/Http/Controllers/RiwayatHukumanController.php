<?php

namespace App\Http\Controllers;

use App\Models\RiwayatHukuman;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatHukumanController extends Controller
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

        $riwayat_hukuman = RiwayatHukuman::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_hukuman.index',compact('riwayat_hukuman','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_hukuman = $request->get('search');
        
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_hukuman = RiwayatHukuman::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_hukuman) {
                                $query->where('jenis_hukuman', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('mulai', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('selesai', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('no_sk', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('tanggal_sk', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('pejabat', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('keterangan', 'LIKE', '%'.$riwayat_hukuman.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_hukuman.index',compact('riwayat_hukuman','pegawai'));
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

        $view=view('admin.riwayat_hukuman.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'jenis_hukuman' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'pejabat' => 'required',
            'arsip_hukuman' => 'required|mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        $input['pegawai_id'] = $id;
        $input['jenis_hukuman'] = $request->jenis_hukuman;
        $input['mulai'] = $request->mulai;
        $input['selesai'] = $request->selesai;
        $input['no_sk'] = $request->no_sk;
        $input['tanggal_sk'] = $request->tanggal_sk;
        $input['pejabat'] = $request->pejabat;
        $input['keterangan'] = $request->keterangan;
        
		if($request->file('arsip_hukuman')){
			// $input['arsip_hukuman'] = time().'.'.$request->arsip_hukuman->getClientOriginalExtension();
			// $request->arsip_hukuman->move(public_path('upload/arsip_hukuman'), $input['arsip_hukuman']);
            // $input['arsip_jabatan'] = time().'.'.$request->arsip_jabatan->getClientOriginalExtension();
			// $request->arsip_jabatan->move(public_path('upload/arsip_jabatan'), $input['arsip_jabatan']);
            
            // File information
            $uploaded_file = $request->file('arsip_hukuman');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_hukuman/');
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
			        $input['arsip_hukuman'] = $target_file;
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
    
        RiwayatHukuman::create($input);

        return redirect('/riwayat_hukuman/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatHukuman $riwayat_hukuman)
   {

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_hukuman.edit', compact('pegawai','riwayat_hukuman'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatHukuman $riwayat_hukuman)
   {
        $this->validate($request, [
            'jenis_hukuman' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'pejabat' => 'required',
            'arsip_hukuman' => 'mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('arsip_hukuman') && $riwayat_hukuman->arsip_hukuman){
            $pathToYourFile = public_path('upload/arsip_hukuman/'.$riwayat_hukuman->arsip_hukuman);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_hukuman->fill($request->all());
       
        if($request->file('arsip_hukuman')){
            // $filename = time().'.'.$request->arsip_hukuman->getClientOriginalExtension();
            // $request->arsip_hukuman->move(public_path('upload/arsip_hukuman'), $filename);
            // $riwayat_hukuman->arsip_hukuman = $filename;

            // File information
            $uploaded_file = $request->file('arsip_hukuman');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_hukuman/');
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
			        $riwayat_hukuman->arsip_hukuman = $target_file;
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

        $riwayat_hukuman->user_id = Auth::user()->id;
        $riwayat_hukuman->save();
    
        return redirect('/riwayat_hukuman/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatHukuman $riwayat_hukuman)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }
        
        $pathToYourFile = public_path('upload/arsip_hukuman/'.$riwayat_hukuman->arsip_hukuman);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_hukuman->delete();
       
        return redirect('/riwayat_hukuman/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
