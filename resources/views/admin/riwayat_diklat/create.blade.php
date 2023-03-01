@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA DIKLAT') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA DIKLAT') }}</a></li>
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
			<h3 class="box-title">Tambah Data Diklat</h3>
		</div>
		
		<form action="{{ url('/riwayat_diklat/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA DIKLAT</p></center>

					<div class="form-group @if ($errors->has('kelompok_diklat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('kelompok Diklat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('kelompok_diklat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('kelompok_diklat') }}</label>@endif
							<select class="form-control" name="kelompok_diklat">
                                        <option value=""> -Pilih kelompok Diklat-</option>
                                        <option value="Diklat Prajabatan" @if(old('kelompok_diklat')=="Diklat Prajabatan") selected @endif> Diklat Prajabatan</option>
                                        <option value="Diklat Kepemimpinan" @if(old('kelompok_diklat')=="Diklat Kepemimpinan") selected @endif> Diklat Kepemimpinan</option>
                                        <option value="Diklat Fungsional" @if(old('kelompok_diklat')=="Diklat Fungsional") selected @endif> Diklat Fungsional</option>
                                        <option value="Diklat Teknis" @if(old('kelompok_diklat')=="Diklat Teknis") selected @endif> Diklat Teknis</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jenis_diklat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis Diklat ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis_diklat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_diklat') }}</label>@endif
							<select class="form-control" name="jenis_diklat">
                                        <option value=""> -Pilih Jenis Diklat -</option>
                                        <option value="Diklat Prajab Gol. I" @if(old('jenis_diklat')=="Diklat Prajab Gol. I") selected @endif> Diklat Prajab Gol. I</option>
                                        <option value="Diklat Prajab Gol. II" @if(old('jenis_diklat')=="Diklat Prajab Gol. II") selected @endif> Diklat Prajab Gol. II</option>
                                        <option value="Diklat Prajab Gol. III" @if(old('jenis_diklat')=="Diklat Prajab Gol. III") selected @endif> Diklat Prajab Gol. III</option>
                                        <option value="Diklatpim Tk. IV" @if(old('jenis_diklat')=="Diklatpim Tk. IV") selected @endif> Diklatpim Tk. IV</option>
                                        <option value="Diklatpim Tk. III" @if(old('jenis_diklat')=="Diklatpim Tk. III") selected @endif> Diklatpim Tk. III</option>
                                        <option value="Diklatpim Tk. II" @if(old('jenis_diklat')=="Diklatpim Tk. II") selected @endif> Diklatpim Tk. II</option>
                                        <option value="Diklatpim Tk. I" @if(old('jenis_diklat')=="Diklatpim Tk. I") selected @endif> Diklatpim Tk. I</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('nama_diklat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Diklat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_diklat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_diklat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Diklat" name="nama_diklat" value="{{ old('nama_diklat') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('negara')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Negara') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('negara'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('negara') }}</label>@endif
							<input type="text" class="form-control" placeholder="Negara" name="negara" value="{{ old('negara') }}" >
						</div>
					</div>
					
					<div class="form-group  @if ($errors->has('lokasi') || $errors->has('kota')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Lokasi') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('lokasi') && $errors->has('kota')) @elseif ($errors->has('kota')) style="padding-top:27px" @endif>
							@if ($errors->has('lokasi'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('lokasi') }}</label>@endif
							<input type="text" class="form-control" placeholder="Lokasi" name="lokasi" value="{{ old('lokasi') }}" @if(old('lokasi')) style="border-color: #d3d7df;" @endif>
						</div>
						<div class="col-sm-3" @if($errors->has('lokasi') && $errors->has('kota')) @elseif ($errors->has('lokasi')) style="padding-top:27px" @endif>
							@if ($errors->has('kota'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('kota') }}</label>@endif
							<input type="text" class="form-control" placeholder="Kota" name="kota" value="{{ old('kota') }}" @if(old('kota')) style="border-color: #d3d7df;" @endif>
						</div>
					</div>
					
					<div class="form-group  @if ($errors->has('tmt_mulai') || $errors->has('tmt_selesai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('TMT') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('tmt_mulai') && $errors->has('tmt_selesai')) @elseif ($errors->has('tmt_selesai')) style="padding-top:27px" @endif>
							@if ($errors->has('tmt_mulai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tmt_mulai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('tmt_mulai')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('tmt_mulai')) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Mulai" name="tmt_mulai" value="{{ old('tmt_mulai') }}" @if(old('tmt_mulai')) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
						<div class="col-sm-3" @if($errors->has('tmt_mulai') && $errors->has('tmt_selesai')) @elseif ($errors->has('tmt_mulai')) style="padding-top:27px" @endif>
							@if ($errors->has('tmt_selesai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tmt_selesai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('tmt_selesai')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('tmt_selesai')) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Selesai" name="tmt_selesai" value="{{ old('tmt_selesai') }}" @if(old('tmt_selesai')) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
					</div>
					
					<div class="form-group  @if ($errors->has('hari') || $errors->has('jam')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Konversi') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('hari') && $errors->has('jam')) @elseif ($errors->has('jam')) style="padding-top:27px" @endif>
							@if ($errors->has('hari'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('hari') }}</label>@endif
							<input type="text" class="form-control" placeholder="Hari" name="hari" value="{{ old('hari') }}" @if(old('hari')) style="border-color: #d3d7df;" @endif>
						</div>
						<div class="col-sm-3" @if($errors->has('hari') && $errors->has('jam')) @elseif ($errors->has('hari')) style="padding-top:27px" @endif>
							@if ($errors->has('jam'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jam') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jam" name="jam" value="{{ old('jam') }}" @if(old('jam')) style="border-color: #d3d7df;" @endif>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('kualitas')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Kualitas') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('kualitas'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('kualitas') }}</label>@endif
							<input type="text" class="form-control" placeholder="Kualitas" name="kualitas" value="{{ old('kualitas') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_diklat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Arsip Diklat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('arsip_diklat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_diklat') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Diklat" name="arsip_diklat" value="{{ old('arsip_diklat') }}" >
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