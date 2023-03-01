@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __($title) }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __($title) }}</a></li>
	</ol>
	</section>

	<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Edit {{ __($title) }}</h3>
		</div>
		
		<form action="{{ url('/'.Request::segment(1).'/edit/'.$honorer->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">
					
					
				<div class="form-group @if ($errors->has('nama_pegawai')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Nama Pegawai Honorer') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('nama_pegawai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_pegawai') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Pegawai Honorer" name="nama_pegawai" value="{{ $honorer->nama_pegawai }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tempat_lahir')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Tempat Lahir') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('tempat_lahir'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tempat_lahir') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" value="{{ $honorer->tempat_lahir }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_lahir')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Tanggal Lahir') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('tanggal_lahir'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_lahir') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir" name="tanggal_lahir" value="{{ $honorer->tanggal_lahir }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jenis_kelamin')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Jenis Kelamin') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('jenis_kelamin'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_kelamin') }}</label>@endif
							<select class="form-control select2" name="jenis_kelamin">
                                        <option value=""> -Pilih Jenis Kelamin-</option>
                                        <option value="Pria" @if($honorer->jenis_kelamin=="Pria") selected @endif> Pria</option>
                                        <option value="Wanita" @if($honorer->jenis_kelamin=="Wanita") selected @endif> Wanita</option>
                                       
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('alamat')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Alamat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('alamat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('alamat') }}</label>@endif
							<textarea class="form-control" placeholder="Alamat" name="alamat">{{ $honorer->alamat }}</textarea>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('agama')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Agama') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('agama'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('agama') }}</label>@endif
							<select class="form-control select2" name="agama">
                                        <option value=""> -Pilih Agama-</option>
                                        <option value="Islam" @if($honorer->agama=="Islam") selected @endif> Islam</option>
                                        <option value="Katolik" @if($honorer->agama=="Katolik") selected @endif> Katolik</option>
                                        <option value="Hindu" @if($honorer->agama=="Hindu") selected @endif> Hindu</option>
                                        <option value="Budha" @if($honorer->agama=="Budha") selected @endif> Budha</option>
                                        <option value="Sinto" @if($honorer->agama=="Sinto") selected @endif> Sinto</option>
                                        <option value="Konghucu" @if($honorer->agama=="Konghucu") selected @endif> Konghucu</option>
                                        <option value="Protestan" @if($honorer->agama=="Protestan") selected @endif> Protestan</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('gol_darah')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Gol. Darah') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('gol_darah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('gol_darah') }}</label>@endif
							<select class="form-control select2" name="gol_darah">
                                        <option value=""> -Pilih Gol. Darah-</option>
                                        <option value="A" @if($honorer->gol_darah=="A") selected @endif> A</option>
                                        <option value="B" @if($honorer->gol_darah=="B") selected @endif> B</option>
                                        <option value="AB" @if($honorer->gol_darah=="AB") selected @endif> AB</option>
                                        <option value="O" @if($honorer->gol_darah=="O") selected @endif> O</option>
                                       
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('email')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Email') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('email'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}</label>@endif
							<input type="email" class="form-control" placeholder="Email" name="email" value="{{ $honorer->email }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('pendidikan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Pendidikan') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('pendidikan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pendidikan') }}</label>@endif
							<select class="form-control" name="pendidikan">
                                        <option value=""> -Pilih Tingkat-</option>
                                        <option value="SD" @if($honorer->pendidikan=="SD") selected @endif> SD</option>
                                        <option value="SLTP" @if($honorer->pendidikan=="SLTP") selected @endif> SLTP</option>
                                        <option value="SLTP Kejuruan" @if($honorer->pendidikan=="SLTP Kejuruan") selected @endif> SLTP Kejuruan</option>
                                        <option value="SLTA" @if($honorer->pendidikan=="SLTA") selected @endif> SLTA</option>
                                        <option value="SLTA Kejuruan" @if($honorer->pendidikan=="SLTA Kejuruan") selected @endif> SLTA Kejuruan</option>
                                        <option value="SLTA Keguruan" @if($honorer->pendidikan=="SLTA Keguruan") selected @endif> SLTA Keguruan</option>
                                        <option value="Diploma I" @if($honorer->pendidikan=="Diploma I") selected @endif> Diploma I</option>
                                        <option value="Diploma II" @if($honorer->pendidikan=="Diploma II") selected @endif> Diploma II</option>
                                        <option value="Diploma III / Sarjana Muda" @if($honorer->pendidikan=="Diploma III / Sarjana Muda") selected @endif> Diploma III / Sarjana Muda</option>
                                        <option value="Diploma IV" @if($honorer->pendidikan=="Diploma IV") selected @endif> Diploma IV</option>
                                        <option value="S1 / Sarjana" @if($honorer->pendidikan=="S1 / Sarjana") selected @endif> S1 / Sarjana</option>
                                        <option value="S2" @if($honorer->pendidikan=="S2") selected @endif> S2</option>
                                        <option value="S3 / Doktor" @if($honorer->pendidikan=="S3 / Doktor") selected @endif> S3 / Doktor</option>
                                    </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('sk_honorer')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Berkas SK Honorer ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-4">
							@if ($errors->has('sk_honorer'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('foto_formal') }}</label>@endif
							<input type="file" class="form-control" placeholder="Foto" name="sk_honorer" value="{{ $honorer->sk_honorer }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							@if($honorer->sk_honorer)
								<img src="{{ asset('upload/sk_honorer/'.$honorer->sk_honorer) }}" width="150px" height="150px">
							@endif
						</div>
					</div>

					<div class="form-group @if ($errors->has('group')) has-error @endif">
						<label class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
							<div>
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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