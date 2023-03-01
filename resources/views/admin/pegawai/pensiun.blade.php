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
						<th style="text-align:center">Tanggal Lahir</th>
						<th style="text-align:center">Tanggal Pensiun</th>
						<th style="text-align:center">Usia Saat Ini</th>
					</tr>
					@if(Auth::user()->group==1)
						@foreach($pegawai as $v)
							<tr>
								<td style="text-align:center">{{ $v->nip }}</td>
								<td style="text-align:center">{{ $v->nama_pegawai }}</td>
								<td style="text-align:center">{{ date('d-m-Y', strtotime($v->tanggal_lahir)) }}</td>
								<td style="text-align:center"><span class="label label-success">
								@php
								$dt = new DateTime($v->pensiun);

								$day = $dt->format('j');
								$dt->modify('first day of +1 month');
								$dt->modify('+' . (min($day, $dt->format('t')) - 1) . ' days');
								
								echo "01".$dt->format('-m-Y'), PHP_EOL;
								@endphp</td>
								<td style="text-align:center;font-weight:bold">{{ $v->umur }} Tahun</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td style="text-align:center">{{ $pegawai[0]->nip }}</td>
							<td style="text-align:center">{{ $pegawai[0]->nama_pegawai }}</td>
							<td style="text-align:center">{{ date('d-m-Y', strtotime($pensiun[0]->tanggal_lahir)) }}</td>
							<td style="text-align:center"><span class="label label-success">
							@php
							$dt = new DateTime($pensiun[0]->pensiun);

							$day = $dt->format('j');
							$dt->modify('first day of +1 month');
							$dt->modify('+' . (min($day, $dt->format('t')) - 1) . ' days');
							
							echo "01".$dt->format('-m-Y'), PHP_EOL;
							@endphp</td>
							<td style="text-align:center;font-weight:bold">{{ $pensiun[0]->umur }} Tahun</td>
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