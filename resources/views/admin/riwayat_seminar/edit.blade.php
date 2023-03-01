@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA SEMINAR') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA SEMINAR') }}</a></li>
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
			<h3 class="box-title">Edit Data Seminar</h3>
		</div>
		
		<form action="{{ url('/riwayat_seminar/edit/'.$pegawai[0]->id.'/'.$riwayat_seminar->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA SEMINAR</p></center>

					<div class="form-group @if ($errors->has('nama_seminar')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Seminar') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_seminar'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_seminar') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Seminar" name="nama_seminar" value="{{ $riwayat_seminar->nama_seminar }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tingkat_seminar')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tingkat Seminar') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('tingkat_seminar'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tingkat_seminar') }}</label>@endif
							<select class="form-control" name="tingkat_seminar">
                                        <option value=""> -Pilih Tingkat Seminar-</option>
                                        <option value="Seminar Lokal" @if($riwayat_seminar->tingkat_seminar=="Seminar Lokal") selected @endif> Seminar Lokal</option>
                                        <option value="Seminar Regional" @if($riwayat_seminar->tingkat_seminar=="Seminar Regional") selected @endif> Seminar Regional</option>
                                        <option value="Seminar Nasional" @if($riwayat_seminar->tingkat_seminar=="Seminar Nasional") selected @endif> Seminar Nasional</option>
                                        <option value="Seminar Internasional" @if($riwayat_seminar->tingkat_seminar=="Seminar Internasional") selected @endif> Seminar Internasional</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('peranan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Peranan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('peranan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('peranan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Peranan" name="peranan" value="{{ $riwayat_seminar->peranan }}" >
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
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal" name="tanggal" value="{{ $riwayat_seminar->tanggal }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('penyelenggara')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Penyelenggara') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('penyelenggara'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('penyelenggara') }}</label>@endif
							<input type="text" class="form-control" placeholder="Penyelenggara" name="penyelenggara" value="{{ $riwayat_seminar->penyelenggara }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tempat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tempat ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tempat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tempat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tempat" name="tempat" value="{{ $riwayat_seminar->tempat }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_sertifikat_seminar')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Sertifikat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-4">
							@if ($errors->has('arsip_sertifikat_seminar'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_sertifikat_seminar') }}</label>@endif
							<input type="file" class="form-control" placeholder="Sertifikat" name="arsip_sertifikat_seminar" value="{{ $riwayat_seminar->arsip_sertifikat_seminar }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_seminar/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						<div class="col-sm-2" @if($errors->has('arsip_sertifikat_seminar')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_seminar->arsip_sertifikat_seminar)
								<a href="{{ asset('upload/arsip_sertifikat_seminar/'.$riwayat_seminar->arsip_sertifikat_seminar) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
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