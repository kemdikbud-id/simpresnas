{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Master Download File</h1>
	
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Judul</th>
						<th>Link / File</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data@index + 1}</td>
							<td>{$data->judul}</td>
							<td>
								{if $data->is_external}
									<a href="{$data->link}">{$data->link}</a>
								{else}
									<a href="{base_url()}../download/{$data->nama_file}">{$data->nama_file}</a>
								{/if}
							</td>
							<td>
								<a href="{site_url('download/delete')}/{$data->id}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
							</td>
						</tr>
					{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<a href="{site_url('download/add')}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah File</a>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	
{/block}