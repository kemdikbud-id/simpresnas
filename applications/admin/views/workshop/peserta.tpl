{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style>.table>thead>tr>th, .table>tbody>tr>td { font-size: 13px }</style>
{/block}
{block name='content'}
	<h2 class="page-header">Daftar Peserta Workshop</h2>

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
				<table class="table table-bordered table-condensed table-striped" id="pesertaTable" style="display: none">
					<thead>
						<tr>
							<th style="width:50px">No</th>
							<th>NIM</th>
							<th>Nama</th>
							<th>Perguruan Tinggi</th>
						</tr>
					</thead>
					<tbody>
						{foreach $data_set as $data}
							<tr>
								<td>{$data@index + 1}</td>
								<td>{$data->nim}</td>
								<td>{$data->nama}</td>
								<td>{$data->nama_pt}</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			{/if}
		</div>
	</div>
	
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('#pesertaTable').DataTable();
			$('#pesertaTable').show();
			
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