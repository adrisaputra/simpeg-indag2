@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA SUAMI/ISTRI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA SUAMI/ISTRI') }}</a></li>
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
			<h3 class="box-title">Edit Data Suami/Istri</h3>
		</div>
		
		<form action="{{ url('/riwayat_pasangan/edit/'.$pegawai[0]->id.'/'.$riwayat_pasangan->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA SUAMI/ISTRI</p></center>

					
					<div class="form-group @if ($errors->has('nama_pasangan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Suami/Istri') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_pasangan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_pasangan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Suami/Istri" name="nama_pasangan" value="{{ $riwayat_pasangan->nama_pasangan }}" >
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
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir" name="tanggal_lahir" value="{{ $riwayat_pasangan->tanggal_lahir }}">
                                    </div>	
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('status')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Status') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('status'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('status') }}</label>@endif
							<select class="form-control" name="status">
                                        <option value=""> -Pilih Status-</option>
                                        <option value="Menikah" @if($riwayat_pasangan->status=="Menikah") selected @endif> Menikah</option>
                                        <option value="Cerai Mati" @if($riwayat_pasangan->status=="Cerai Mati") selected @endif> Cerai Mati</option>
                                        <option value="Cerai Hidup" @if($riwayat_pasangan->status=="Cerai Hidup") selected @endif> Cerai Hidup</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_nikah')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Nikah') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_nikah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_nikah') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Nikah" name="tanggal_nikah" value="{{ $riwayat_pasangan->tanggal_nikah }}">
                                    </div>	
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_cerai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Cerai') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_cerai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_cerai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Cerai" name="tanggal_cerai" value="{{ $riwayat_pasangan->tanggal_cerai }}">
                                    </div>	
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_meninggal')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Meninggal') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_meninggal'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_meninggal') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Meninggal" name="tanggal_meninggal" value="{{ $riwayat_pasangan->tanggal_meninggal }}">
                                    </div>	
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('pekerjaan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pekerjaan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('pekerjaan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pekerjaan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Pekerjaan" name="pekerjaan" value="{{ $riwayat_pasangan->pekerjaan }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('surat_nikah')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Surat Nikah') }}</label>
						<div class="col-sm-4">
							@if ($errors->has('surat_nikah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('surat_nikah') }}</label>@endif
							<input type="file" class="form-control" placeholder="Surat Nikah" name="surat_nikah" value="{{ $riwayat_pasangan->surat_nikah }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
						</div>
						<div class="col-sm-2" @if($errors->has('surat_nikah')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_pasangan->surat_nikah)
								<a href="{{ asset('upload/surat_nikah/'.$riwayat_pasangan->surat_nikah) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>
					
					
					<div class="form-group @if ($errors->has('surat_cerai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Surat Cerai') }}</label>
						<div class="col-sm-4">
							@if ($errors->has('surat_cerai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('surat_cerai') }}</label>@endif
							<input type="file" class="form-control" placeholder="Surat Cerai" name="surat_cerai" value="{{ $riwayat_pasangan->surat_cerai }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_pasangan/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						
						<div class="col-sm-2" @if($errors->has('surat_cerai')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_pasangan->surat_cerai)
								<a href="{{ asset('upload/surat_cerai/'.$riwayat_pasangan->surat_cerai) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
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