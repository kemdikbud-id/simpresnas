{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style type="text/css">
		.table>thead>tr>th,.table>tbody>tr>td { color: #333; }
		.table-condensed>thead>tr>th,.table-condensed>tbody>tr>td { font-size: 13px; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Penilaian {if $tahapan}{$tahapan->tahapan}{/if}</h2>

	<div class="row">
		<div class="col-lg-12">

			<form class="form-inline" action="{current_url()}" method="get" style="margin-bottom: 10px" id="formFilter">
				<div class="form-group">
					<label for="kegiatan_id">Kegiatan</label>
					<select name="kegiatan_id" class="form-control input-sm">
						<option value="">-- Pilih Kegiatan --</option>
						{html_options options=$kegiatan_option_set selected=$smarty.get.kegiatan_id}
					</select>
				</div>
				<div class="form-group">
					<label for="tahapan_id">Tahapan</label>
					<select name="tahapan_id" class="form-control input-sm">
						<option value="">-- Pilih Tahapan --</option>
						{html_options options=$tahapan_option_set selected=$smarty.get.tahapan_id}
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">Lihat</button>
			</form>
					
			<table class="table table-bordered table-striped table-condensed" id="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Judul</th>
						<th>Perguruan Tinggi</th>
						<th>Rekom</th>
						<th>Nilai</th>
						<th></th>
					</tr>
				</thead>
			</table>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type="text/javascript">
		
		var keg_id = '{if isset($smarty.get.kegiatan_id)}{$smarty.get.kegiatan_id}{else}0{/if}';
		var thp_id = '{if isset($smarty.get.tahapan_id)}{$smarty.get.tahapan_id}{else}0{/if}';
		
		var dataTable = $('#table').DataTable({
			lengthMenu: [[10,20,25,50,-1],[10,20,25,50,'Semua']],
			stateSave: true,
			ajax: '{site_url('review/index-data/')}?kegiatan_id='+keg_id+'&tahapan_id='+thp_id,
			columns: [
				{
					data: null, className: 'text-center', defaultContent: '', orderable: false
					// render: function(data, type, row, meta) { return meta.row + 1; }
				},
				{ data: 'judul' }, { data: 'nama_pt' }, 
				{ data: 'biaya_rekomendasi', className: 'text-center', render: $.fn.dataTable.render.number('.') }, 
				{ data: 'nilai_reviewer', className: 'text-center' }, 
				{
					data: 'id', 
					render: function(data, type, row, meta) {
						if (thp_id === '1')
							return '<a class="btn btn-sm btn-info" href="{site_url('review/penilaian/')}'+data+'">Nilai</a>';
						else if (thp_id === '2')
							return '<a class="btn btn-sm btn-info" href="{site_url('review/monev/')}'+data+'">Nilai</a>';
						else 
							return '';
					},
					orderable: false
				}
			]
		});
		
		// Numbering
		dataTable.on('order.dt search.dt', function() {
			dataTable.column(0, { search:'applied', order:'applied' }).nodes().each(function(cell, i) {
				cell.innerHTML = i+1;
        	});
		}).draw();
	</script>
{/block}