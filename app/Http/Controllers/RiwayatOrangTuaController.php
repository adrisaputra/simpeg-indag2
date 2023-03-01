<?php

namespace App\Http\Controllers;

use App\Models\RiwayatOrangTua;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatOrangTuaController extends Controller
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

         $riwayat_orang_tua = RiwayatOrangTua::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         return view('admin.riwayat_orang_tua.index',compact('riwayat_orang_tua','pegawai'));
     }
 
     ## Tampilkan Data Search
     public function search(Request $request, $id)
     {
         $riwayat_orang_tua = $request->get('search');

         if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

         $riwayat_orang_tua = RiwayatOrangTua::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_orang_tua) {
                                $query->where('orang_tua', 'LIKE', '%'.$riwayat_orang_tua.'%')
                                    ->orWhere('nama_orang_tua', 'LIKE', '%'.$riwayat_orang_tua.'%')
                                    ->orWhere('tanggal_lahir', 'LIKE', '%'.$riwayat_orang_tua.'%')
                                    ->orWhere('pekerjaan', 'LIKE', '%'.$riwayat_orang_tua.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         return view('admin.riwayat_orang_tua.index',compact('riwayat_orang_tua','pegawai'));
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

		$view=view('admin.riwayat_orang_tua.create',compact('pegawai'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store($id, Request $request)
    {
        $this->validate($request, [
            'orang_tua' => 'required',
            'nama_orang_tua' => 'required',
            'kartu_keluarga' => 'required|mimes:jpg,jpeg,png,|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

		$input['pegawai_id'] = $id;
		$input['orang_tua'] = $request->orang_tua;
		$input['nama_orang_tua'] = $request->nama_orang_tua;
		$input['tanggal_lahir'] = $request->tanggal_lahir;
		$input['pekerjaan'] = $request->pekerjaan;
        
		if($request->file('kartu_keluarga')){
			// $input['kartu_keluarga'] = time().'.'.$request->kartu_keluarga->getClientOriginalExtension();
			// $request->kartu_keluarga->move(public_path('upload/kartu_keluarga'), $input['kartu_keluarga']);

            // File information
            $uploaded_file = $request->file('kartu_keluarga');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/kartu_keluarga/');
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
			        $input['kartu_keluarga'] = $target_file;
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
		
        RiwayatOrangTua::create($input);

		return redirect('/riwayat_orang_tua/'.$id)->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($id, RiwayatOrangTua $riwayat_orang_tua)
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_orang_tua.edit', compact('pegawai','riwayat_orang_tua'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $id, RiwayatOrangTua $riwayat_orang_tua)
    {
        $this->validate($request, [
            'orang_tua' => 'required',
            'nama_orang_tua' => 'required',
            'kartu_keluarga' => 'mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('kartu_keluarga') && $riwayat_orang_tua->kartu_keluarga){
            $pathToYourFile = public_path('upload/kartu_keluarga/'.$riwayat_orang_tua->kartu_keluarga);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_orang_tua->fill($request->all());
       
        if($request->file('kartu_keluarga')){
            // $filename = time().'.'.$request->kartu_keluarga->getClientOriginalExtension();
            // $request->kartu_keluarga->move(public_path('upload/kartu_keluarga'), $filename);
            // $riwayat_orang_tua->kartu_keluarga = $filename;

            // File information
            $uploaded_file = $request->file('kartu_keluarga');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/kartu_keluarga/');
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
			        $riwayat_orang_tua->kartu_keluarga = $target_file;
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

		$riwayat_orang_tua->user_id = Auth::user()->id;
    	$riwayat_orang_tua->save();
		
		return redirect('/riwayat_orang_tua/'.$id)->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($id, RiwayatOrangTua $riwayat_orang_tua)
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/kartu_keluarga/'.$riwayat_orang_tua->kartu_keluarga);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

		$riwayat_orang_tua->delete();
		
        return redirect('/riwayat_orang_tua/'.$id)->with('status', 'Data Berhasil Dihapus');
    }


}
