{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Daftar Pengguna</h1>
	
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Username</th>
						<th>Perguruan Tinggi</th>
						<th>Program</th>
						<th>Jenis User</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->username}</td>
							<td>{$data->nama_pt}</td>
							<td>{if $data->program_id == 1}PBBT{else}KBMI{/if}</td>
							<td>{if $data->tipe_user == 1}Pengusul{else if $data->tipe_user == 2}Reviewer{else if $data->tipe_user == 99}Admin{/if}</td>
							<td>
								<a href="{site_url("user/update/{$data->id}")}" class="btn btn-sm btn-default">Edit</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{/block}