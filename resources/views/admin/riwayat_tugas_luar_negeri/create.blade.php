@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA TUGAS LUAR NEGERI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA TUGAS LUAR NEGERI') }}</a></li>
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
			<h3 class="box-title">Tambah Data Tugas Luar Negeri</h3>
		</div>
		
		<form action="{{ url('/riwayat_tugas_luar_negeri/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA TUGAS LUAR NEGERI</p></center>

					<div class="form-group @if ($errors->has('tipe_kunjungan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tipe Kunjungan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tipe_kunjungan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tipe_kunjungan') }}</label>@endif
							<select class="form-control" name="tipe_kunjungan">
                                        <option value=""> -Pilih Tipe Kunjungan-</option>
                                        <option value="Kerjasama Pemerintah Daerah Dengan Pihak Luar Negeri" @if(old('tipe_kunjungan')=="Kerjasama Pemerintah Daerah Dengan Pihak Luar Negeri") selected @endif> Kerjasama Pemerintah Daerah Dengan Pihak Luar Negeri</option>
                                        <option value="Pendidikan Dan Pelatihan" @if(old('tipe_kunjungan')=="Pendidikan Dan Pelatihan") selected @endif> Pendidikan Dan Pelatihan</option>
                                        <option value="Studi Banding" @if(old('tipe_kunjungan')=="Studi Banding") selected @endif> Studi Banding</option>
                                        <option value="Seminar" @if(old('tipe_kunjungan')=="Seminar") selected @endif> Seminar</option>
                                        <option value="Lokakarya" @if(old('tipe_kunjungan')=="Lokakarya") selected @endif> Lokakarya</option>
                                        <option value="Konferensi" @if(old('tipe_kunjungan')=="Konferensi") selected @endif> Konferensi</option>
                                        <option value="Promosi Potensi Daerah" @if(old('tipe_kunjungan')=="Promosi Potensi Daerah") selected @endif> Promosi Potensi Daerah</option>
                                        <option value="Kunjungan Persahabatan/Kebudayaan" @if(old('tipe_kunjungan')=="Kunjungan Persahabatan/Kebudayaan") selected @endif> Kunjungan Persahabatan/Kebudayaan</option>
                                        <option value="Pertemuan Internasional" @if(old('tipe_kunjungan')=="Pertemuan Internasional") selected @endif> Pertemuan Internasional</option>
                                        <option value="Penandatanganan Perjanjian Internasional" @if(old('tipe_kunjungan')=="Penandatanganan Perjanjian Internasional") selected @endif> Penandatanganan Perjanjian Internasional</option>
                                    </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('tujuan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tujuan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tujuan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tujuan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tujuan" name="tujuan" value="{{ old('tujuan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('negara')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Negara') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('negara'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('negara') }}</label>@endif
							<input type="text" class="form-control" placeholder="Negara" name="negara" value="{{ old('negara') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_mulai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Mulai') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_mulai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_mulai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_selesai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Selesai') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_selesai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_selesai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('asal_dana')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Asal Dana') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('asal_dana'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('asal_dana') }}</label>@endif
							<input type="text" class="form-control" placeholder="Asal Dana" name="asal_dana" value="{{ old('asal_dana') }}" >

							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_tugas_luar_negeri/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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