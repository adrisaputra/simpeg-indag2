<?php

namespace App\Http\Controllers;

use App\Models\Event;   //nama model
use App\Models\Pegawai;   //nama model
use App\Models\PelaksanaEvent;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
  
        if($request->ajax()) {
       
             $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end']);
  
             return response()->json($data);
        }
  
        return view('admin.event.calendar');
    }

    ## Tampilkan Form Create
    public function create()
    {
        $title = 'Tambah Agenda';
        $pegawai = Pegawai::get();
		$view=view('admin.event.create', compact('title','pegawai'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'start' => 'required',
			'end2' => 'required',
			'uraian' => 'required',
        ]);

        $event = new Event();
		$event->title = $request->title;
		$event->start = $request->start;
		$event->end = date('Y-m-d', strtotime( $request->end2 . " +1 days"));
		$event->end2 = $request->end2;
		$event->bidang = $request->bidang;
		$event->uraian = $request->uraian;
        $event->save();

        $jumlah_pegawai = count($request->pegawai_id);
        
        for($i=0;$i<$jumlah_pegawai;$i++){
            $pelaksana_event = new PelaksanaEvent();          
            $pelaksana_event->events_id = $event->id;
            $pelaksana_event->pegawai_id = $request->pegawai_id[$i];
            $pelaksana_event->save();
        }
		
		return redirect('/agenda')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit(Event $agenda)
    {
        
        if(Auth::user()->group==1){
            $title = 'Ubah Agenda';
        
            $pegawai = Pegawai::get();

            $i=0;
            foreach($pegawai as $v){ 
                $pelaksana = DB::table('pelaksana_event_tbl')->where('events_id',$agenda->id)->where('pegawai_id',$v->id)->get()->toArray();
                if(count($pelaksana)>0){
                    $hasil[$i] = $pelaksana[0]->pegawai_id;
                } else {
                    $hasil[$i] = 0;       
                } 
                $i++;
            }	
            $view=view('admin.event.edit', compact('title','agenda','pegawai','hasil'));
        } else {
            $title = 'Detail Agenda';
        
            $pelaksana = PelaksanaEvent::where('events_id',$agenda->id)->get();
            $view=view('admin.event.detail', compact('title','agenda','pelaksana'));
        }

        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, Event $agenda)
    {
        $this->validate($request, [
            'title' => 'required',
            'start' => 'required',
			'end2' => 'required'
        ]);

		$agenda->fill($request->all());
		$agenda->end = date('Y-m-d', strtotime( $request->end2 . " +1 days"));
		$agenda->end2 = $request->end2;
    	$agenda->save();
		
        DB::table('pelaksana_event_tbl')->where('events_id', $agenda->id)->delete();
		
        if($request->pegawai_id){
            $jumlah_pegawai = count($request->pegawai_id);
        } else {
            $jumlah_pegawai = 0;
        }
        
        if($jumlah_pegawai>0){
            for($i=0;$i<$jumlah_pegawai;$i++){
                $pelaksana_event = new PelaksanaEvent();          
                $pelaksana_event->events_id = $agenda->id;
                $pelaksana_event->pegawai_id = $request->pegawai_id[$i];
                $pelaksana_event->save();
            }
        }
		
		return redirect('/agenda')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(Event $agenda)
    {
        $id = $agenda->id;
		$agenda->delete();

		DB::table('pelaksana_event_tbl')->where('events_id', $id)->delete();

        return redirect('/agenda')->with('status', 'Data Berhasil Dihapus');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    {
 
        switch ($request->type) {
           case 'add':
              $event = Event::create([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end
              ]);
 
              return response()->json($event);
             break;
  
           case 'update':
              $event = Event::find($request->id)->update([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Event::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # code...
             break;
        }
    }

}
