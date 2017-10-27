{extends file='site_layout.tpl'}
{block name='head'}
	<style>.table { font-size: 14px; }</style>
{/block}
{block name='content'}
	<h2 class="page-header">Pilih proposal yang telah lolos program KBMI</h2>
	<div class="row">
		<div class="col-lg-12">

			<p>
				<a href="{site_url('expo')}">Kembali ke daftar usaha Expo</a>
			</p>
			
			<table class="table table-bordered table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th>Judul</th>
						<th>Kategori</th>
						<th>Ketua</th>
						<th style="width: 120px">Aksi</th>
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
								<a href="{site_url('expo/add-usaha')}?proposal_id={$data->id}" class="btn btn-xs btn-primary">Daftarkan ke Expo</a>
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="5">Tidak ada data ditemukan</td>
						</tr>
					{/foreach}
				</tbody>
			</table>

		</div>
	</div>
{/block}