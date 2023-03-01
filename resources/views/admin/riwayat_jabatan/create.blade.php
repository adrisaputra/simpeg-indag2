@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA JABATAN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA JABATAN') }}</a></li>
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
			<h3 class="box-title">Tambah Data Jabatan</h3>
		</div>
		
		<form action="{{ url('/riwayat_jabatan/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA JABATAN</p></center>

					<div class="form-group @if ($errors->has('status_mutasi_instansi')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Status Mutasi Instansi') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('status_mutasi_instansi'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('status_mutasi_instansi') }}</label>@endif
							<input type="text" class="form-control" placeholder="Status Mutasi Instansi" name="status_mutasi_instansi" value="{{ old('status_mutasi_instansi') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tipe_jabatan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Tipe Jabatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('tipe_jabatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tipe_jabatan') }}</label>@endif
							<select class="form-control" name="tipe_jabatan">
                                        <option value=""> -Pilih Tipe Jabatan-</option>
                                        <option value="Struktural" @if(old('tipe_jabatan')=="Struktural") selected @endif> Struktural</option>
                                        <option value="Fungsional Tertentu" @if(old('tipe_jabatan')=="Fungsional Tertentu") selected @endif> Fungsional Tertentu</option>
                                        <option value="Fungsional Umum" @if(old('tipe_jabatan')=="Fungsional Umum") selected @endif> Fungsional Umum</option>
                                    </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('jenjang')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Jenjang') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('jenjang'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenjang') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jenjang" name="jenjang" value="{{ old('jenjang') }}" >
						</div>
					</div>

					<div class="form-group @if ($errors->has('status_mutasi_pegawai')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Status Mutasi Pegawai') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('status_mutasi_pegawai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('status_mutasi_pegawai') }}</label>@endif
							<input type="text" class="form-control" placeholder="Status Mutasi Pegawai" name="status_mutasi_pegawai" value="{{ old('status_mutasi_pegawai') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jabatan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Jabatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('jabatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jabatan') }}</label>@endif
							<select class="form-control" name="jabatan">
                                        <option value=""> -Pilih Jabatan-</option>
                                        <option value="Kepala Dinas" @if(old('jabatan')=="Kepala Dinas") selected @endif> Kepala Dinas</option>
                                        <option value="Sekretaris" @if(old('jabatan')=="Sekretaris") selected @endif> Sekretaris</option>
                                        <option value="Kepala Bidang" @if(old('jabatan')=="Kepala Bidang") selected @endif> Kepala Bidang</option>
                                        <option value="Kepala UPTD" @if(old('jabatan')=="Kepala UPTD") selected @endif> Kepala UPTD</option>
                                        <option value="Kepala Sub Bagian" @if(old('jabatan')=="Kepala Sub Bagian") selected @endif> Kepala Sub Bagian</option>
                                        <option value="Kepala Seksi" @if(old('jabatan')=="Kepala Seksi") selected @endif> Kepala Seksi</option>
                                        <option value="Staf" @if(old('jabatan')=="Staf") selected @endif> Staf</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('status')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Status') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('status'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('status') }}</label>@endif
							<input type="text" class="form-control" placeholder="Status" name="status" value="{{ old('status') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('instansi_asal')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Instansi Asal') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('instansi_asal'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('instansi_asal') }}</label>@endif
							<input type="text" class="form-control" placeholder="Instansi Asal" name="instansi_asal" value="{{ old('instansi_asal') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tmt_mulai') || $errors->has('tmt_selesai')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('TMT Jabatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
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
					
					<div class="form-group  @if ($errors->has('no_sk') || $errors->has('tanggal_sk')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('No. SK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('no_sk') && $errors->has('tanggal_sk')) @elseif ($errors->has('tanggal_sk')) style="padding-top:27px" @endif>
							@if ($errors->has('no_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_sk') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. SK" name="no_sk" value="{{ old('no_sk') }}" @if(old('no_sk')) style="border-color: #d3d7df;" @endif>
						</div>
						<div class="col-sm-3" @if($errors->has('no_sk') && $errors->has('tanggal_sk')) @elseif ($errors->has('no_sk')) style="padding-top:27px" @endif>
							@if ($errors->has('tanggal_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_sk') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('tanggal_sk')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('tanggal_sk')) style="border-color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal SK" name="tanggal_sk" value="{{ old('tanggal_sk') }}" @if(old('tanggal_sk')) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tunjangan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Tunjangan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('tunjangan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tunjangan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Rp." name="tunjangan" onkeyup="formatRupiah(this, '.')" value="{{ old('tunjangan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('esselon')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Esselon') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('esselon'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('esselon') }}</label>@endif
							<select class="form-control" name="esselon">
                                        <option value=""> -Pilih Esselon-</option>
                                        <option value="I b" @if(old('esselon')=="I b") selected @endif> I b</option>
                                        <option value="II a" @if(old('esselon')=="II a") selected @endif> II a</option>
                                        <option value="II b" @if(old('esselon')=="II b") selected @endif> II b</option>
                                        <option value="III a" @if(old('esselon')=="III a") selected @endif> III a</option>
                                        <option value="III b" @if(old('esselon')=="III b") selected @endif> III b</option>
                                        <option value="IV a" @if(old('esselon')=="IV a") selected @endif> IV a</option>
                                        <option value="IV b" @if(old('esselon')=="IV b") selected @endif> IV b</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('keterangan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Keterangan') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('keterangan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('keterangan') }}</label>@endif
							<textarea class="form-control" placeholder="Keterangan" name="keterangan">{{ old('keterangan') }}</textarea>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_jabatan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Arsip Jabatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('arsip_jabatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_jabatan') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Jabatan" name="arsip_jabatan" value="{{ old('arsip_jabatan') }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_jabatan/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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