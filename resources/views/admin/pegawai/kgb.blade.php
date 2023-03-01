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
			
			<div class="table-responsive box-body">

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="text-align:center">NIP</th>
						<th style="text-align:center">Nama Pegawai</th>
						<th style="text-align:center">KGB Terakhir</th>
						<th style="text-align:center">KGB Saat Ini</th>
						<th style="text-align:center">KGB Selanjutnya</th>
					</tr>
					@if(Auth::user()->group==1)
						@foreach($pegawai as $v)
						<tr>
							<td style="text-align:center">{{ $v->nip }}</td>
							<td style="text-align:center">{{ $v->nama_pegawai }}</td>

							@if($v->kgb_saat_ini)
								<td style="text-align:center;font-weight:bold">{{ date('d-m-Y', strtotime($kgb_terakhir[$loop->index])) }}</td>
								<td style="text-align:center;font-weight:bold">{{ date('d-m-Y', strtotime($kgb_saat_ini[$loop->index])) }}</td>
								<td style="text-align:center;font-weight:bold"><span class="label label-success">{{ date('d-m-Y', strtotime($kgb_berikutnya[$loop->index])) }}</span></td>
							@else
								<td style="text-align:center;font-weight:bold"><span class="label label-danger">Belum Mengisi Riwayat Gaji</span></td>
								<td style="text-align:center;font-weight:bold"><span class="label label-danger">Belum Mengisi Riwayat Gaji</span></td>
								<td style="text-align:center;font-weight:bold"><span class="label label-danger">Belum Mengisi Riwayat Gaji</span></td>
							@endif

						</tr>
						@endforeach
					@else
						<tr>
							<td style="text-align:center">{{ $pegawai[0]->nip }}</td>
							<td style="text-align:center">{{ $pegawai[0]->nama_pegawai }}</td>

							@if($pegawai[0]->kgb_saat_ini)
								<td style="text-align:center;font-weight:bold">{{ date('d-m-Y', strtotime($kgb_terakhir[0])) }}</td>
								<td style="text-align:center;font-weight:bold">{{ date('d-m-Y', strtotime($kgb_saat_ini[0])) }}</td>
								<td style="text-align:center;font-weight:bold"><span class="label label-success">{{ date('d-m-Y', strtotime($kgb_berikutnya[0])) }}</span></td>
							@else
								<td style="text-align:center;font-weight:bold"><span class="label label-danger">Belum Mengisi Riwayat Gaji</span></td>
								<td style="text-align:center;font-weight:bold"><span class="label label-danger">Belum Mengisi Riwayat Gaji</span></td>
								<td style="text-align:center;font-weight:bold"><span class="label label-danger">Belum Mengisi Riwayat Gaji</span></td>
							@endif
						</tr>
					@endif
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			@if(Auth::user()->group==1)
				<div class="float-right">{{ $pegawai->appends(Request::only('search'))->links() }}</div>
			@endif
		</div>
	</div>
	</section>
</div>
@endsection