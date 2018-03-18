{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Update Proposal</h2>
	<div class="row">
		<div class="col-lg-12">

			<form action="{current_url()}" method="post" enctype="multipart/form-data" class="form-horizontal">
				<fieldset>
					<legend>Detail</legend>

					<div class="form-group">
						<label for="judul" class="col-lg-2 control-label">Judul Proposal</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="judul" placeholder="Tulis judul proposal disini" value="{$proposal->judul}">
						</div>
					</div>

					<div class="form-group">
						<label for="kategori" class="col-lg-2 control-label">Kategori</label>
						<div class="col-lg-4">
							<select name="kategori_id" class="form-control">
								{html_options options=$kategori_set selected=$proposal->kategori_id}
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Ketua</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_ketua" placeholder="NIM / NPM" value="{$proposal->nim_ketua}" >
						</div>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="nama_ketua" placeholder="Nama Ketua" value="{$proposal->nama_ketua}">
						</div>
					</div>
						
					{for $i_anggota=1 to 5}
						
						{if not isset($anggota_set[{$i_anggota}])}
							{$anggota_id = ''}
							{$nim = ''}
							{$nama = ''}
						{else}
							{$anggota_id = $anggota_set[{$i_anggota}]->id}
							{$nim = $anggota_set[{$i_anggota}]->nim}
							{$nama = $anggota_set[{$i_anggota}]->nama}
						{/if}
						
						<div class="form-group">
							<label class="col-lg-2 control-label">Anggota {$i_anggota}</label>
							<div class="col-lg-2">
								<input type="text" class="form-control" name="nim_anggota[{$i_anggota}]" placeholder="NIM / NPM" value="{set_value('nim_anggota[{$i_anggota}]', $nim)}">
							</div>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="nama_anggota[{$i_anggota}]" placeholder="Nama Anggota {$i_anggota}" value="{set_value('nama_anggota[{$i_anggota}]', $nama)}">
							</div>
						</div>
						<input type="hidden" name="id_anggota[{$i_anggota}]" value="{$anggota_id}" />
					{/for}

				</fieldset>

				<fieldset>
					<legend>Syarat Proposal</legend>
					
					{foreach $syarat_set as $syarat}
						<div class="form-group">
							<label class="col-lg-2 control-label">{$syarat->syarat}</label>
							<div class="col-lg-6">
								<input type="file" name="file_syarat_{$syarat->id}" class="filestyle" />
								<p class="help-block">{$syarat->keterangan}</p>
							</div>
							<div class="col-lg-4">
								<p class="form-control-static"><a href="{$upload_path}{$syarat->nama_file}" target="_blank">{$syarat->nama_asli}</a></p>
							</div>
						</div>	
					{/foreach}

					<div class="form-group">
						<div class="col-lg-2"></div>
						<div class="col-lg-10"><a href="{site_url('proposal')}" class="btn btn-default">Kembali</a> 
							<input type="submit" value="Submit" class="btn btn-primary"/></div>
					</div>

				</fieldset>
			</form>

		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script>
		$(':file').filestyle();
	</script>
{/block}