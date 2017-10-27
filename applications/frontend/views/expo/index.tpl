{extends file='site_layout.tpl'}
{block name='head'}
	<style>.table { font-size: 14px; }</style>
{/block}
{block name='content'}
	<h2 class="page-header">Daftar Delegasi Expo KMI</h2>
	<div class="row">
		<div class="col-lg-12">

			{if count($data_set) < $kegiatan->proposal_per_pt}
			<p>
				<!-- <a href="{site_url('expo/pilih-proposal')}" class="btn btn-info">Daftarkan Usaha dari Program KBMI</a> -->
				<a href="{site_url('expo/add')}" class="btn btn-primary">Tambah Usaha</a>
			</p>
			{/if}
			
			<table class="table table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Nama Usaha</th>
						<th>Kategori</th>
						<th class="text-center">Status</th>
						<th style="width: 220px"></th>
					</tr>
				</thead>
				<tbody>
				{foreach $data_set as $data}
					<tr>
						<td class="text-center">{$data@index + 1}</td>
						<td>{$data->judul}</td>
						<td>{$data->nama_kategori}</td>
						<td class="text-center">
							{if $data->is_submited == 1}
								{if $data->is_didanai == 0}
									<span class="label label-warning">Seleksi Kelayakan</span>
								{else if $data->is_didanai == 1}
									<span class="label label-success">Ikut EXPO</span>
								{/if}
							{/if}
						</td>
						<td>
							{* Boleh di edit/hapus jika belum disubmit *}
							{if $data->is_submited == 0}
								<a href="{site_url('expo/edit')}/{$data->id}" class="btn btn-xs btn-success">Edit</a>
								<a href="{site_url('expo/hapus')}/{$data->id}" class="btn btn-xs btn-danger">Hapus</a>
								<a href="{site_url('expo/submit')}/{$data->id}" class="btn btn-xs btn-primary">Ajukan Untuk Seleksi</a>
							{/if}
						</td>
					</tr>
				{foreachelse}
					<tr>
						<td colspan="6">Belum ada data</td>
					</tr>
				{/foreach}
				</tbody>
			</table>
			<p class="text-success">Batas Upload : {$kegiatan->proposal_per_pt} Usulan</p>
			<p class="text-danger">Setiap delegasi terdiri dari maksimum 3 (tiga) jenis / kategori usaha. Masing-masing jenis usaha diwakili oleh 1 (satu) orang mahasiswa sebagai tim. Delegasi dapat didampingi oleh dosen Pembimbing Kewirausahaannya.</p>
		</div>
	</div>
{/block}