{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Daftar Proposal</h1>
	<div class="row">
		<div class="col-lg-12">

			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Judul</th>
						<th>Kategori</th>
						<th>Anggota</th>
						<th>Kelengkapan Syarat</th>
						<th>Aksi</th>
						<th>Proses</th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data@index + 1}</td>
							<td>{$data->judul}</td>
							<td>{$data->nama_kategori}</td>
							<td>{$data->nama_ketua} ({$data->nim_ketua})</td>
							<td>
								{if $data->jumlah_syarat == $data->syarat_terupload}
									<span class="label label-success">LENGKAP</span>
								{else}
									<span class="label label-warning">BELUM LENGKAP</span>
								{/if}
							</td>
							<td>
								<a href="{site_url("proposal/update/{$data->id}")}" class="btn btn-sm btn-default">Edit</a>
							</td>
							<td>
								<a href="{site_url("proposal/submit/{$data->id}")}" class="btn btn-sm btn-success">Submit</a>
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="7">Tidak ada data ditemukan</td>
						</tr>
					{/foreach}
				</tbody>
			</table>

		</div>
	</div>
{/block}