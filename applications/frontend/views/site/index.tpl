{extends file='site_layout.tpl'}
{block name='head'}
	<style>
		.jumbotron { background-color: transparent; padding: 20px; }
		.jumbotron h1 { font-size: 40px; }
		.btn-daftar { padding: 10px 15px; }
	</style>
{/block}
{block name='content'}
	<div class="jumbotron text-center">
        <h1>Selamat datang di Portal SIM-PKMI</h1>
		<!-- <p class="lead">Pendaftaran <strong>Workshop Kewirausahaan 2018</strong> telah dibuka dan dilaksanakan di 9 lokasi !<br/>Segera login untuk melakukan pendaftaran</p> -->
    </div>
	
	<hr/>
	
	<div class="row">
		<div class="col-md-4 text-center">
			<h3>Workshop Kewirausahaan</h3>
			<p>Kegiatan yang bertujuan agar mahasiswa mampu membuat proposal pengembangan bisnis yang baik dan mampu menganalisis serta mengimplementasikan elemen-elemen penting dalam pengembangan bisnis.</p>
			<p><a target="_blank" href="{base_url()}download/panduan-workshop-kewirausahaan-2018.pdf">Download Panduan Workshop Kewirausahaan</a></p>
		</div>
		<div class="col-md-4 text-center">
			<h3>Program Belajar Bekerja Terpadu (PBBT)</h3>
			<p>Program memperkenalkan dunia usaha atau dunia kerja lebih dini kepada mahasiswa dengan mengintegrasikan berbagai 
						latar belakang ilmu yang didapatnya di bangku kuliah dengan pengalaman nyata dunia usaha</p>
		</div>
		<div class="col-md-4 text-center">
			<h3>Kompetisi Bisnis Mahasiswa Indonesia (KBMI)</h3>
			<p>Wadah untuk mempraktekan ilmu dan keterampilan berwirausaha yang sudah didapat oleh mahasiswa melalui pemberian modal</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4 text-center">
			<h3>Expo KMI</h3>
			<p>Expo Kewirausahaan Mahasiswa Indonesia (Expo KMI) adalah kegiatan tahunan berupa pameran usaha yang telah dijalankan dan ajang temu bisnis bagi mahasiswa pelaksana kewirausahaan</p>
		</div>
	</div>

	<!--
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2>Program Belajar Bekerja Terpadu (PBBT)</h2>

					<p>Program memperkenalkan dunia usaha atau dunia kerja lebih dini kepada mahasiswa dengan mengintegrasikan berbagai 
						latar belakang ilmu yang didapatnya di bangku kuliah dengan pengalaman nyata dunia usaha</p>

					<table class="table table-bordered">
						<tbody>
							<tr>
								<td>Jadwal Pelaksanaan Upload</td>
								<td>
									{$kegiatan_pbbt->tgl_awal_upload|date_format:"%d %B %Y"} -
									{$kegiatan_pbbt->tgl_akhir_upload|date_format:"%d %B %Y %T"}
								</td>
							</tr>
							<tr>
								<td>Pengumuman</td>
								<td>{$kegiatan_pbbt->tgl_pengumuman|date_format:"%d %B %Y"}</td>
							</tr>
						</tbody>
					</table>

					<p>
						<a class="btn btn-primary" href="{site_url('auth/login')}">Login</a>
						{*<a class="btn btn-warning" href="{site_url('auth/login/pbbt-reviewer')}">Login Reviewer</a>*}
					</p>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2>Kompetisi Bisnis Mahasiswa Indonesia (KBMI)</h2>

					<p>Wadah untuk mempraktekan ilmu dan keterampilan berwirausaha yang sudah didapat oleh mahasiswa melalui pemberian modal 
					</p>

					<table class="table table-bordered">
						<tbody>
							<tr>
								<td>Jadwal Pelaksanaan Upload</td>
								<td>
									{$kegiatan_kbmi->tgl_awal_upload|date_format:"%d %B %Y"} -
									{$kegiatan_kbmi->tgl_akhir_upload|date_format:"%d %B %Y %T"}
								</td>
							</tr>
							<tr>
								<td>Pengumuman</td>
								<td>{$kegiatan_kbmi->tgl_pengumuman|date_format:"%d %B %Y"}</td>
							</tr>
						</tbody>
					</table>

					<p>
						<a class="btn btn-primary" href="{site_url('auth/login')}">Login</a>
						{*<a class="btn btn-warning" href="{site_url('auth/login/kbmi-reviewer')}">Login Reviewer</a>*}
					</p>
				</div>
			</div>
		</div>
	</div>
	-->
{/block}