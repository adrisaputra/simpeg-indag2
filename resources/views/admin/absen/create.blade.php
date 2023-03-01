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
			<h3 class="box-title">Tambah Absensi</h3>
		</div>
		
		<form action="{{ url('/absen') }}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
			<div class="box-body">
				<div class="col-lg-12">
					
					<p style="font-size:18px"><label>{{ __('Tanggal') }}</label> : {{ date('d-m-Y') }}</p>
									 
					<table class="table table-bordered">
						<tr style="background-color: gray;color:white">
							<th style="width: 1px">No</th>
							<th>NIP</th>
							<th>Nama Pegawai</th>
							<th style="width: 20%">#aksi</th>
						</tr>
						@foreach($pegawai as $v)
						<tr>
							<td>{{ $loop->index + 1 }}</td>
							<td>{{ $v->nip }}</td>
							<td>{{ $v->nama_pegawai }}</td>
							<td>
								<input type="hidden" class="form-control" name="pegawai_id[]" value="{{ $v->id }}">
								<input type="hidden" class="form-control" name="nip[]" value="{{ $v->nip }}">
								<input type="hidden" class="form-control" name="nama_pegawai[]" value="{{ $v->nama_pegawai }}">
								
								<span style='display:none;'>
								     <input class="form-check-input" type="radio" name="kehadiran[{{$loop->index }}]" value="" onclick="javascript:yesnoCheck{{ $loop->index+1 }}();"id="noCheck{{ $loop->index+1 }}" checked>	
								</span>
								<label class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="kehadiran[{{$loop->index }}]" value="H" onclick="javascript:yesnoCheck{{ $loop->index+1 }}();" id="yesCheck3{{ $loop->index+1 }}">
									<span class="form-check-label">
									H
									</span>
								</label>&nbsp;&nbsp;
								<label class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="kehadiran[{{ $loop->index }}]" value="S" onclick="javascript:yesnoCheck{{ $loop->index+1 }}();" id="yesCheck{{ $loop->index+1 }}">
									<span class="form-check-label">
									S
									</span>
								</label>&nbsp;&nbsp;
								<label class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="kehadiran[{{ $loop->index }}]" value="I" onclick="javascript:yesnoCheck{{ $loop->index+1 }}();" id="yesCheck2{{ $loop->index+1 }}">
									<span class="form-check-label">
									I
									</span>
								</label>&nbsp;&nbsp;
								<label class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="kehadiran[{{ $loop->index }}]" value="A" onclick="javascript:yesnoCheck{{ $loop->index+1 }}();" id="noCheck{{ $loop->index+1 }}">
									<span class="form-check-label">
									A
									</span>
								</label>&nbsp;&nbsp;
								<span id='a{{ $loop->index+1 }}' style='display:none;'>
									Keterangan: <br>
									<input type="text" class="form-control" name="keterangan[]" value="{{ $v->keterangan }}">
								</span>
								
								<span id='b{{ $loop->index+1 }}' style='display:none;'>
									<br>Jam Datang: <br>
									<input type="text" class="form-control timepicker" name="jam_datang[]" value="{{ $v->jam_datang }}">
									@if(date('H:i:s')>="16:00:00" && date('H:i:s')<="17:00:00")
										<br>Jam Pulang: <br>
										<input type="text" class="form-control timepicker" name="jam_pulang[]" value="{{ $v->jam_pulang }}">
									@endif
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
			</div>
		</form>
	</div>
	</section>
</div>

@endsection