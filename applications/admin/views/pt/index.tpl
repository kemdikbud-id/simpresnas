{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Daftar Perguruan Tinggi</h1>
	
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Perguruan Tinggi</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->npsn}</td>
							<td>{$data->nama_pt}</td>
							<td>{$data->email_pt}</td>
							<td>
								<a href="{site_url("pt/update/{$data->id}")}" class="btn btn-sm btn-default">Edit</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{/block}