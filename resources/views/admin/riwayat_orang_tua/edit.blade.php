@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA ORANG TUA') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA ORANG TUA') }}</a></li>
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
			<h3 class="box-title">Edit Data Orang Tua</h3>
		</div>
		
		<form action="{{ url('/riwayat_orang_tua/edit/'.$pegawai[0]->id.'/'.$riwayat_orang_tua->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA ORANG TUA</p></center>

					<div class="form-group @if ($errors->has('orang_tua')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Orang Tua') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('orang_tua'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('orang_tua') }}</label>@endif
							<select class="form-control" name="orang_tua">
                                        <option value=""> -Pilih Orang Tua-</option>
                                        <option value="Ayah" @if($riwayat_orang_tua->orang_tua=="Ayah") selected @endif> Ayah</option>
                                        <option value="Ibu" @if($riwayat_orang_tua->orang_tua=="Ibu") selected @endif> Ibu</option>
                                    </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('nama_orang_tua')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Orang Tua') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_orang_tua'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_orang_tua') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Orang Tua" name="nama_orang_tua" value="{{ $riwayat_orang_tua->nama_orang_tua }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_lahir')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Lahir') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_lahir'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_lahir') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir" name="tanggal_lahir" value="{{ $riwayat_orang_tua->tanggal_lahir }}">
                                    </div>
						</div>
					</div>

					
					<div class="form-group @if ($errors->has('pekerjaan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pekerjaan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('pekerjaan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pekerjaan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Pekerjaan" name="pekerjaan" value="{{ $riwayat_orang_tua->pekerjaan }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('kartu_keluarga')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Kartu Keluarga') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-4">
							@if ($errors->has('kartu_keluarga'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('kartu_keluarga') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Jabatan" name="kartu_keluarga" value="{{ $riwayat_orang_tua->kartu_keluarga }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_orang_tua/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						
						<div class="col-sm-2" @if($errors->has('kartu_keluarga')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_orang_tua->kartu_keluarga)
								<a href="{{ asset('upload/kartu_keluarga/'.$riwayat_orang_tua->kartu_keluarga) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
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