{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	<h1 class="page-header">Daftar Perguruan Tinggi</h1>
	
	<div class="row">
		<div class="col-lg-12">
			<table id="table" class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Perguruan Tinggi</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script>
		$(document).ready(function() {
			$('#table').DataTable({
				ajax: '{site_url('pt/data-pt-all')}',
				columns: [
					{ data: 'npsn' },
					{ data: 'nama_pt' },
					{ data: 'email_pt' },
					{ 
						data: 'id', orderable: false,
						render: function(data) {
							return '<a href="{site_url('pt/update')}/'+data+'" class="btn btn-xs btn-default">Edit</a>';
						}
					}
				],
				stateSave: true
			});
		});
	</script>
{/block}