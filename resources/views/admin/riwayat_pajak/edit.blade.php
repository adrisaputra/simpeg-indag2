@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA PAJAK') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA PAJAK') }}</a></li>
	</ol>
	</section>

	<section class="content">
	
	<div class="box">
		<div class="box-body">
			<div class="col-lg-6">
				<div class="form-group">
					<label >NIP</label>
					<input type="text" class="form-control" placeholder="NIP" value="{{ $pegawai[0]->nip }}" disabled>
				</div>

			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label >Nama Pegawai</label>
					<input type="text" class="form-control" placeholder="Nama Pegawai" value="{{ $pegawai[0]->nama_pegawai }}" disabled>
				</div>
			</div>
		</div>
	</div>

	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Edit Data Pajak</h3>
		</div>
		
		<form action="{{ url('/riwayat_pajak/edit/'.$pegawai[0]->id.'/'.$riwayat_pajak->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA PAJAK</p></center>

					<div class="form-group @if ($errors->has('no_npwp')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. NPWP') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('no_npwp'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_npwp') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. NPWP" name="no_npwp" value="{{ $riwayat_pajak->no_npwp }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jenis_spt')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis SPT ') }}  <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis_spt'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_spt') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jenis SPT " name="jenis_spt" value="{{ $riwayat_pajak->jenis_spt }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tahun')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tahun') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tahun'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tahun') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tahun" name="tahun" value="{{ $riwayat_pajak->tahun }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('pembetulan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pembetulan Ke') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('pembetulan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pembetulan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Pembetulan Ke" name="pembetulan" value="{{ $riwayat_pajak->pembetulan }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('status')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Status') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('status'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('status') }}</label>@endif
							<input type="text" class="form-control" placeholder="Status" name="status" value="{{ $riwayat_pajak->status }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jumlah')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jumlah') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jumlah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jumlah') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jumlah" name="jumlah" value="{{ $riwayat_pajak->jumlah }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_spt')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Bukti SPT') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-5">
							@if ($errors->has('arsip_spt'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_spt') }}</label>@endif
							<input type="file" class="form-control" placeholder="Bukti SPT" name="arsip_spt" value="{{ $riwayat_pajak->arsip_spt }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_pajak/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						
						<div class="col-sm-2" @if($errors->has('arsip_spt')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_pajak->arsip_spt)
								<a href="{{ asset('upload/arsip_spt/'.$riwayat_pajak->arsip_spt) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>

				</div>
			</div>
		</form>
	</div>
	</section>
</div>

@endsection