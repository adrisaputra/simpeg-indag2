@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA KOMPETENSI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA KOMPETENSI') }}</a></li>
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
					<label >Nama Kegiatan Pegawai</label>
					<input type="text" class="form-control" placeholder="Nama Kegiatan Pegawai" value="{{ $pegawai[0]->nama_pegawai }}" disabled>
				</div>
			</div>
		</div>
	</div>

	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Tambah Data Kompetensi</h3>
		</div>
		
		<form action="{{ url('/riwayat_kompetensi/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA KOMPETENSI</p></center>

					<div class="form-group @if ($errors->has('nama_kegiatan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Kegiatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_kegiatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_kegiatan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal" name="tanggal" value="{{ old('tanggal') }}">
                                    </div>
						</div>
					</div>

					<div class="form-group @if ($errors->has('tempat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tempat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tempat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tempat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tempat" name="tempat" value="{{ old('tempat') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('angkatan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Angkatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('angkatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('angkatan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Angkatan" name="angkatan" value="{{ old('angkatan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_kompetensi')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Berkas Kompetensi') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('arsip_kompetensi'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_kompetensi') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Jabatan" name="arsip_kompetensi" value="{{ old('arsip_kompetensi') }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png,)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_kompetensi/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
					</div>
					
				</div>
			</div>
		</form>
	</div>
	</section>
</div>

@endsection