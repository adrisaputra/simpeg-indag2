@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA KEPANGKATAN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA KEPANGKATAN') }}</a></li>
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
			<h3 class="box-title">Edit Data Kepangkatan</h3>
		</div>
		
		<form action="{{ url('/riwayat_kepangkatan/edit/'.$pegawai[0]->id.'/'.$riwayat_kepangkatan->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA KEPANGKATAN</p></center>

					<div class="form-group @if ($errors->has('periode_kp')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Periode KP') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('periode_kp'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('periode_kp') }}</label>@endif
							<select class="form-control" name="periode_kp">
                                        <option value=""> -Pilih Periode KP-</option>
                                        <option value="April" @if($riwayat_kepangkatan->periode_kp=="April") selected @endif> April</option>
                                        <option value="Oktober" @if($riwayat_kepangkatan->periode_kp=="Oktober") selected @endif> Oktober</option>
                                    </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('periode_kp_sebelumnya')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Periode KP Sebelumnya') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('periode_kp_sebelumnya'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('periode_kp_sebelumnya') }}</label>@endif
							<select class="form-control" name="periode_kp_sebelumnya">
                                        <option value=""> -Pilih Periode KP Sebelumnya-</option>
                                        <option value="April" @if($riwayat_kepangkatan->periode_kp_sebelumnya=="April") selected @endif> April</option>
                                        <option value="Oktober" @if($riwayat_kepangkatan->periode_kp_sebelumnya=="Oktober") selected @endif> Oktober</option>
                                    </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('periode_kp_saat_ini')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Periode KP Saat Ini') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('periode_kp_saat_ini'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('periode_kp_saat_ini') }}</label>@endif
							<select class="form-control" name="periode_kp_saat_ini">
                                        <option value=""> -Pilih Periode KP Saat Ini-</option>
                                        <option value="April" @if($riwayat_kepangkatan->periode_kp_saat_ini=="April") selected @endif> April</option>
                                        <option value="Oktober" @if($riwayat_kepangkatan->periode_kp_saat_ini=="Oktober") selected @endif> Oktober</option>
                                    </select>
						</div>
					</div>

					<div class="form-group  @if ($errors->has('golongan') || $errors->has('status')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Golongan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('golongan') && $errors->has('status')) @elseif ($errors->has('status')) style="padding-top:27px" @endif>
							@if ($errors->has('golongan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('golongan') }}</label>@endif
							<select class="form-control" name="golongan"  @if($riwayat_kepangkatan->golongan) style="border-color: #d3d7df;" @endif>
                                        <option value=""> -Pilih Golongan-</option>
								<option value="Golongan I/a" @if($riwayat_kepangkatan->golongan=="Golongan I/a") selected @endif> Golongan I/a</option>
                                        <option value="Golongan I/b" @if($riwayat_kepangkatan->golongan=="Golongan I/b") selected @endif> Golongan I/b</option>
                                        <option value="Golongan I/c" @if($riwayat_kepangkatan->golongan=="Golongan I/c")selected @endif> Golongan I/c</option>
                                        <option value="Golongan I/d" @if($riwayat_kepangkatan->golongan=="Golongan I/d") selected @endif> Golongan I/d</option>
                                        <option value="Golongan II/a" @if($riwayat_kepangkatan->golongan=="Golongan II/a") selected @endif> Golongan II/a</option>
                                        <option value="Golongan II/b" @if($riwayat_kepangkatan->golongan=="Golongan II/b") selected @endif> Golongan II/b</option>
                                        <option value="Golongan II/c" @if($riwayat_kepangkatan->golongan=="Golongan II/c")selected @endif> Golongan II/c</option>
                                        <option value="Golongan II/d" @if($riwayat_kepangkatan->golongan=="Golongan II/d") selected @endif> Golongan II/d</option>
                                        <option value="Golongan III/a" @if($riwayat_kepangkatan->golongan=="Golongan III/a") selected @endif> Golongan III/a</option>
                                        <option value="Golongan III/b" @if($riwayat_kepangkatan->golongan=="Golongan III/b") selected @endif> Golongan III/b</option>
                                        <option value="Golongan III/c" @if($riwayat_kepangkatan->golongan=="Golongan III/c") selected @endif> Golongan III/c</option>
                                        <option value="Golongan III/d" @if($riwayat_kepangkatan->golongan=="Golongan III/d") selected @endif> Golongan III/d</option>
                                        <option value="Golongan IV/a" @if($riwayat_kepangkatan->golongan=="Golongan IV/a") selected @endif> Golongan IV/a</option>
                                        <option value="Golongan IV/b" @if($riwayat_kepangkatan->golongan=="Golongan IV/b") selected @endif> Golongan IV/b</option>
                                        <option value="Golongan IV/c" @if($riwayat_kepangkatan->golongan=="Golongan IV/c") selected @endif> Golongan IV/c</option>
                                        <option value="Golongan IV/d" @if($riwayat_kepangkatan->golongan=="Golongan IV/d") selected @endif> Golongan IV/d</option>
                                        <option value="Golongan IV/e" @if($riwayat_kepangkatan->golongan=="Golongan IV/e") selected @endif> Golongan IV/e</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tmt')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('TMT') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('tmt'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tmt') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT" name="tmt" value="{{ $riwayat_kepangkatan->tmt }}">
                                    </div>
						</div>
					</div>

					<!-- <div class="form-group  @if ($errors->has('tmt_mulai') || $errors->has('tmt_selesai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('TMT Golongan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('tmt_mulai') && $errors->has('tmt_selesai')) @elseif ($errors->has('tmt_selesai')) style="padding-top:27px" @endif>
							@if ($errors->has('tmt_mulai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tmt_mulai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if($riwayat_kepangkatan->tmt_mulai) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if($riwayat_kepangkatan->tmt_mulai) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Mulai" name="tmt_mulai" value="{{ $riwayat_kepangkatan->tmt_mulai }}" @if($riwayat_kepangkatan->tmt_mulai) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
						<div class="col-sm-3" @if($errors->has('tmt_mulai') && $errors->has('tmt_selesai')) @elseif ($errors->has('tmt_mulai')) style="padding-top:27px" @endif>
							@if ($errors->has('tmt_selesai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tmt_selesai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if($riwayat_kepangkatan->tmt_selesai) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if($riwayat_kepangkatan->tmt_selesai) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Selesai" name="tmt_selesai" value="{{ $riwayat_kepangkatan->tmt_selesai }}" @if($riwayat_kepangkatan->tmt_selesai) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
					</div> -->
					
					<div class="form-group  @if ($errors->has('mk_tahun') || $errors->has('mk_bulan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Masa Kerja Golongan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('mk_tahun') && $errors->has('mk_bulan')) @elseif ($errors->has('mk_bulan')) style="padding-top:27px" @endif>
							@if ($errors->has('mk_tahun'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('mk_tahun') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tahun" name="mk_tahun" value="{{ $riwayat_kepangkatan->mk_tahun }}"   @if($riwayat_kepangkatan->mk_tahun) style="border-color: #d3d7df;" @endif>
						</div>
						<div class="col-sm-3" @if($errors->has('mk_tahun') && $errors->has('mk_bulan')) @elseif ($errors->has('mk_tahun')) style="padding-top:27px" @endif>
							@if ($errors->has('mk_bulan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('mk_bulan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Bulan" name="mk_bulan" value="{{ $riwayat_kepangkatan->mk_bulan }}"   @if($riwayat_kepangkatan->mk_bulan) style="border-color: #d3d7df;" @endif>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_sk')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('No. SK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('no_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_sk') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. SK" name="no_sk" value="{{ $riwayat_kepangkatan->no_sk }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_sk')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Tanggal SK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('tanggal_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_sk') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal SK" name="tanggal_sk" value="{{ $riwayat_kepangkatan->tanggal_sk }}">
                                    </div>
						</div>
					</div>

					<div class="form-group @if ($errors->has('pejabat')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Pejabat Yang Menetapkan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('pejabat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pejabat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Pejabat Yang Menetapkan" name="pejabat" value="{{ $riwayat_kepangkatan->pejabat }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_kepangkatan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Berkas SK KP') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-4">
							@if ($errors->has('arsip_kepangkatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_kepangkatan') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Jabatan" name="arsip_kepangkatan" value="{{ $riwayat_kepangkatan->arsip_kepangkatan }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_kepangkatan/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						
						<div class="col-sm-2" @if($errors->has('arsip_kepangkatan')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_kepangkatan->arsip_kepangkatan)
								<a href="{{ asset('upload/arsip_kepangkatan/'.$riwayat_kepangkatan->arsip_kepangkatan) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
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