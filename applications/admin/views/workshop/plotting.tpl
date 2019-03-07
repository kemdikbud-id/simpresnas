{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style>.table>thead>tr>th, .table>tbody>tr>td { font-size: 13px }</style>
{/block}
{block name='content'}
	<h2 class="page-header">Plotting Reviewer Peserta Workshop</h2>

	<div class="row">
		<div class="col-lg-12">
			<form class="form-inline" action="{current_url()}" method="get" style="margin-bottom: 20px">
				<div class="form-group">
					<select name="kegiatan_id" class="form-control">
						<option value="">-- Pilih Kegiatan --</option>
						{foreach $kegiatan_set as $kegiatan}
							<option value="{$kegiatan->id}" {if !empty($smarty.get.kegiatan_id)}{if $smarty.get.kegiatan_id == $kegiatan->id}selected{/if}{/if}>{$kegiatan->nama_program} {$kegiatan->tahun}</option>
						{/foreach}
					</select>
					<select name="lokasi_workshop_id" class="form-control">
						<option value="">-- Pilih Lokasi --</option>
						{if isset($lokasi_set)}
							{foreach $lokasi_set as $lokasi}
								<option value="{$lokasi->id}" {if $smarty.get.lokasi_workshop_id == $lokasi->id}selected{/if}>{$lokasi->kota} - {$lokasi->tempat} - {$lokasi->waktu_pelaksanaan|date_format:"%d %B %Y"}</option>
							{/foreach}
						{/if}
					</select>
				</div>
				<button type="submit" class="btn btn-default">
					Lihat
				</button>
			</form>
			
			{if !empty($smarty.get.kegiatan_id)}
				<form action="{site_url('workshop/plotting/pilih-reviewer')}" method="post">
					<input type="hidden" name="mode" value="pilih-reviewer" />
					<table class="table table-bordered table-condensed table-striped" id="plottingPesertaTable" style="display: none;">
						<thead>
							<tr>
								<th></th>
								<th>Perguruan Tinggi</th>
								<th>Nama</th>
								<th style="width: 25px">Seminar</th>
								<th style="width: 25px">Pelatihan</th>
								<th>Reviewer</th>
							</tr>
						</thead>
						<tbody>
							{foreach $data_set as $data}
								<tr>
									<td class="text-center"><input type="checkbox" name="peserta_ids[]" value="{$data->id}" /></td>
									<td>{$data->nama_pt}</td>
									<td>{$data->nama}</td>
									<td class="text-center">{if $data->ikut_seminar}<span class="label label-primary">Ya</span>{/if}</td>
									<td class="text-center">{if $data->ikut_pelatihan}<span class="label label-info">Ya</span>{/if}</td>
									<td>{$data->nama_reviewer}</td>
								</tr>
							{/foreach}
						</tbody>
						<tfoot>
							<tr>
								<td colspan="6" class="text-right">
									<input type="submit" value="Set Reviewer" class="btn btn-default" />
								</td>
							</tr>
						</tfoot>
					</table>
				</form>
			{/if}
		</div>
	</div>
	
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('#plottingPesertaTable').DataTable({
				columnDefs: [
					{ orderable: false, targets: 0 }
				]
			});
			
			$('#plottingPesertaTable').show();
			
			$('[name="kegiatan_id"]').on('change', function() {
				$('[name="lokasi_workshop_id"]').html('<option value="">-- Pilih Lokasi --</option>');
				$.getJSON('{site_url('workshop/data-lokasi')}/' + $(this).val(), function(data) {
					$.each(data, function(key, val) {
						$('[name="lokasi_workshop_id"]').append('<option value="' + val.id + '">' + val.kota + ' - ' + val.tempat + ' - ' + val.waktu_pelaksanaan + '</option>');
					});
				});
			});
			
		});
	</script>
{/block}