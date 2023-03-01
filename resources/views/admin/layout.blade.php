<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>SIMPEG INDAG</title>
        
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('/upload/logo/logo.png') }}" rel="icon">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/bootstrap/dist/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/font-awesome/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/Ionicons/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/bootstrap-daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-plugin/iCheck/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-plugin/timepicker/bootstrap-timepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/fullcalendar/dist/fullcalendar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/fullcalendar/dist/fullcalendar.print.css') }}" media="print">
        
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-dist/css/AdminLTE.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-dist/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link href="https://fonts.googleapis.com/css?family=Anton|Permanent+Marker|Quicksand" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet"> 
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

        <style type="text/css">
            .fontQuicksand{
                font-family: 'Quicksand', sans-serif;
            }

            .fontPoppins{
                font-family: 'Poppins', sans-serif;
            }

            .preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background-color: #fff;
            }

            .preloader .loading {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%,-50%);
                font: 14px arial;
            }

            .dropzone {
                border: 2px dashed #0087F7;
            }
        </style>
        
        
        <script>
			
			function formatRupiah(objek, separator) {
                  a = objek.value;
                  b = a.replace(/[^\d]/g,"");
                  c = "";
                  panjang = b.length;
                  j = 0;
                  for (i = panjang; i > 0; i--) {
                    j = j + 1;
                    if (((j % 3) == 1) && (j != 1)) {
                      c = b.substr(i-1,1) + separator + c;
                    } else {
                      c = b.substr(i-1,1) + c;
                    }
                  }
                  objek.value = c;
            }
                
        </script>

    </head>

    <body class="default sidebar-mini skin-red fontPoppins">
        <div class="preloader">
			<div class="loading text-center">
				<img src="{{ asset('/assets/core-images/load.gif') }}" width="50">
                <br>
				<p><b class="fontPoppins">Harap Tunggu</b></p>
			</div>
		</div>
        <div class="wrapper">
            <header class="main-header">
                <a href="" class="logo">
                    <span class="logo-mini"><b>SIM</b></span>
                    <span class="logo-lg"><b>SIDAK</b></span>
                </a>
                
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle fa fa-bars" data-toggle="push-menu" role="button" style=" float: left;background-color: transparent;background-image: none;padding: 15px 15px;">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if(Auth::user()->foto)
                                    <img src="{{ asset('upload/foto/'.Auth::user()->foto) }}" class="user-image" alt="User Image">   
                                @else
                                    <img src="{{ asset('assets/profile-1-20210205190338.png') }}" class="user-image" alt="User Image">   
                                @endif                             
						  <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                    @if(Auth::user()->foto)
                                        <img src="{{ asset('upload/foto/'.Auth::user()->foto) }}" class="img-circle" alt="User Image">    
                                    @else
                                        <img src="{{ asset('assets/profile-1-20210205190338.png') }}" class="img-circle" alt="User Image">   
                                    @endif                                          
								<p>
                                    {{ Auth::user()->name }}                                            
								    <small>Member since<br> {{ Auth::user()->created_at }} </small>
                                        </p>
                                    </li>
                                    
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{{ url('/user/edit_profil/'.Auth::user()->id) }}" class="btn btn-default btn-flat">Profil</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-google btn-flat">Sign out</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
											@csrf
									</form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            @if(Auth::user()->foto)
                                <img src="{{ asset('upload/foto/'.Auth::user()->foto) }}" class="img-circle" alt="User Image">    
                            @else
                                <img src="{{ asset('assets/profile-1-20210205190338.png') }}" class="img-circle" alt="User Image">   
                            @endif                          
					</div>
                        <div class="pull-left info">
                            <p>{{ Auth::user()->name }}  </p>                            
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">MAIN NAVIGATION</li>

                        @if(Auth::user()->group==1)
                            <li class="{{ (request()->is('dashboard*')) ? 'active' : '' }}"><a href="{{ url('dashboard')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                            <li class="treeview  {{ (request()->is('rekapitulasi_jumlah_pegawai*','rekapitulasi_jumlah_pegawai_bidang*','rekapitulasi_esselon*','rekapitulasi_gender_bidang*','rekapitulasi_golongan*',
                            'rekapitulasi_pendidikan*','rekapitulasi_asn_aktif*','rekapitulasi_asn_non_aktif*','rekapitulasi_cuti*','rekapitulasi_pensiunan*','rekapitulasi_pensiunan*')) ? 'active' : '' }}">
                                <a href="#"> <i class="fa fa-database"></i> <span>Rekapitulasi</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="{{ (request()->is('rekapitulasi_jumlah_pegawai')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_jumlah_pegawai')}}"><i class="fa fa-circle-notch"></i> Jumlah Pegawai</a></li>
                                    <li class="{{ (request()->is('rekapitulasi_jumlah_pegawai_bidang*')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_jumlah_pegawai_bidang')}}"><i class="fa fa-circle-notch"></i> Jumlah Pegawai Bidang</a></li>
                                    <li class="{{ (request()->is('rekapitulasi_esselon*')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_esselon')}}"><i class="fa fa-circle-notch"></i> Esselon</a></li>
                                    <li class="{{ (request()->is('rekapitulasi_gender_bidang*')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_gender_bidang')}}"><i class="fa fa-circle-notch"></i> Gender Per Bidang</a></li>
                                    <li class="{{ (request()->is('rekapitulasi_golongan*')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_golongan')}}"><i class="fa fa-circle-notch"></i> Pangkat/Golongan</a></li>
                                    <li class="{{ (request()->is('rekapitulasi_asn_aktif*')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_asn_aktif')}}"><i class="fa fa-circle-notch"></i> ASN Aktif</a></li>
                                    <li class="{{ (request()->is('rekapitulasi_asn_non_aktif*')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_asn_non_aktif')}}"><i class="fa fa-circle-notch"></i> ASN Tidak Aktif</a></li>
                                    <li class="{{ (request()->is('rekapitulasi_cuti*')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_cuti')}}"><i class="fa fa-circle-notch"></i> Cuti</a></li>
                                    <li class="{{ (request()->is('rekapitulasi_pensiunan*')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_pensiunan')}}"><i class="fa fa-circle-notch"></i> Pensiunan</a></li>
                                    <li class="{{ (request()->is('rekapitulasi_pendidikan*')) ? 'active' : '' }}"><a href="{{ url('rekapitulasi_pendidikan')}}"><i class="fa fa-circle-notch"></i> Pendidikan</a></li>
                                </ul>
                            </li>  
                            <li class="{{ (request()->is('pegawai*')) ? 'active' : '' }}"><a href="{{ url('pegawai')}}"><i class="fa fa-circle-notch"></i> <span>Tayangan Data</span></a></li>
                            <li class="{{ (request()->is('informasi_kantor*')) ? 'active' : '' }}"><a href="{{ url('informasi_kantor')}}"><i class="fa fa-circle-notch"></i> <span>Informasi Kantor</span></a></li>
                            <li class="{{ (request()->is('agenda*')) ? 'active' : '' }}"><a href="{{ url('agenda')}}"><i class="fa fa-circle-notch"></i> <span>Agenda Kerja</span></a></li>
                            <li class="treeview {{ (request()->is('notulen*','arsip*','pengumuman_diklat*','peraturan_kepegawaian*','pengumuman_ujian_dinas*','pengumuman_ujian_pangkat*','pengumuman_diklat_pim*','honorer*','pengusulan_penghargaan*','pengusulan_hukuman*')) ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fa fa-share"></i> <span>Informasi</span>
                                    <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="treeview {{ (request()->is('pengumuman_diklat*','peraturan_kepegawaian*','pengumuman_ujian_dinas*','pengumuman_ujian_pangkat*','pengumuman_diklat_pim*')) ? 'active' : '' }}">
                                        <a href="#"><i class="fa fa-circle-notch"></i> Pengumuman
                                            <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li class="{{ (request()->is('pengumuman_diklat*')) ? 'active' : '' }}"><a href="{{ url('pengumuman_diklat')}}"><i class="fa fa-circle-notch"></i> Diklat Teknis</a></li>
                                            <li class="{{ (request()->is('peraturan_kepegawaian*')) ? 'active' : '' }}"><a href="{{ url('peraturan_kepegawaian')}}"><i class="fa fa-circle-notch"></i> Peraturan<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Kepegawaian</a></li>
                                            <li class="{{ (request()->is('pengumuman_ujian_dinas*')) ? 'active' : '' }}"><a href="{{ url('pengumuman_ujian_dinas')}}"><i class="fa fa-circle-notch"></i> Ujian Dinas</a></li>
                                            <li class="{{ (request()->is('pengumuman_ujian_pangkat*')) ? 'active' : '' }}"><a href="{{ url('pengumuman_ujian_pangkat')}}"><i class="fa fa-circle-notch"></i> Ujian Kenaikan Pangkat<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / Penyesuaian Ijazah</a></li>
                                            <li class="{{ (request()->is('pengumuman_diklat_pim*')) ? 'active' : '' }}"><a href="{{ url('pengumuman_diklat_pim')}}"><i class="fa fa-circle-notch"></i> Diklat PIM IV, III, II</a></li>
                                            <li class="{{ (request()->is('pegawai/kgb*')) ? 'active' : '' }}"><a href="{{ url('pegawai/kgb')}}"><i class="fa fa-circle-notch"></i> Kenaikan Gaji Berkala</a></li>
                                            <li class="{{ (request()->is('pegawai/pensiun*')) ? 'active' : '' }}"><a href="{{ url('pegawai/pensiun')}}"><i class="fa fa-circle-notch"></i> Pensiun</a></li>
                                        </ul>
                                    </li>
                                    <li class="{{ (request()->is('honorer*')) ? 'active' : '' }}"><a href="{{ url('honorer') }}"><i class="fa fa-circle-notch"></i> Pegawai Honorer</a></li>
                                    <li class="{{ (request()->is('notulen*')) ? 'active' : '' }}"><a href="{{ url('notulen') }}"><i class="fa fa-circle-notch"></i> Notulensi Rapat</a></li>
                                    <li class="treeview {{ (request()->is('arsip_surat_masuk*','arsip_surat_keluar*')) ? 'active' : '' }}">
                                        <a href="#"><i class="fa fa-circle-notch"></i> Arsip
                                            <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li class="{{ (request()->is('arsip_surat_masuk*')) ? 'active' : '' }}"><a href="{{ url('arsip_surat_masuk') }}"><i class="fa fa-circle-notch"></i> Surat Masuk</a></li>
                                            <li class="{{ (request()->is('arsip_surat_keluar*')) ? 'active' : '' }}"><a href="{{ url('arsip_surat_keluar') }}"><i class="fa fa-circle-notch"></i> Surat Keluar</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#"><i class="fa fa-circle-notch"></i> Tutorial Aplikasi</a></li>
                                    <li class="treeview {{ (request()->is('pengusulan_penghargaan*','pengusulan_hukuman*')) ? 'active' : '' }}">
                                    <a href="#"><i class="fa fa-circle-notch"></i> Pengusulan lainnya
                                        <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="{{ (request()->is('pengusulan_penghargaan*')) ? 'active' : '' }}"><a href="{{ url('pengusulan_penghargaan')}}"><i class="fa fa-circle-notch"></i> Penghargaan</a></li>
                                        <li class="{{ (request()->is('pengusulan_hukuman*')) ? 'active' : '' }}"><a href="{{ url('pengusulan_hukuman')}}"><i class="fa fa-circle-notch"></i> Penjatuhan Hukuman<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Disiplin</a></li>
                                    </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ (request()->is('absen*')) ? 'active' : '' }}""><a href="{{ url('absen')}}"><i class="fa fa-circle-notch"></i> <span>Absensi</span></a></li>
                            
                            <li class="header">CORE BASE</li>
                            <li class="{{ (request()->is('user*')) ? 'active' : '' }}""><a href="{{ url('user')}}"><i class="fa fa-user"></i> <span>User</span></a></li>
                            
                        @elseif(Auth::user()->group==3)
                            
                            <li class="{{ (request()->is('dashboard*')) ? 'active' : '' }}"><a href="{{ url('dashboard')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                            <li class="treeview  {{ (request()->is('pegawai/naik_pangkat*','pegawai/pensiun*','pegawai/kgb*','pengumuman_diklat*','pengumuman_diklat_pim*')) ? 'active' : '' }}">
                                <a href="#"> <i class="fa fa-database"></i> <span>Info Pegawai</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="{{ (request()->is('pegawai/naik_pangkat')) ? 'active' : '' }}"><a href="{{ url('pegawai/naik_pangkat')}}"><i class="fa fa-circle-notch"></i> Naik Pangkat</a></li>
                                    <li class="{{ (request()->is('pegawai/pensiun')) ? 'active' : '' }}"><a href="{{ url('pegawai/pensiun')}}"><i class="fa fa-circle-notch"></i> Pensiun</a></li>
                                    <li class="{{ (request()->is('pegawai/kgb')) ? 'active' : '' }}"><a href="{{ url('pegawai/kgb')}}"><i class="fa fa-circle-notch"></i> Kenaikan Gaji Berkala</a></li>
                                    <li class="{{ (request()->is('pengumuman_diklat*')) ? 'active' : '' }}"><a href="{{ url('pengumuman_diklat')}}"><i class="fa fa-circle-notch"></i> Diklat Teknis</a></li>
                                    <li class="{{ (request()->is('pengumuman_diklat_pim*')) ? 'active' : '' }}"><a href="{{ url('pengumuman_diklat_pim')}}"><i class="fa fa-circle-notch"></i> Diklat PIM IV, III, II</a></li>
                                </ul>
                            </li>
                            <li class="{{ (request()->is('pegawai*')) ? 'active' : '' }}""><a href="{{ url('pegawai')}}"><i class="fa fa-circle-notch"></i> <span>Data Pribadi</span></a></li>
                            <li class="{{ (request()->is('informasi_kantor*')) ? 'active' : '' }}""><a href="{{ url('informasi_kantor')}}"><i class="fa fa-circle-notch"></i> <span>Informasi Kantor</span></a></li>
                            <li class="{{ (request()->is('agenda*')) ? 'active' : '' }}""><a href="{{ url('agenda')}}"><i class="fa fa-circle-notch"></i> <span>Agenda Kerja</span></a></li>
                            <li class="treeview {{ (request()->is('notulen*','arsip*','peraturan_kepegawaian*','pengumuman_ujian_dinas*','pengumuman_ujian_pangkat*','honorer*','pengusulan_penghargaan*','pengusulan_hukuman*')) ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fa fa-share"></i> <span>Informasi</span>
                                    <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="treeview {{ (request()->is('peraturan_kepegawaian*','pengumuman_ujian_dinas*','pengumuman_ujian_pangkat*')) ? 'active' : '' }}">
                                        <a href="#"><i class="fa fa-circle-notch"></i> Pengumuman
                                            <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li class="{{ (request()->is('peraturan_kepegawaian*')) ? 'active' : '' }}"><a href="{{ url('peraturan_kepegawaian')}}"><i class="fa fa-circle-notch"></i> Peraturan<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Kepegawaian</a></li>
                                            <li class="{{ (request()->is('pengumuman_ujian_dinas*')) ? 'active' : '' }}"><a href="{{ url('pengumuman_ujian_dinas')}}"><i class="fa fa-circle-notch"></i> Ujian Dinas</a></li>
                                            <li class="{{ (request()->is('pengumuman_ujian_pangkat*')) ? 'active' : '' }}"><a href="{{ url('pengumuman_ujian_pangkat')}}"><i class="fa fa-circle-notch"></i> Ujian Kenaikan Pangkat<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / Penyesuaian Ijazah</a></li>
                                        </ul>
                                    </li>
                                    <li class="{{ (request()->is('notulen*')) ? 'active' : '' }}"><a href="{{ url('notulen') }}"><i class="fa fa-circle-notch"></i> Notulensi Rapat</a></li>
                                    <li class="treeview {{ (request()->is('arsip_surat_masuk*','arsip_surat_keluar*')) ? 'active' : '' }}">
                                        <a href="#"><i class="fa fa-circle-notch"></i> Arsip
                                            <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li class="{{ (request()->is('arsip_surat_masuk*')) ? 'active' : '' }}"><a href="{{ url('arsip_surat_masuk') }}"><i class="fa fa-circle-notch"></i> Surat Masuk</a></li>
                                            <li class="{{ (request()->is('arsip_surat_keluar*')) ? 'active' : '' }}"><a href="{{ url('arsip_surat_keluar') }}"><i class="fa fa-circle-notch"></i> Surat Keluar</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#"><i class="fa fa-circle-notch"></i> Tutorial Aplikasi</a></li>
                                    <li class="treeview {{ (request()->is('pengusulan_penghargaan*','pengusulan_hukuman*')) ? 'active' : '' }}">
                                    <a href="#"><i class="fa fa-circle-notch"></i> Pengusulan lainnya
                                        <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="{{ (request()->is('pengusulan_penghargaan*')) ? 'active' : '' }}"><a href="{{ url('pengusulan_penghargaan')}}"><i class="fa fa-circle-notch"></i> Penghargaan</a></li>
                                        <li class="{{ (request()->is('pengusulan_hukuman*')) ? 'active' : '' }}"><a href="{{ url('pengusulan_hukuman')}}"><i class="fa fa-circle-notch"></i> Penjatuhan Hukuman<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Disiplin</a></li>
                                    </ul>
                                    </li>
                                </ul>
                            </li>
                            
                        @endif

                        
                    </ul>
                </section>
            </aside><!-- Styles -->

		  @yield('konten')

		             
		  <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 0.0.1
                </div>
               
            </footer>
            
        </div>
       
        <!-- <script src="{{ asset('/assets/core-admin/core-component/jquery/dist/jquery.min.js') }}"></script> -->
        <script src="{{ asset('/assets/core-admin/core-component/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-component/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-component/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-component/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-component/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-plugin/timepicker/bootstrap-timepicker.min.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-component/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-plugin/iCheck/icheck.min.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-component/fastclick/lib/fastclick.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-dist/js/demo.js') }}"></script>
        <!-- fullCalendar -->
        <!-- jQuery UI 1.11.4 -->
        <!-- <script src="{{ asset('assets/core-admin/core-component/jquery-ui/jquery-ui.min.js') }}"></script> -->
         <script src="{{ asset('assets/core-admin/core-component/moment/moment.js') }}"></script>
        <script src="{{ asset('assets/core-admin/core-component/fullcalendar/dist/fullcalendar.js') }}"></script>
        
        <script>
            $(document).ready(function () {
              $('.sidebar-menu').tree();
              $('.preloader').fadeOut();

              $("#rowpage").change(function(){
					var row = $("#rowpage").val();
					$.ajax({
						type      : "POST",
						url       : "{{ asset('/admin/setting/setRows",
						data      : {row: row},
						success   : function(msg){
							location.reload();
						}
					});
				});


                //Select2
                $('.select2').select2();

                //Date picker
                $('.datepicker').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                })

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass   : 'iradio_minimal-blue'
                });

                //Colorpicker
                $('.colorpicker').colorpicker();

                //Timepicker
                $('.timepicker').timepicker({
                    showInputs: true
                });

                //Date range picker
                $('.reservation').daterangepicker();

            })
        </script>

    </body>
</html>