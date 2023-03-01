@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA ANAK') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA ANAK') }}</a></li>
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
			<h3 class="box-title">Edit Data Anak</h3>
		</div>
		
		<form action="{{ url('/riwayat_anak/edit/'.$pegawai[0]->id.'/'.$riwayat_anak->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA ANAK</p></center>

					
					<div class="form-group @if ($errors->has('nama_anak')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Anak') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_anak'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_anak') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Anak" name="nama_anak" value="{{ $riwayat_anak->nama_anak }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jenis_kelamin')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis Kelamin') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis_kelamin'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_kelamin') }}</label>@endif
							<select class="form-control select2" name="jenis_kelamin">
                                        <option value=""> -Pilih Jenis Kelamin-</option>
                                        <option value="Pria" @if($riwayat_anak->jenis_kelamin=="Pria") selected @endif> Pria</option>
                                        <option value="Wanita" @if($riwayat_anak->jenis_kelamin=="Wanita") selected @endif> Wanita</option>
                                       
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_lahir')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Lahir') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_lahir'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_lahir') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir" name="tanggal_lahir" value="{{ $riwayat_anak->tanggal_lahir }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('status')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Status') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('status'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('status') }}</label>@endif
							<select class="form-control select2" name="status">
                                        <option value=""> -Pilih Status-</option>
                                        <option value="Kandung" @if($riwayat_anak->status=="Kandung") selected @endif> Kandung</option>
                                        <option value="Tiri" @if($riwayat_anak->status=="Tiri") selected @endif> Tiri</option>
                                        <option value="Angkat" @if($riwayat_anak->status=="Angkat") selected @endif> Angkat</option>
                                       
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('pendidikan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pendidikan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('pendidikan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pendidikan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Pendidikan" name="pendidikan" value="{{ $riwayat_anak->pendidikan }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('akta_kelahiran')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Akta Kelahiran') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-4">
							@if ($errors->has('akta_kelahiran'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('akta_kelahiran') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Jabatan" name="akta_kelahiran" value="{{ $riwayat_anak->akta_kelahiran }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_anak/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						
						<div class="col-sm-2" @if($errors->has('akta_kelahiran')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_anak->akta_kelahiran)
								<a href="{{ asset('upload/akta_kelahiran/'.$riwayat_anak->akta_kelahiran) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
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