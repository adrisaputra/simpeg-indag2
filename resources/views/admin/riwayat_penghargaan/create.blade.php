@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA PENGHARGAAN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA PENGHARGAAN') }}</a></li>
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
			<h3 class="box-title">Tambah Data Penghargaan</h3>
		</div>
		
		<form action="{{ url('/riwayat_penghargaan/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA PENGHARGAAN</p></center>

					<div class="form-group @if ($errors->has('nama_penghargaan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Penghargaan ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_penghargaan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_penghargaan') }}</label>@endif
							<select class="form-control" name="nama_penghargaan">
                                        <option value=""> -Pilih Nama Penghargaan -</option>
                                        <option value="Satyalancana Karya Satya 10 Tahun" @if(old('nama_penghargaan')=="Satyalancana Karya Satya 10 Tahun") selected @endif> Satyalancana Karya Satya 10 Tahun</option>
                                        <option value="Satyalancana Karya Satya 20 Tahun" @if(old('nama_penghargaan')=="Satyalancana Karya Satya 20 Tahun") selected @endif> Satyalancana Karya Satya 20 Tahun</option>
                                        <option value="Satyalancana Karya Satya 30 Tahun" @if(old('nama_penghargaan')=="Satyalancana Karya Satya 30 Tahun") selected @endif> Satyalancana Karya Satya 30 Tahun</option>
                                        <option value="Dan Lain-lain" @if(old('nama_penghargaan')=="Dan Lain-lain") selected @endif> Dan Lain-lain</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_sk')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. SK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('no_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_sk') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. SK" name="no_sk" value="{{ old('no_sk') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_sk')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal SK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_sk') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal SK" name="tanggal_sk" value="{{ old('tanggal_sk') }}">
                                    </div>
						</div>
					</div>

					<div class="form-group @if ($errors->has('keterangan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Keterangan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('keterangan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('keterangan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Keterangan" name="keterangan" value="{{ old('keterangan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_penghargaan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Berkas') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('arsip_penghargaan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_penghargaan') }}</label>@endif
							<input type="file" class="form-control" placeholder="Berkas" name="arsip_penghargaan" value="{{ old('arsip_penghargaan') }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_diklat/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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