<?php

namespace App\Http\Controllers;

use App\Models\Absen;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class AbsenController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = 'ABSENSI';
        $cek_absen = DB::table('absen_tbl')->groupBy('tanggal')->orderBy('tanggal','DESC')->get()->toArray();
        $jumlah_pegawai = DB::table('absen_tbl')->where('tanggal', date('Y-m-d'))->count();
        $absen_pagi = DB::table('absen_tbl')
                                    ->where('tanggal', date('Y-m-d'))
                                    ->where('kehadiran','H')
                                    ->whereNotNull('jam_datang')
                                    ->count();
        $absen_sore = DB::table('absen_tbl')
                                    ->where('tanggal', date('Y-m-d'))
                                    ->where('kehadiran','H')
                                    ->whereNotNull('jam_pulang')
                                    ->count();
        $tidak_hadir = DB::table('absen_tbl')
                                    ->where('tanggal', date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('kehadiran','I')
                                            ->orWhere('kehadiran','A')
                                            ->orWhere('kehadiran','S');
                                    })
                                    ->count();
        $jumlah_pegawai_absen_pagi =  $absen_pagi + $tidak_hadir ;
        $jumlah_pegawai_absen_sore =  $absen_sore + $tidak_hadir ;
        $absen = Absen::groupBy('tanggal')->orderBy('tanggal','DESC')->paginate(25)->onEachSide(1);
        return view('admin.absen.index',compact('cek_absen','title','absen','jumlah_pegawai','jumlah_pegawai_absen_pagi','jumlah_pegawai_absen_sore'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = 'ABSENSI';
        $cek_absen = DB::table('absen_tbl')->groupBy('tanggal')->orderBy('tanggal','DESC')->get()->toArray();
        $jumlah_pegawai = DB::table('absen_tbl')->where('tanggal', date('Y-m-d'))->count();
        $absen_pagi = DB::table('absen_tbl')
                                    ->where('tanggal', date('Y-m-d'))
                                    ->where('kehadiran','H')
                                    ->whereNotNull('jam_datang')
                                    ->count();
        $absen_sore = DB::table('absen_tbl')
                                    ->where('tanggal', date('Y-m-d'))
                                    ->where('kehadiran','H')
                                    ->whereNotNull('jam_pulang')
                                    ->count();
        $tidak_hadir = DB::table('absen_tbl')
                                    ->where('tanggal', date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('kehadiran','I')
                                            ->orWhere('kehadiran','A')
                                            ->orWhere('kehadiran','S');
                                    })
                                    ->count();
        $jumlah_pegawai_absen_pagi =  $absen_pagi + $tidak_hadir ;
        $jumlah_pegawai_absen_sore =  $absen_sore + $tidak_hadir ;
        $absen = $request->get('search');
        $absen = Absen::where('tanggal', 'LIKE', '%'.$absen.'%')->groupBy('tanggal')->orderBy('tanggal','DESC')->paginate(25)->onEachSide(1);
        return view('admin.absen.index',compact('cek_absen','title','absen','jumlah_pegawai','jumlah_pegawai_absen_pagi','jumlah_pegawai_absen_sore'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = 'ABSENSI';
        $pegawai = Pegawai::where('status_hapus', 0)->orderBy('id','DESC')->get();
        $view=view('admin.absen.create',compact('title','pegawai'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $count = count($request->pegawai_id);
        $n = 0;
        for($i=0;$i<$count;$i++) {
            $input['pegawai_id'] = $request->pegawai_id[$i];
            $input['nip'] = $request->nip[$i];
            $input['nama_pegawai'] = $request->nama_pegawai[$i];
            $input['bidang_id'] = Auth::user()->bidang_id;
            $input['kehadiran'] = $request->kehadiran[$i];

            $input['keterangan'] = $request->keterangan[$i];
            if($request->kehadiran[$i]=='H'){
                $input['jam_datang'] = $request->jam_datang[$i];
                if(date('H:i:s')>="16:00:00" && date('H:i:s')<="17:00:00"){
                    $input['jam_pulang'] = $request->jam_pulang[$i];
                }
            }
            else {
                $input['jam_datang'] = "";
                if(date('H:i:s')>="16:00:00" && date('H:i:s')<="17:00:00"){
                    $input['jam_pulang'] = $request->jam_pulang[$i];
                }
            }
            
            $input['tanggal'] = date('Y-m-d');
            $input['user_id'] = Auth::user()->id;
            Absen::create($input);
        }

    }

    ## Simpan Data
    public function buat_absen()
    {
        $pegawai = Pegawai::where('status_hapus', 0)->orderBy('id','DESC')->get();
        foreach($pegawai as $v){
            $input['pegawai_id'] = $v->id;
            $input['nip'] = $v->nip;
            $input['nama_pegawai'] = $v->nama_pegawai;
            $input['bidang_id'] = $v->bidang_id;
            $input['jabatan_id'] = $v->jabatan_id;
            $input['tanggal'] = date('Y-m-d');
            $input['user_id'] = Auth::user()->id;
            Absen::create($input);
        }
        
        return redirect('/absen')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function absen_pagi($tanggal)
    {
        $title = 'ABSEN PAGI';
        $absen = Absen::where('tanggal',$tanggal)->orderBy('jabatan_id','ASC')->paginate(25)->onEachSide(1);
        $view=view('admin.absen.absen_pagi', compact('title','absen'));
        $view=$view->render();
		return $view;
    }

	## Tampilkan Data Search
	public function absen_pagi_search(Request $request, $tanggal)
    {
        $title = 'ABSEN PAGI';
        $absen = $request->get('search');
        $absen = Absen::
                where(function ($query) use ($absen) {
                    $query->where('nip', 'LIKE', '%'.$absen.'%')
                        ->orWhere('nama_pegawai', 'LIKE', '%'.$absen.'%');
                })
                ->where('tanggal',$tanggal)
                ->orderBy('jabatan_id','ASC')->paginate(25)->onEachSide(1);
		$view=view('admin.absen.absen_pagi', compact('title','absen'));
        $view=$view->render();
		return $view;
    }
	
    ## Tampilkan Form Edit
    public function absen_sore($tanggal)
    {
        $title = 'ABSEN SORE';
        $absen = Absen::where('tanggal',$tanggal)->orderBy('jabatan_id','ASC')->paginate(25)->onEachSide(1);
        $view=view('admin.absen.absen_sore', compact('title','absen'));
        $view=$view->render();
		return $view;
    }

    ## Edit Data
    public function update(Request $request)
    {

        $count = count($request->pegawai_id);
        $n = 0;
        for($i=0;$i<$count;$i++) {

            DB::table('absen_tbl')
            ->where('pegawai_id', $request->pegawai_id[$i])
            ->where('tanggal', $request->tanggal[$i])
            ->delete();
        
            $input['pegawai_id'] = $request->pegawai_id[$i];
            $input['nip'] = $request->nip[$i];
            $input['nama_pegawai'] = $request->nama_pegawai[$i];
            $input['bidang_id'] = $request->bidang_id[$i];
            $input['jabatan_id'] = $request->jabatan_id[$i];
            $input['kehadiran'] = $request->kehadiran[$i];

            $input['keterangan'] = $request->keterangan[$i];
            if($request->kehadiran[$i]=='H'){
                $input['jam_datang'] = $request->jam_datang[$i];
                $input['jam_pulang'] = $request->jam_pulang[$i];
            }
            else {
                $input['jam_datang'] = "";
                $input['jam_pulang'] ="";
            }
            
            $input['tanggal'] = $request->tanggal[$i];
            $input['user_id'] = Auth::user()->id;
            Absen::create($input);
        }
        
		return redirect('/absen')->with('status', 'Data Berhasil Diubah');
    }

    public function report($tanggal){
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $absen = Absen::whereDate('tanggal', $tanggal)->get();
        $absen->toArray();

        $sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(22);
		$sheet->getColumnDimension('C')->setWidth(40);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);
		$sheet->getColumnDimension('F')->setWidth(17);
		$sheet->getColumnDimension('G')->setWidth(20);
       
        $sheet->setCellValue('A1', 'ABSENSI DINAS PERINDUSTRIAN DAN PERDAGANGAN PROV. SULTRA'); $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('A2', 'TANGGAL '.date('d-m-Y', strtotime($tanggal))); $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2:F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('A5', 'NO');
        $sheet->setCellValue('B5', 'NIP');
        $sheet->setCellValue('C5', 'NAMA PEGAWAI');
        $sheet->setCellValue('D5', 'ABSEN PAGI');
        $sheet->setCellValue('E5', 'ABSEN SORE');
        $sheet->setCellValue('F5', 'STATUS KEHADIRAN');
        $sheet->setCellValue('G5', 'KETERANGAN');
        
        $rows = 6;
        $no = 1;
    
        foreach($absen as $v){
            $sheet->setCellValue('A' . $rows, $no++);
            $sheet->setCellValue('B' . $rows, $v->nip);
            $sheet->setCellValue('C' . $rows, $v->nama_pegawai);
            $sheet->getStyle('B' . $rows)->getNumberFormat()->setFormatCode('0');
            $sheet->setCellValue('D' . $rows, $v->jam_datang);
            $sheet->setCellValue('E' . $rows, $v->jam_pulang);
            $sheet->setCellValue('F' . $rows, $v->kehadiran);
            $sheet->setCellValue('G' . $rows, $v->keterangan);
            $rows++;
        }
        
        $sheet->getStyle('A5:G'.($rows-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A5:G'.($rows-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
       
        $type = 'xlsx';
        $fileName = "ABSENSI TANGGAL ".date('d-m-Y', strtotime($tanggal)).".".$type;
        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);			
        }		
        $writer->save("upload/report/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/upload/report/".$fileName);
    }
	
}
