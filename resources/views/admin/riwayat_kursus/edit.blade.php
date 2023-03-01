@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA KURSUS') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA KURSUS') }}</a></li>
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
			<h3 class="box-title">Edit Data Kursus</h3>
		</div>
		
		<form action="{{ url('/riwayat_kursus/edit/'.$pegawai[0]->id.'/'.$riwayat_kursus->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA KURSUS</p></center>

					<div class="form-group @if ($errors->has('lokasi_tes')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Lokasi Tes') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('lokasi_tes'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('lokasi_tes') }}</label>@endif
							<input type="text" class="form-control" placeholder="Lokasi Tes" name="lokasi_tes" value="{{ $riwayat_kursus->lokasi_tes }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_tes')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Tes') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_tes'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_tes') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Tes" name="tanggal_tes" value="{{ $riwayat_kursus->tanggal_tes }}">
                                    </div>
						</div>
					</div>

					<div class="form-group @if ($errors->has('score')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Score') }}  <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('score'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('score') }}</label>@endif
							<input type="text" class="form-control" placeholder="Score" name="score" value="{{ $riwayat_kursus->score }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('listening')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Listening') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('listening'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('listening') }}</label>@endif
							<input type="text" class="form-control" placeholder="Listening" name="listening" value="{{ $riwayat_kursus->listening }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('structure')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Structure') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('structure'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('structure') }}</label>@endif
							<input type="text" class="form-control" placeholder="Structure" name="structure" value="{{ $riwayat_kursus->structure }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('reading')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Reading') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('reading'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('reading') }}</label>@endif
							<input type="text" class="form-control" placeholder="Reading" name="reading" value="{{ $riwayat_kursus->reading }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('writing')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Writing') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('writing'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('writing') }}</label>@endif
							<input type="text" class="form-control" placeholder="Writing" name="writing" value="{{ $riwayat_kursus->writing }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('speaking')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Speaking') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('speaking'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('speaking') }}</label>@endif
							<input type="text" class="form-control" placeholder="Speaking" name="speaking" value="{{ $riwayat_kursus->speaking }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_toefl')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Berkas') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-5">
							@if ($errors->has('arsip_toefl'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_toefl') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Jabatan" name="arsip_toefl" value="{{ $riwayat_kursus->arsip_toefl }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png,)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_kursus/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						
						<div class="col-sm-2" @if($errors->has('arsip_toefl')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_kursus->arsip_toefl)
								<a href="{{ asset('upload/arsip_toefl/'.$riwayat_kursus->arsip_toefl) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
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