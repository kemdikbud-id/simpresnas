{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Daftar Proposal PBBT Masuk</h1>

	<div class="row">
		<div class="col-lg-12">

			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Judul</th>
						<th>Perguruan Tinggi</th>
						<th>Kelengkapan Syarat</th>
						<th>Waktu Upload</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data@index + 1}</td>
							<td>{$data->judul}</td>
							<td>{$data->nama_pt}</td>
							<td>
								{if $data->jumlah_syarat == $data->syarat_terupload}
									<span class="label label-success">LENGKAP</span>
								{else if $data->syarat_wajib == $data->syarat_wajib_terupload}
									<span class="label label-info">CUKUP MINIMAL</span>
								{else}
									<span class="label label-warning">BELUM LENGKAP</span>
								{/if}
							</td>
							<td></td>
							<td>
								<a href="{site_url("proposal/view?id={$data->id}")}" class="btn btn-sm btn-default">Lihat</a>
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