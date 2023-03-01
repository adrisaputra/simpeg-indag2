@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA KARYA ILMIAH') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA KARYA ILMIAH') }}</a></li>
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
			<h3 class="box-title">Tambah Data Karya Ilmiah</h3>
		</div>
		
		<form action="{{ url('/riwayat_karya_ilmiah/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA KARYA ILMIAH</p></center>

					<div class="form-group @if ($errors->has('jenis_buku')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis Buku') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis_buku'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_buku') }}</label>@endif
							<select class="form-control" name="jenis_buku">
                                        <option value=""> -Pilih Jenis Buku-</option>
                                        <option value="Makalah" @if(old('jenis_buku')=="Makalah") selected @endif> Makalah</option>
                                        <option value="Artikel" @if(old('jenis_buku')=="Artikel") selected @endif> Artikel</option>
                                        <option value="Skripsi" @if(old('jenis_buku')=="Skripsi") selected @endif> Skripsi</option>
                                        <option value="Kertas Kerja" @if(old('jenis_buku')=="Kertas Kerja") selected @endif> Kertas Kerja</option>
                                        <option value="Paper" @if(old('jenis_buku')=="Paper") selected @endif> Paper</option>
                                        <option value="Tesis" @if(old('jenis_buku')=="Tesis") selected @endif> Tesis</option>
                                        <option value="Disertasi" @if(old('jenis_buku')=="Disertasi") selected @endif> Disertasi</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('judul_buku')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Judul Buku') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('judul_buku'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('judul_buku') }}</label>@endif
							<input type="text" class="form-control" placeholder="Judul Buku" name="judul_buku" value="{{ old('judul_buku') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jenis_kegiatan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis Kegiatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis_kegiatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_kegiatan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jenis Kegiatan" name="jenis_kegiatan" value="{{ old('jenis_kegiatan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('peranan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Peranan ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('peranan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('peranan') }}</label>@endif
							<select class="form-control" name="peranan">
                                        <option value=""> -Pilih Peranan -</option>
                                        <option value="Peneliti" @if(old('peranan')=="Peneliti") selected @endif> Peneliti</option>
                                        <option value="Penulis Utama" @if(old('peranan')=="Penulis Utama") selected @endif> Penulis Utama</option>
                                        <option value="Penulis Pendamping" @if(old('peranan')=="Penulis Pendamping") selected @endif> Penulis Pendamping</option>
                                        <option value="Penulis Tamu" @if(old('peranan')=="Penulis Tamu") selected @endif> Penulis Tamu</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tahun')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tahun Diterbitkan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tahun'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tahun') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tahun" name="tahun" value="{{ old('tahun') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_karya_ilmiah')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Arsip Karya Ilmiah') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('arsip_karya_ilmiah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_karya_ilmiah') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Karya Ilmiah" name="arsip_karya_ilmiah" value="{{ old('arsip_karya_ilmiah') }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_karya_ilmiah/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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