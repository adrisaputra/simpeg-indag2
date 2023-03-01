@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA CUTI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA CUTI') }}</a></li>
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
			<h3 class="box-title">Tambah Data Cuti</h3>
		</div>
		
		<form action="{{ url('/riwayat_cuti/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA CUTI</p></center>

					<div class="form-group @if ($errors->has('jenis_cuti')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis Cuti ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis_cuti'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_cuti') }}</label>@endif
							<select class="form-control" name="jenis_cuti">
                                        <option value=""> -Pilih Jenis Cuti -</option>
                                        <option value="Cuti Tahunan" @if(old('jenis_cuti')=="Cuti Tahunan") selected @endif> Cuti Tahunan</option>
                                        <option value="Cuti Besar" @if(old('jenis_cuti')=="Cuti Besar") selected @endif> Cuti Besar</option>
                                        <option value="Cuti Sakit" @if(old('jenis_cuti')=="Cuti Sakit") selected @endif> Cuti Sakit</option>
                                        <option value="Cuti Melahirkan" @if(old('jenis_cuti')=="Cuti Melahirkan") selected @endif> Cuti Melahirkan</option>
                                        <option value="Cuti Karena Alasan Penting" @if(old('jenis_cuti')=="Cuti Karena Alasan Penting") selected @endif> Cuti Karena Alasan Penting</option>
                                        <option value="Cuti di Luar Tanggungan Negara" @if(old('jenis_cuti')=="Cuti di Luar Tanggungan Negara") selected @endif> Cuti di Luar Tanggungan Negara</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('keterangan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Keterangan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('keterangan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('keterangan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Keterangan" name="keterangan" value="{{ old('keterangan') }}" >
						</div>
					</div>
					
					<div class="form-group  @if ($errors->has('mulai') || $errors->has('selesai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Periode Cuti') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('mulai') && $errors->has('selesai')) @elseif ($errors->has('selesai')) style="padding-top:27px" @endif>
							@if ($errors->has('mulai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('mulai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('mulai')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('mulai')) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Mulai" name="mulai" value="{{ old('mulai') }}" @if(old('mulai')) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
						<div class="col-sm-3" @if($errors->has('mulai') && $errors->has('selesai')) @elseif ($errors->has('mulai')) style="padding-top:27px" @endif>
							@if ($errors->has('selesai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('selesai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('selesai')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('selesai')) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Selesai" name="selesai" value="{{ old('selesai') }}" @if(old('selesai')) style="border-color: #d3d7df;" @endif>
                                    </div>
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

					<div class="form-group @if ($errors->has('arsip_cuti')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Berkas') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('arsip_cuti'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_cuti') }}</label>@endif
							<input type="file" class="form-control" placeholder="Berkas" name="arsip_cuti" value="{{ old('arsip_cuti') }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png,)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_cuti/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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