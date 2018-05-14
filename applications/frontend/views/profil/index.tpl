{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Pengisian Buku Profil Kewirausahaan</h2>
	
	<h3><strong>{$pt->nama_pt}</strong></h3>
	<p>Alamat : {$alamat_pt}</p>
	<p>Unit Kewirausahaan : {if $pt->ada_unit_kewirausahaan}<span class="label label-success">Ada</span>{else}<span class="label label-warning">Tidak ada</span>{/if}</p>
	<p><a href="{site_url('profil/update-uk')}" class="btn btn-primary">Update Profil Unit Kewirausahaan</a></p>
	
	<div class="row">
		<div class="col col-lg-3">
			{if $uk->file_papan_nama_1 != ''}
				<div class="thumbnail">
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$uk->file_papan_nama_1}">
				</div>
			{/if}
		</div>
		<div class="col col-lg-3">
			{if $uk->file_papan_nama_2 != ''}
				<div class="thumbnail">
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$uk->file_papan_nama_2}">
				</div>
			{/if}
		</div>
		<div class="col col-lg-3">
			{if $uk->file_kegiatan_1 != ''}
				<div class="thumbnail">
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$uk->file_kegiatan_1}">
				</div>
			{/if}
		</div>
		<div class="col col-lg-3">
			{if $uk->file_kegiatan_2 != ''}
				<div class="thumbnail">
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$uk->file_kegiatan_2}">
				</div>
			{/if}
		</div>
	</div>	
		
	<p class="text-warning">Catatan: Informasi kelompok wirausaha yang dientrikan di bawah ini boleh dimasukkan kelompok dari program sebelum KBMI  / PMW / PBBT / Co-OP untuk tahun 2016 s.d. 2017.</p>
	
	<h3>Kelompok Mahasiswa Wirausaha yang didanai Ristekdikti</h3>
	<div class="row">
		<div class="col col-md-4">
			<div class="thumbnail">
				{if $pku_ristek_1->file_produk != ''}
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$pku_ristek_1->file_produk}" style="width: 100%" />
				{/if}
				<div class="caption">
					{if $pku_ristek_1->nama_produk != '' and $pku_ristek_1->nama_ketua != ''}
						<h5><strong>{$pku_ristek_1->nama_produk} ({$pku_ristek_1->nama_ketua})</strong></h5>
					{/if}
					{if $pku_ristek_1->gambaran_bisnis != ''}
						<p>{$pku_ristek_1->gambaran_bisnis}</p>
					{/if}
					<p><a href="{site_url('profil/update-kelompok?kemenristek=1&kelompok=1')}" class="btn btn-sm btn-primary">Update Kelompok 1</a></p>
				</div>
			</div>
		</div>
		<div class="col col-md-4">
			<div class="thumbnail">
				{if $pku_ristek_2->file_produk != ''}
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$pku_ristek_2->file_produk}" style="width: 100%" />
				{/if}
				<div class="caption">
					{if $pku_ristek_2->nama_produk != '' and $pku_ristek_2->nama_ketua != ''}
						<h5><strong>{$pku_ristek_2->nama_produk} ({$pku_ristek_2->nama_ketua})</strong></h5>
					{/if}
					{if $pku_ristek_2->gambaran_bisnis != ''}
						<p>{$pku_ristek_2->gambaran_bisnis}</p>
					{/if}
					<p><a href="{site_url('profil/update-kelompok?kemenristek=1&kelompok=2')}" class="btn btn-sm btn-primary">Update Kelompok 2</a></p>
				</div>
			</div>
		</div>
		<div class="col col-md-4">
			<div class="thumbnail">
				{if $pku_ristek_3->file_produk != ''}
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$pku_ristek_3->file_produk}" style="width: 100%" />
				{/if}
				<div class="caption">
					{if $pku_ristek_3->nama_produk != '' and $pku_ristek_3->nama_ketua != ''}
						<h5><strong>{$pku_ristek_3->nama_produk} ({$pku_ristek_3->nama_ketua})</strong></h5>
					{/if}
					{if $pku_ristek_3->gambaran_bisnis != ''}
						<p>{$pku_ristek_3->gambaran_bisnis}</p>
					{/if}
					<p><a href="{site_url('profil/update-kelompok?kemenristek=1&kelompok=3')}" class="btn btn-sm btn-primary">Update Kelompok 3</a></p>
				</div>
			</div>
		</div>
	</div>
	
	<h3>Kelompok Mahasiswa Wirausaha yang didanai Non-Ristekdikti</h3>
	<div class="row">
		<div class="col col-md-4">
			<div class="thumbnail">
				{if $pku_nonristek_1->file_produk != ''}
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$pku_nonristek_1->file_produk}" style="width: 100%" />
				{/if}
				<div class="caption">
					{if $pku_nonristek_1->nama_produk != '' and $pku_nonristek_1->nama_ketua != ''}
						<h5><strong>{$pku_nonristek_1->nama_produk} ({$pku_nonristek_1->nama_ketua})</strong></h5>
					{/if}
					{if $pku_nonristek_1->gambaran_bisnis != ''}
						<p>{$pku_nonristek_1->gambaran_bisnis}</p>
					{/if}
					<p><a href="{site_url('profil/update-kelompok?kemenristek=0&kelompok=1')}" class="btn btn-sm btn-primary">Update Kelompok 1</a></p>
				</div>
			</div>
		</div>
		<div class="col col-md-4">
			<div class="thumbnail">
				{if $pku_nonristek_2->file_produk != ''}
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$pku_nonristek_2->file_produk}" style="width: 100%" />
				{/if}
				<div class="caption">
					{if $pku_nonristek_2->nama_produk != '' and $pku_nonristek_2->nama_ketua != ''}
						<h5><strong>{$pku_nonristek_2->nama_produk} ({$pku_nonristek_2->nama_ketua})</strong></h5>
					{/if}
					{if $pku_nonristek_2->gambaran_bisnis != ''}
						<p>{$pku_nonristek_2->gambaran_bisnis}</p>
					{/if}
					<p><a href="{site_url('profil/update-kelompok?kemenristek=0&kelompok=2')}" class="btn btn-sm btn-primary">Update Kelompok 2</a></p>
				</div>
			</div>
		</div>
		<div class="col col-md-4">
			<div class="thumbnail">
				{if $pku_nonristek_3->file_produk != ''}
					<img src="{base_url()}upload/buku-profil/{$pt->npsn}/{$pku_nonristek_3->file_produk}" style="width: 100%" />
				{/if}
				<div class="caption">
					{if $pku_nonristek_3->nama_produk != '' and $pku_nonristek_3->nama_ketua != ''}
						<h5><strong>{$pku_nonristek_3->nama_produk} ({$pku_nonristek_3->nama_ketua})</strong></h5>
					{/if}
					{if $pku_nonristek_3->gambaran_bisnis != ''}
						<p>{$pku_nonristek_3->gambaran_bisnis}</p>
					{/if}
					<p><a href="{site_url('profil/update-kelompok?kemenristek=0&kelompok=3')}" class="btn btn-sm btn-primary">Update Kelompok 3</a></p>
				</div>
			</div>
		</div>
	</div>
{/block}