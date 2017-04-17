{extends file='site_layout.tpl'}
{block name='head'}
	<style>
		.jumbotron { background-color: transparent; padding: 20px; }
		.jumbotron h1 { font-size: 60px; }
	</style>
{/block}
{block name='content'}
	<div class="jumbotron">
        <h1 class="text-center">Program Kewirausahaan Mahasiswa Indonesia</h1>
    </div>

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

					<p><a class="btn btn-primary" href="{site_url('auth/login/pbbt')}">Login Pendaftaran PBBT</a>
						<a class="btn btn-warning" href="{site_url('auth/login/pbbt-reviewer')}">Login Reviewer</a>
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

					<p><a class="btn btn-primary" href="{site_url('auth/login/kbmi')}">Login Pendaftaran KBMI</a>
						<a class="btn btn-warning" href="{site_url('auth/login/kbmi-reviewer')}">Login Reviewer</a>
					</p>
				</div>
			</div>
		</div>
	</div>
{/block}