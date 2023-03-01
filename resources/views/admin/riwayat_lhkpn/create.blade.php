@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA LHKPN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA LHKPN') }}</a></li>
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
			<h3 class="box-title">Tambah Data Lhkpn</h3>
		</div>
		
		<form action="{{ url('/riwayat_lhkpn/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA LHKPN</p></center>

					<div class="form-group @if ($errors->has('nama_lhkpn')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_lhkpn'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_lhkpn') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama" name="nama_lhkpn" value="{{ old('nama_lhkpn') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_lapor')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Lapor') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_lapor'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_lapor') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Lapor" name="tanggal_lapor" value="{{ old('tanggal_lapor') }}">
                                    </div>
						</div>
					</div>

					<div class="form-group @if ($errors->has('jenis_pelaporan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis Pelaporan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis_pelaporan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_pelaporan') }}</label>@endif
							<select class="form-control" name="jenis_pelaporan">
                                        <option value=""> -Pilih Jenis Pelaporan-</option>
                                        <option value="Khusus" @if(old('jenis_pelaporan')=="Khusus") selected @endif> Khusus</option>
                                        <option value="Periodik" @if(old('jenis_pelaporan')=="Periodik") selected @endif> Periodik</option>
                                    </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('jabatan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jabatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jabatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jabatan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jabatan" name="jabatan" value="{{ old('jabatan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('status_laporan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Status laporan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('status_laporan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('status_laporan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Status laporan" name="status_laporan" value="{{ old('status_laporan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_lhkpn')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Berkas LHKPN') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('arsip_lhkpn'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_lhkpn') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Jabatan" name="arsip_lhkpn" value="{{ old('arsip_lhkpn') }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_lhkpn/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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