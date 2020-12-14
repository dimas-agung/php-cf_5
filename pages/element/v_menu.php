	<header>
		<nav class="navbar navbar-dark bg-dark navbar-expand-md">			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse container" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
					  <span class="navbar-brand mb-0 h1">PT. Cahaya Fajar</span>
					</li>
					<?php if (in_array($_SESSION['app_level'], array_unique($dashboardRole))) { ?>
					<li class="nav-item">
					  <a class="nav-link" href="<?=base_url();?>">
						Dashboard
					  </a>
					</li>
					<?php } if (in_array($_SESSION['app_level'], array_unique($settingRole))) { ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="<?=base_url();?>#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Setting
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/profil&halaman=Setting+Profil+Perusahaan">
								Setting Profil Perusahaan
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/cabang&halaman=Setting+Cabang">
								Setting Cabang
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/gudang&halaman=Setting+Gudang">
								Setting Gudang
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/kat_divisi&halaman=Setting+Kategori+Divisi">
								Setting Kategori Divisi
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/kat_coa&halaman=Setting+Kategori+COA">
								Setting Kategori COA
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/kat_cashflow&halaman=Setting+Kategori+Cashflow">
								Setting Kategori Cashflow
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/kat_aset&halaman=Setting+Kategori+Aset">
								Setting Kategori Aset
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/kat_inv&halaman=Setting+Kategori+Inventori">
								Setting Kategori Inventori
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/kat_pel&halaman=Setting+Kategori+Pelanggan">
								Setting Kategori Pelanggan
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/tutup_periode&halaman=Setting+Tutup+Periode">
								Setting Tutup Periode
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=setting/user&halaman=Setting+Data+User">
								Setting Data User
							</a>
						</div>
					</li>
					<?php } if (in_array($_SESSION['app_level'], array_unique($masterRole))) { ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="<?=base_url();?>#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Master
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?=base_url();?>?page=master/valas&halaman=Master+Valas">
								Master Valas
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=master/satuan&halaman=Master+Satuan">
								Master Satuan
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=master/barang&halaman=Master+Inventori">
								Master Inventori
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=master/coa&halaman=Master+COA">
								Master COA
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=master/karyawan&halaman=Master+Karyawan">
								Master Karyawan
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=master/supplier&halaman=Master+Supplier">
								Master Supplier
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=master/pelanggan&halaman=Master+Pelanggan">
								Master Pelanggan
							</a>						
							<a class="dropdown-item" href="<?=base_url();?>?page=master/aset&halaman=Master+Aset">
								Master Aset
							</a>
						</div>
					</li>
					<?php } if (in_array($_SESSION['app_level'], array_unique($pembelianRole))) { ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="<?=base_url();?>#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Pembelian
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?=base_url();?>?page=pembelian/op&halaman=Pembelian+Inventori">
								Pembelian Inventori
							</a>
							<!-- <a class="dropdown-item" href="<?=base_url();?>?page=pembelian/ops&halaman=Pembelian+Aset">
								Pembelian Aset
							</a> -->
							<a class="dropdown-item" href="<?=base_url();?>?page=pembelian/rb&halaman=Nota+Retur+Pembelian">
								Nota Retur Pembelian
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=pembelian/lpb&halaman=Laporan+Pembelian">
								Laporan Pembelian
							</a>
						</div>
					</li>
					<?php } if (in_array($_SESSION['app_level'], array_unique($penjualanRole))) { ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="<?=base_url();?>#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Penjualan
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?=base_url();?>?page=penjualan/so&halaman=Penjualan+Sales">
								Penjualan Sales
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=penjualan/pl&halaman=Packing+List">
								Packing List
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=penjualan/fj&halaman=Faktur+Penjualan">
								Faktur Penjualan
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=penjualan/rj&halaman=Nota+Retur+Penjualan">
								Nota Retur Penjualan
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=penjualan/lpj&halaman=Laporan+Penjualan">
								Laporan Penjualan
							</a>
						</div>
					</li>
					<?php } if (in_array($_SESSION['app_level'], array_unique($logistikRole))) { ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="<?=base_url();?>#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Logistik
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?=base_url();?>?page=logistik/btb&halaman=Bukti+Terima+Barang">
								Bukti Terima Barang
							</a>
							<!-- <a class="dropdown-item" href="<?=base_url();?>?page=logistik/bts&halaman=Bukti+Terima+Aset">
								Bukti Terima Aset
							</a> -->
							<a class="dropdown-item" href="<?=base_url();?>?page=logistik/sm&halaman=Stok+Masuk">
								Stok Masuk
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=logistik/sk&halaman=Stok+Keluar">
								Stok Keluar
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=logistik/sj&halaman=Surat+Jalan">
								Surat Jalan
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=logistik/ks&halaman=Kartu+Stok">
								Kartu Stok
							</a>
							<!-- <a class="dropdown-item" href="<?=base_url();?>?page=logistik/pm_list&halaman=Permintaan+Material">
								Permintaan Material
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=logistik/tg&halaman=Transfer+Gudang">
								Transfer Gudang
							</a> -->
						</div>
					</li>
					<?php } if (in_array($_SESSION['app_level'], array_unique($keuanganRole))) { ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="<?=base_url();?>#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Keuangan
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/buku_besar&halaman=Buku+Besar">
								Buku Besar
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/bkk&halaman=Bukti+Kas+Keluar">
								Bukti Kas Keluar
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/bkm&halaman=Bukti+Kas+Masuk">
								Bukti Kas Masuk
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/fb&halaman=Faktur+Pembelian">
								Faktur Pembelian
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/jm&halaman=Jurnal+Memorial">
								Jurnal Memorial
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/lr&halaman=Laba+Rugi">
								Laba Rugi
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/lgp&halaman=Laporan+Gross+Profit">
								Laporan Gross Profit
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/nrc&halaman=Neraca">
								Neraca
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/nrc_percobaan&halaman=Neraca+Percobaan">
								Neraca Percobaan
							</a>
							<!-- <a class="dropdown-item" href="<?=base_url();?>?page=keuangan/nb&halaman=Nota+Debet">
								Nota Debet
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/nk&halaman=Nota+Kredit">
								Nota Kredit
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/hg&halaman=History+Giro">
								History Giro
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/hg&halaman=History+Giro">
								History Giro
							</a> -->
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/gm&halaman=Giro+Masuk">
								Giro Masuk
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=keuangan/gk&halaman=Giro+Keluar">
								Giro Keluar
							</a>
							<!-- <a class="dropdown-item" href="<?=base_url();?>?page=keuangan/pg&halaman=Pelunasan+Giro">
								Pelunasan Giro
							</a> -->
						</div>
					</li>
					<?php } if (in_array($_SESSION['app_level'], array_unique($spkRole))) { ?>
					<!-- <li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="<?=base_url();?>#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Produksi
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?=base_url();?>?page=produksi/spk&halaman=Surat+Perintah+Kerja">
								Surat Perintah Kerja
							</a>
							<a class="dropdown-item" href="<?=base_url();?>?page=produksi/cls_spk&halaman=Tutup+SPK">
								Tutup SPK
							</a>
						</div>
					</li> -->
					<?php } ?>
				</ul>
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="<?=base_url();?>#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?=$_SESSION['app_user'];?>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?=base_url();?>?page=ubah_pass&action=edit&kode=<?=$_SESSION['app_id'];?>">
								Ubah Password
							</a>
							<a class="dropdown-item" href="<?=base_url();?>logout.php">
								Keluar
							</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<main role="main" class="flex-shrink-0">
		<div class="container">