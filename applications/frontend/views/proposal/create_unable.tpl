{extends file='site_layout.tpl'}
{block name='content'}
	
	<div class="row">
		<div class="col-lg-12">
			
			{if $kegiatan != NULL}
				<div class="alert alert-danger" role="alert">
					Mohon maaf. Anda sudah tidak bisa menambahkan proposal lagi untuk kegiatan {$nama_program} tahun {$tahun}
				</div>
			{else}
				<div class="alert alert-danger" role="alert">
					Mohon maaf. Tidak ada kegiatan yang aktif.
				</div>
			{/if}
			
		</div>
	</div>
{/block}