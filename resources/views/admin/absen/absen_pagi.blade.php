@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __($title) }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __($title) }}</a></li>
	</ol>
	</section>

	<section class="content">
	<div class="box">
		
		<div class="box-header with-border">
			<div class="box-tools pull-left">
				<div style="padding-top:10px"> 
					<a href="{{ url('/absen/absen_pagi/'.Request::segment(3)) }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>   
				</div>
			</div>
			<div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/absen/absen_pagi_search/'.Request::segment(3)) }}" method="GET">
						<div class="input-group margin">
							<input type="hidden" class="form-control" name="tanggal" value="{{ Request::segment(3) }} ">
							<input type="text" class="form-control" name="search" placeholder="Masukkan kata kunci pencarian">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-danger btn-flat">cari</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		</div>

		<form action="{{ url('/absen/edit') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

				<table class="table table-bordered">
						<tr style="background-color: gray;color:white">
							<th style="width: 1px">No</th>
							<th>NIP</th>
							<th>Nama Pegawai</th>
							<th style="width: 20%">Status</th>
							<th style="width: 20%">Keterangan</th>
						</tr>
						@foreach($absen as $v)
						<tr>
							<td>{{ ($absen ->currentpage()-1) * $absen ->perpage() + $loop->index + 1 }}</td>
							<td>{{ $v->nip }}</td>
							<td>{{ $v->nama_pegawai }}</td>
							<td>
								<input type="hidden" class="form-control" name="pegawai_id[]" value="{{ $v->pegawai_id }}">
								<input type="hidden" class="form-control" name="nip[]" value="{{ $v->nip }}">
								<input type="hidden" class="form-control" name="nama_pegawai[]" value="{{ $v->nama_pegawai }}">
								<input type="hidden" class="form-control" name="bidang_id[]" value="{{ $v->bidang_id }}">
								<input type="hidden" class="form-control" name="jabatan_id[]" value="{{ $v->jabatan_id }}">
								<input type="hidden" class="form-control" name="tanggal[]" value="{{ $v->tanggal }}">
								
								@php
									$hadir = DB::table('absen_tbl')
									->where('pegawai_id',$v->pegawai_id)
									->where('tanggal',$v->tanggal)
									->get()->toArray();
								@endphp

								<span style='display:none;'>
								     <input class="form-check-input" type="radio" name="kehadiran[{{$loop->index }}]" value="" onclick="javascript:yesnoCheck{{ $loop->index+1 }}();"id="noCheck{{ $loop->index+1 }}" @if($hadir[0]->kehadiran=="") checked  @endif>	
								</span>
								<label class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="kehadiran[{{$loop->index }}]" value="H" @if($hadir[0]->kehadiran=="H") checked  @endif 
									onclick="javascript:yesnoCheck{{ $loop->index+1 }}();" id="yesCheck3{{ $loop->index+1 }}">
									<span class="form-check-label">
									H
									</span>
								</label>&nbsp;&nbsp;
								<label class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="kehadiran[{{ $loop->index }}]" value="S"  @if($hadir[0]->kehadiran=="S") checked  @endif
									onclick="javascript:yesnoCheck{{ $loop->index+1 }}();" id="yesCheck{{ $loop->index+1 }}">
									<span class="form-check-label">
									S
									</span>
								</label>&nbsp;&nbsp;
								<label class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="kehadiran[{{ $loop->index }}]" value="I"  @if($hadir[0]->kehadiran=="I") checked  @endif
									onclick="javascript:yesnoCheck{{ $loop->index+1 }}();" id="yesCheck2{{ $loop->index+1 }}">
									<span class="form-check-label">
									I
									</span>
								</label>&nbsp;&nbsp;
								<label class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="kehadiran[{{ $loop->index }}]" value="A"  @if($hadir[0]->kehadiran=="A") checked  @endif
									onclick="javascript:yesnoCheck{{ $loop->index+1 }}();" id="noCheck{{ $loop->index+1 }}">
									<span class="form-check-label">
									A
									</span>
								</label>
								
							</td>
							
							<td>
							
								<input type="hidden" class="form-control" name="jam_pulang[]" value="{{ $hadir[0]->jam_pulang }}">
								@if($hadir[0]->kehadiran=="S")
									<span id='a{{ $loop->index+1 }}' style='display:display;'>
								@elseif($hadir[0]->kehadiran=="I")
									<span id='a{{ $loop->index+1 }}' style='display:display;'>
								@else
									<span id='a{{ $loop->index+1 }}' style='display:none;'>
								@endif
									Keterangan: <br>
									<input type="text" class="form-control" name="keterangan[]" value="{{ $hadir[0]->keterangan }}">
								</span>

								@if($hadir[0]->kehadiran=="H")
									<span id='b{{ $loop->index+1 }}' style='display:display;'>
								@else
									<span id='b{{ $loop->index+1 }}' style='display:none;'>
								@endif
									Absen Pagi: <br>
									<input type="text" class="form-control timepicker" name="jam_datang[]" value="{{ $hadir[0]->jam_datang }}">
									<!-- @if(date('H:i:s')>="16:00:00" && date('H:i:s')<="17:00:00") -->
									<!-- @endif -->
								</span>
								
							</td>
						</tr>
						<script>
							function yesnoCheck<?php echo $loop->index+1; ?>() {
								if (document.getElementById('yesCheck<?php echo $loop->index+1; ?>').checked) {
									document.getElementById('a<?php echo $loop->index+1; ?>').style.display = 'inline';
									document.getElementById('b<?php echo $loop->index+1; ?>').style.display = 'none';
								}else if (document.getElementById('yesCheck2<?php echo $loop->index+1; ?>').checked) {
									document.getElementById('a<?php echo $loop->index+1; ?>').style.display = 'inline';
									document.getElementById('b<?php echo $loop->index+1; ?>').style.display = 'none';
								}else if (document.getElementById('yesCheck3<?php echo $loop->index+1; ?>').checked) {
									document.getElementById('a<?php echo $loop->index+1; ?>').style.display = 'none';
									document.getElementById('b<?php echo $loop->index+1; ?>').style.display = 'inline';
								} else {
									document.getElementById('a<?php echo $loop->index+1; ?>').style.display = 'none';
									document.getElementById('b<?php echo $loop->index+1; ?>').style.display = 'none';
								}
							}
						</script>
						@endforeach
						<tr>
							<td colspan=4>
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Simpan Data">Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data">Reset</button>
								<a href="{{ url('/absen') }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</td>
						</tr>
					</table>

				</div>
				<div class="box-footer">
					<!-- PAGINATION -->
					<div class="float-right">{{ $absen->appends(Request::only('search'))->links() }}</div>
				</div>
			</div>
		</form>
	</div>
	</section>
</div>

<script>
function tampil_bidang()
{
	jabatan_id = document.getElementById("jabatan_id").value;
	url = "{{ url('/bidang/nama_bidang') }}"
	$.ajax({
		url:""+url+"/"+jabatan_id+"",
		success: function(response){
			$("#bidang_id").html(response);
		}
	});
	return false;
}
function tampil_seksi()
{
	bidang_id = document.getElementById("bidang_id").value;
	url = "{{ url('/seksi/nama_seksi') }}"
	$.ajax({
		url:""+url+"/"+bidang_id+"",
		success: function(response){
			$("#seksi_id").html(response);
		}
	});
	return false;
}
</script>
@endsection