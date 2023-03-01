@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __('PEGAWAI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('PEGAWAI') }}</a></li>
	</ol>
	</section>
	
	<section class="content">
	<div class="box">   
		<div class="box-header with-border">
			<div class="box-tools pull-left">
				<div style="padding-top:10px">
					@if(Auth::user()->group==1)
						<a href="{{ url('/pegawai/create') }}" class="btn btn-success btn-flat" title="Tambah Data">Tambah</a>
						<a href="{{ url('/pegawai') }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>    
						<button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#importExcel">
							Import Data Pegawai
						</button>
					@else
						<a href="{{ url('/pegawai') }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>    
					@endif
			
					<!-- Import Excel -->
					<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<form method="post" action="{{ url('/public/pegawai/import_excel') }}" enctype="multipart/form-data">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
									</div>
									<div class="modal-body">
			
										{{ csrf_field() }}
			
										<label>Pilih file excel</label>
										<div class="form-group">
											<input type="file" name="file" required="required">
										</div>
			
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Import</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/pegawai/search') }}" method="GET">
						<div class="input-group margin">
							<input type="text" class="form-control" name="search" placeholder="Masukkan kata kunci pencarian">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-danger btn-flat">cari</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		</div>
			
			<div class="table-responsive box-body">

				@if ($message = Session::get('status'))
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i>Berhasil !</h4>
						{{ $message }}
					</div>
				@endif

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="width: 60px">No</th>
						<th>NIP</th>
						<th>Nama Pegawai</th>
						<th>Golongan</th>
						<th>Status</th>
						<th>Foto</th>
						@if(Auth::user()->group==1)
							<th style="width: 20%">#aksi</th>
						@endif
					</tr>
					@foreach($pegawai as $v)
					<tr>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}">{{ ($pegawai ->currentpage()-1) * $pegawai ->perpage() + $loop->index + 1 }}</td>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}">{{ $v->nip }}</td>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}">{{ $v->nama_pegawai }}</td>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}">{{ $v->golongan }}</td>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}">
							@if ($status_kehadiran[$loop->index]=='H')
								<span class="label label-success">Hadir</span>
							@elseif  ($status_kehadiran[$loop->index]=='S')
								<span class="label label-warning">Sakit</span>
							@elseif  ($status_kehadiran[$loop->index]=='I')
								<span class="label label-info">Izin</span>
							@elseif  ($status_kehadiran[$loop->index]=='A')
								<span class="label label-danger">Tanpa Keterangan</span>
							@else
								<span class="label label-primary">Belum Absen</span>
							@endif
						</td>
						
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}"><center>
						@if($v->foto_formal)
									<img src="{{ asset('upload/foto_formal_pegawai/'.$v->foto_formal) }}" class="img-circle" alt="User Image"  width="150px" height="150px">
								@else
									<img src="{{ asset('upload/user/15.jpg') }}" class="img-circle" alt="User Image" width="150px" height="150px">
								@endif
						</td>
						@if(Auth::user()->group==1)
						<td>
							<div class="btn-group" style="display: block;padding-bottom:7px">
								<button type="button" class="btn btn-xs btn-primary btn-block dropdown-toggle" data-toggle="dropdown">Riwayat 1</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('riwayat_jabatan/'.$v->id) }}">Jabatan</a></li>
									<li><a href="{{ url('riwayat_angka_kredit/'.$v->id) }}">Angka Kredit</a></li>
									<li><a href="{{ url('riwayat_kepangkatan/'.$v->id) }}">Pangkat</a></li>
									<li><a href="{{ url('riwayat_lhkpn/'.$v->id) }}">LHKPN</a></li>
									<li><a href="{{ url('riwayat_kompetensi/'.$v->id) }}">Kompetensi</a></li>
								</ul>
							</div><br>
							<div class="btn-group" style="display: block;padding-bottom:7px">
								<button type="button" class="btn btn-xs btn-primary btn-block dropdown-toggle" data-toggle="dropdown">Riwayat 2</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('riwayat_pendidikan/'.$v->id) }}">Pendidikan</a></li>
									<li><a href="{{ url('riwayat_seminar/'.$v->id) }}">Seminar</a></li>
									<li><a href="{{ url('riwayat_diklat/'.$v->id) }}">Diklat/Sertifikasi</a></li>
									<li><a href="{{ url('riwayat_tugas/'.$v->id) }}">Tugas/Izin Belajar</a></li>
									<li><a href="{{ url('riwayat_karya_ilmiah/'.$v->id) }}">Karya Ilmiah</a></li>
								</ul>
							</div><br>
							<div class="btn-group" style="display: block;padding-bottom:7px">
								<button type="button" class="btn btn-xs btn-primary btn-block dropdown-toggle" data-toggle="dropdown">Riwayat 3</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('riwayat_penghargaan/'.$v->id) }}">Penghargaan</a></li>
									<li><a href="{{ url('riwayat_cuti/'.$v->id) }}">Cuti</a></li>
									<li><a href="{{ url('riwayat_hukuman/'.$v->id) }}">Hukuman Disiplin</a></li>
									<li><a href="{{ url('riwayat_kursus/'.$v->id) }}">Kursus</a></li>
									<li><a href="{{ url('riwayat_gaji/'.$v->id) }}">Gaji</a></li>
									<li><a href="{{ url('riwayat_kgb/'.$v->id) }}">Kenaikan Gaji Berkala</a></li>
									<li><a href="{{ url('riwayat_tugas_luar_negeri/'.$v->id) }}">Riwayat Tugas Luar Negeri</a></li>
								</ul>
							</div><br>
							<div class="btn-group" style="display: block;padding-bottom:7px">
								<button type="button" class="btn btn-xs btn-primary btn-block dropdown-toggle" data-toggle="dropdown">Riwayat 4</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('riwayat_pajak/'.$v->id) }}">Laporan Pajak</a></li>
								</ul>
							</div><br>
							<div class="btn-group" style="display: block;padding-bottom:7px">
								<button type="button" class="btn btn-xs btn-primary btn-block dropdown-toggle" data-toggle="dropdown">Riwayat Keluarga</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('riwayat_orang_tua/'.$v->id) }}">Orang Tua</a></li>
									<li><a href="{{ url('riwayat_pasangan/'.$v->id) }}">Pasangan</a></li>
									<li><a href="{{ url('riwayat_anak/'.$v->id) }}">Anak</a></li>
								</ul>
							</div><br>
							<a href="{{ url('/pegawai/download_cv/'.$v->id ) }}" class="btn btn-xs btn-success btn-block">Download CV</a>
							<a href="{{ url('/pegawai/edit/'.$v->id ) }}" class="btn btn-xs btn-warning btn-block">Edit</a>
							<div class="btn-group" style="display: block;padding-top:5px">
								<button type="button" class="btn btn-xs btn-danger btn-block dropdown-toggle" data-toggle="dropdown">Hapus</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('pegawai/pensiun/'.$v->id) }}" onclick="return confirm('Anda Yakin ?');">Pensiun</a></li>
									<li><a href="{{ url('pegawai/meninggal/'.$v->id) }}" onclick="return confirm('Anda Yakin ?');">Meninggal</a></li>
									<li><a href="{{ url('pegawai/pindah_tugas/'.$v->id) }}" onclick="return confirm('Anda Yakin ?');">Pindah Tugas (Luar)</a></li>
								</ul>
							</div><br>
						</td>
						@endif
					</tr>

					<!-- Modal Update-->
					<div class="modal modal-default fade" id="modalDetail{{$v->id}}">
						<div class="modal-dialog" role="document">
							<div class="modal-content" style="border-radius: 20px;">
								<div class="modal-body" style="border-radius: 20px;">
								<center>
									@if($v->foto_formal)
										<img src="{{ asset('upload/foto_formal_pegawai/'.$v->foto_formal) }}" class="img-circle" alt="User Image"  width="150px" height="150px">
									@else
										<img src="{{ asset('upload/user/15.jpg') }}" class="img-circle" alt="User Image" width="150px" height="150px">
									@endif
									<br><br>
									<p style="font-size:20px">{{ $v->nama_pegawai }}</p>
									<p style="font-size:16px">{{ $v->nip }}</p>
								</center><br>
								<div class="row">
									<div class="col-md-3"><b>Tempat Lahir</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->tempat_lahir }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Tanggal Lahir</b></div>
									<div class="col-md-4 ml-auto">: {{ date('d-m-Y', strtotime($v->tanggal_lahir)) }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Jenis kelamin</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->jenis_kelamin }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Alamat</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->alamat }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Agama</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->agama }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Gol. Darah</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->gol_darah }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Email</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->email }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Jabatan</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->jabatan->nama_jabatan }}</div>
								</div><br>
								<div class="row">
									<div class="col-md-6">
										@if($v->ktp)
											<img src="{{ asset('upload/ktp/'.$v->ktp) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
									<div class="col-md-6">
										@if($v->bpjs)
											<img src="{{ asset('upload/bpjs/'.$v->bpjs) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-6">
										@if($v->npwp)
											<img src="{{ asset('upload/npwp/'.$v->npwp) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
									<div class="col-md-6">
										@if($v->karpeg)
											<img src="{{ asset('upload/karpeg/'.$v->karpeg) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-6">
										@if($v->karsu)
											<img src="{{ asset('upload/karsu/'.$v->karsu) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>

					@endforeach
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			<div class="float-right">{{ $pegawai->appends(Request::only('search'))->links() }}</div>
		</div>
	</div>
	</section>
</div>
@endsection