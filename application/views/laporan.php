<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Admina | Laporan
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="<?php echo base_url('assets/css/gf.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/fa/css/all.min.css'); ?>" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/css/now-ui-dashboard.css?v=1.3.0'); ?>" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url('assets/demo/demo.css'); ?>" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/DataTables/datatables.min.css'); ?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css'); ?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2-bootstrap4.css'); ?>"/>
  <script type="text/javascript">
    var baseurl = "<?php echo base_url(); ?>";
  </script>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="blue">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    	-->
      <div class="logo">
        <a href="<?php echo base_url(); ?>" class="simple-text logo-mini">
          <i class="now-ui-icons media-2_sound-wave"></i>
        </a>
        <a href="<?php echo base_url(); ?>" class="simple-text logo-normal">
          Admina
        </a>
      </div>
      <?php $this->load->view('sidebar'); ?>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="">Laporan</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="menuProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menuProfile">
                  <a class="dropdown-item" href="#">
										<i class="now-ui-icons users_single-02"></i>
										<p>Profile</p>
									</a>
									<a class="dropdown-item" href="<?php echo base_url('dashboard/logout/'); ?>">
										<i class="now-ui-icons media-1_button-power"></i>
										<p>Logout</p>
									</a>
                </div>
							</li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div id="table" class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                	<div class="col-6">
                		<h4 class="card-title"> Tabel Laporan</h4>
                	</div>
                	<div class="col-6">
                		<div class="pull-right">
                			<button name="btn_add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data</button>
                		</div>
                	</div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tableLaporan" class="table table-striped table-hover">
                    <thead class="text-primary">
                      <th>No.</th>
                      <th>Nama Laporan</th>
                      <th>Tahun</th>
                      <th>Bulan</th>
                      <th>Catatan</th>
                      <th style="min-width: 100px;">Aksi</th>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div id="form" class="col-md-12" style="display: none;">
            <div class="card">
              <div class="card-header">
                <h4 id="formTitle" class="card-title"> Tambah Data</h4>
              </div>
              <div class="card-body">
                <form id="formData">
                	<div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Jenis Laporan</label>
                        <select name="id_jenis_laporan" class="form-control"></select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tahun</label>
                        <select name="tahun_laporan" class="form-control"></select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Bulan</label>
                        <select name="bulan_laporan" class="form-control">
                          <option value="01" selected>Januari</option>
                          <option value="02" selected>Februari</option>
                          <option value="03" selected>Maret</option>
                          <option value="04" selected>April</option>
                          <option value="05" selected>Mei</option>
                          <option value="06" selected>Juni</option>
                          <option value="07" selected>Juli</option>
                          <option value="08" selected>Agustus</option>
                          <option value="09" selected>Septermber</option>
                          <option value="10" selected>Oktober</option>
                          <option value="11" selected>November</option>
                          <option value="12" selected>Desember</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" placeholder="Catatan"></textarea>
                      </div>
                    </div>
                	</div>
                  <!-- <div class="row laporan-bulanan mt-5" style="display: none;">
                    <div class="col-md-12">
                      <h3><strong>LAPORAN BULANAN</strong></h3>
                      <div class="table-responsive">
                        <table id="tableLaporanBulanan" align="center" width="100%" border="1">
                          <thead align="center">
                            <tr>
                              <th rowspan="3">DESA</th>
                              <th colspan="2">KIA</th>
                              <th colspan="6">KB</th>
                              <th colspan="17">IMUNISASI</th>
                              <th rowspan="3">PARTUS</th>
                              <th rowspan="3">JUMLAH</th>
                            </tr>
                            <tr>
                              <td colspan="2">HAMIL</td>
                              <td colspan="3">BARU</td>
                              <td colspan="3">LAMA</td>
                              <td rowspan="2">BCG</td>
                              <td colspan="3">DPT</td>
                              <td colspan="4">POLIO</td>
                              <td colspan="4">HB</td>
                              <td rowspan="2">CAMPAK</td>
                              <td colspan="2">TT</td>
                              <td colspan="2">TT WUS</td>
                            </tr>
                            <tr>
                              <td>B</td>
                              <td>L</td>
                              <td>IUD</td>
                              <td>PIL</td>
                              <td>SUN</td>
                              <td>IUD</td>
                              <td>PIL</td>
                              <td>SUN</td>
                              <td>1</td>
                              <td>2</td>
                              <td>3</td>
                              <td>1</td>
                              <td>2</td>
                              <td>3</td>
                              <td>4</td>
                              <td>0</td>
                              <td>1</td>
                              <td>2</td>
                              <td>3</td>
                              <td>1</td>
                              <td>2</td>
                              <td>1</td>
                              <td>2</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>CIHANJUANG RAHAYU</td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_hamil_b" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_hamil_l" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_kb_baru_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_kb_baru_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_kb_baru_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_kb_lama_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_kb_lama_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_kb_lama_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_bcg" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_dpt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_dpt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_dpt_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_polio_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_polio_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_polio_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_polio_4" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_hb_0" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_hb_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_hb_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_hb_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_campak" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_tt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_tt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_tt_wus_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_imunisasi_tt_wus_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_rahayu_partus" style="max-width: 50px;"></td>
                              <td align="center"><div id="cihanjuang_rahayu_jml"></div></td>
                            </tr>
                            <tr>
                              <td>CIHANJUANG</td>
                              <td align="center"><input type="number" name="cihanjuang_hamil_b" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_hamil_l" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_kb_baru_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_kb_baru_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_kb_baru_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_kb_lama_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_kb_lama_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_kb_lama_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_bcg" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_dpt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_dpt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_dpt_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_polio_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_polio_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_polio_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_polio_4" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_hb_0" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_hb_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_hb_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_hb_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_campak" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_tt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_tt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_tt_wus_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_imunisasi_tt_wus_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihanjuang_partus" style="max-width: 50px;"></td>
                              <td align="center"><div id="cihanjuang_jml"></div></td>
                            </tr>
                            <tr>
                              <td>SARIWANGI</td>
                              <td align="center"><input type="number" name="sariwangi_hamil_b" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_hamil_l" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_kb_baru_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_kb_baru_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_kb_baru_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_kb_lama_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_kb_lama_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_kb_lama_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_bcg" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_dpt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_dpt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_dpt_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_polio_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_polio_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_polio_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_polio_4" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_hb_0" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_hb_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_hb_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_hb_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_campak" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_tt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_tt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_tt_wus_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_imunisasi_tt_wus_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="sariwangi_partus" style="max-width: 50px;"></td>
                              <td align="center"><div id="sariwangi_jml"></div></td>
                            </tr>
                            <tr>
                              <td>KARYAWANGI</td>
                              <td align="center"><input type="number" name="karyawangi_hamil_b" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_hamil_l" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_kb_baru_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_kb_baru_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_kb_baru_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_kb_lama_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_kb_lama_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_kb_lama_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_bcg" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_dpt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_dpt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_dpt_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_polio_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_polio_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_polio_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_polio_4" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_hb_0" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_hb_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_hb_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_hb_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_campak" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_tt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_tt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_tt_wus_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_imunisasi_tt_wus_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="karyawangi_partus" style="max-width: 50px;"></td>
                              <td align="center"><div id="karyawangi_jml"></div></td>
                            </tr>
                            <tr>
                              <td>CIHIDEUNG</td>
                              <td align="center"><input type="number" name="cihideung_hamil_b" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_hamil_l" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_kb_baru_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_kb_baru_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_kb_baru_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_kb_lama_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_kb_lama_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_kb_lama_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_bcg" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_dpt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_dpt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_dpt_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_polio_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_polio_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_polio_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_polio_4" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_hb_0" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_hb_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_hb_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_hb_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_campak" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_tt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_tt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_tt_wus_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_imunisasi_tt_wus_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cihideung_partus" style="max-width: 50px;"></td>
                              <td align="center"><div id="cihideung_jml"></div></td>
                            </tr>
                            <tr>
                              <td>CIGUGUR</td>
                              <td align="center"><input type="number" name="cigugur_hamil_b" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_hamil_l" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_kb_baru_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_kb_baru_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_kb_baru_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_kb_lama_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_kb_lama_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_kb_lama_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_bcg" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_dpt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_dpt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_dpt_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_polio_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_polio_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_polio_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_polio_4" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_hb_0" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_hb_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_hb_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_hb_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_campak" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_tt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_tt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_tt_wus_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_imunisasi_tt_wus_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cigugur_partus" style="max-width: 50px;"></td>
                              <td align="center"><div id="cigugur_jml"></div></td>
                            </tr>
                            <tr>
                              <td>CIPANAS</td>
                              <td align="center"><input type="number" name="cipanas_hamil_b" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_hamil_l" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_kb_baru_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_kb_baru_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_kb_baru_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_kb_lama_iud" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_kb_lama_pil" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_kb_lama_sun" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_bcg" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_dpt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_dpt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_dpt_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_polio_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_polio_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_polio_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_polio_4" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_hb_0" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_hb_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_hb_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_hb_3" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_campak" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_tt_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_tt_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_tt_wus_1" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_imunisasi_tt_wus_2" style="max-width: 50px;"></td>
                              <td align="center"><input type="number" name="cipanas_partus" style="max-width: 50px;"></td>
                              <td align="center"><div id="cipanas_jml"></div></td>
                            </tr>
                            <tr>
                              <td>JUMLAH</td>
                              <td align="center"><div id="kia_hamil_b_jml"></div></td>
                              <td align="center"><div id="kia_hamil_l_jml"></div></td>
                              <td align="center"><div id="kb_baru_iud_jml"></div></td>
                              <td align="center"><div id="kb_baru_pil_jml"></div></td>
                              <td align="center"><div id="kb_baru_sun_jml"></div></td>
                              <td align="center"><div id="kb_lama_iud_jml"></div></td>
                              <td align="center"><div id="kb_lama_pil_jml"></div></td>
                              <td align="center"><div id="kb_lama_sun_jml"></div></td>
                              <td align="center"><div id="imunisasi_bcg_jml"></div></td>
                              <td align="center"><div id="imunisasi_dpt_1_jml"></div></td>
                              <td align="center"><div id="imunisasi_dpt_2_jml"></div></td>
                              <td align="center"><div id="imunisasi_dpt_3_jml"></div></td>
                              <td align="center"><div id="imunisasi_polio_1_jml"></div></td>
                              <td align="center"><div id="imunisasi_polio_2_jml"></div></td>
                              <td align="center"><div id="imunisasi_polio_3_jml"></div></td>
                              <td align="center"><div id="imunisasi_polio_4_jml"></div></td>
                              <td align="center"><div id="imunisasi_hb_0_jml"></div></td>
                              <td align="center"><div id="imunisasi_hb_1_jml"></div></td>
                              <td align="center"><div id="imunisasi_hb_2_jml"></div></td>
                              <td align="center"><div id="imunisasi_hb_3_jml"></div></td>
                              <td align="center"><div id="campak_jml"></div></td>
                              <td align="center"><div id="tt_1_jml"></div></td>
                              <td align="center"><div id="tt_2_jml"></div></td>
                              <td align="center"><div id="tt_wus_1_jml"></div></td>
                              <td align="center"><div id="tt_wus_2_jml"></div></td>
                              <td align="center"><div id="partus_jml"></div></td>
                              <td align="center"><div id="total"></div></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div> -->
                </form>
              </div>
              <div class="card-footer row">
              	<div class="col-md-2">
            			<button id="0" name="btn_save" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Save</button>
            		</div>
            		<div class="col-md-2">
            			<button name="btn_cancel" class="btn btn-danger btn-block"><i class="fa fa-times"></i> Cancel</button>
            		</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?php echo base_url('assets/js/core/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/popper.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js'); ?>"></script>
  <!-- Chart JS -->
  <script src="<?php echo base_url('assets/js/plugins/chartjs.min.js'); ?>"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url('assets/js/plugins/bootstrap-notify.js'); ?>"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url('assets/js/now-ui-dashboard.min.js?v=1.3.0'); ?>" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo base_url('assets/demo/demo.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/admina.laporan.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>
</body>

</html>