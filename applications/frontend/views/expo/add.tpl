{extends file='site_layout.tpl'}
{block name='head'}
	<style>.table { font-size: 14px; }</style>
{/block}
{block name='content'}
	<h2 class="page-header">Tambah usulan untuk ikut Expo KMI</h2>
	<div class="row">
		<div class="col-lg-12">

			<p>
				<a href="{site_url('expo')}">Kembali ke daftar usulan Expo</a>
			</p>
			
			{if isset($error)}
				<p class="text-danger">{$error['message']}</p>
			{/if}
			
			<form action="{current_url()}" method="post" enctype="multipart/form-data" class="form-horizontal">
				<fieldset>
					<legend>Detail Usaha</legend>
					
					<div class="form-group">
						<label for="judul" class="col-lg-2 control-label">Nama Usaha</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="judul" value="{set_value('judul')}">
						</div>
					</div>

					<div class="form-group">
						<label for="kategori" class="col-lg-2 control-label">Kategori</label>
						<div class="col-lg-4">
							{$kategori_id=set_value('kategori_id')}
							<select name="kategori_id" class="form-control">
								{html_options options=$kategori_set selected=$kategori_id}
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Mahasiswa Pengusul</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_ketua" placeholder="NIM / NPM" value="{set_value('nim_ketua')}">
						</div>
						<div class="col-lg-7">
							<input type="text" class="form-control" name="nama_ketua" placeholder="Nama Mahasiswa" value="{set_value('nama_ketua')}">
						</div>
						<div class="col-lg-1">Subsidi Ristekdikti</div>
					</div>
						
					<div class="form-group">
						<label class="col-lg-2 control-label">Anggota 1</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_anggota_1" placeholder="NIM / NPM" value="{set_value('nim_anggota_1')}">
						</div>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="nama_anggota_1" placeholder="Nama Mahasiswa" value="{set_value('nama_anggota_1')}">
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-lg-2 control-label">Anggota 2</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_anggota_2" placeholder="NIM / NPM" value="{set_value('nim_anggota_2')}">
						</div>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="nama_anggota_2" placeholder="Nama Mahasiswa" value="{set_value('nama_anggota_2')}">
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-lg-2 control-label">Anggota 3</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_anggota_3" placeholder="NIM / NPM" value="{set_value('nim_anggota_3')}">
						</div>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="nama_anggota_3" placeholder="Nama Mahasiswa" value="{set_value('nama_anggota_3')}">
						</div>
					</div>
						
					<!-- Text input-->
					<div class="form-group">
						<label class="col-lg-2 control-label" for="file1">Profil Usaha</label>  
						<div class="col-lg-5">
							<input id="file1" name="file1" class="form-control input-md" type="file">
						</div>
						<div class="col-lg-4" style="padding-top: 9px">
							<span class="text-info">File yang di ijinkan: PDF. Format bisa dilihat di <a href="{site_url('site/download')}" target="_blank">{site_url('site/download')}</a></span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-2"></div>
						<div class="col-lg-10">
							<p class="text-danger">Peserta/Delegasi Expo yang mendapat subsidi dari Ristekdikti hanya berjumlah 1 orang saja tiap jenis usaha.</p>
						</div>
					</div>
							
					<div class="form-group">
						<div class="col-lg-2"></div>
						<div class="col-lg-10">
							<input type="submit" value="Submit" class="btn btn-primary"/>
							<a href="{site_url('expo')}" class="btn btn-default">Kembali</a>
						</div>
					</div>

				</fieldset>

			</form>

		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script>
		$(document).ready(function () {
			/* File Style */
			$(':file').filestyle();
		});
	</script>
{/block}