{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style type="text/css">
		.table>thead>tr>th,.table>tbody>tr>td { color: #333; }
		.table-condensed>thead>tr>th,.table-condensed>tbody>tr>td { font-size: 13px; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Review Peserta Workshop</h2>
	
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
				<button type="submit" class="btn btn-default">Lihat</button>
			</form>
					
			<div class="form-inline" style="margin-bottom: 10px">
				<div class="form-group">
					<label class="control-label">Peserta Seminar:</label>
					<input class="form-control input-sm" readonly value="{$jumlah_peserta_seminar}" id="pesertaSeminar" />
				</div>
				<div class="form-group">
					<label class="control-label">Peserta Pelatihan:</label>
					<input class="form-control input-sm" readonly value="{$jumlah_peserta_pelatihan}" id="pesertaPelatihan" />
				</div>
			</div>
					
			{if !empty($smarty.get.kegiatan_id)}
				<form action="{site_url('workshop/plotting/pilih-reviewer')}" method="post">
					<input type="hidden" name="mode" value="pilih-reviewer" />
					<table class="table table-bordered table-condensed table-striped" id="reviewPesertaWorkshop" style="display: none;">
						<thead>
							<tr>
								<th>Perguruan Tinggi</th>
								<th>Nama</th>
								<th>Noble Purpose</th>
								<th>Tujuan Mulia</th>
								<th>Instagram</th>
								<th>Seminar</th>
								<th>Pelatihan</th>
							</tr>
						</thead>
						<tbody>
							{foreach $data_set as $data}
								<tr>
									<td>{$data->nama_pt}</td>
									<td>{$data->nama}</td>
									<td>{$data->noble_purpose|nl2br}</td>
									<td>{$data->tujuan_mulia|nl2br}</td>
									<td><a href="https://www.instagram.com/{$data->username_ig}" target="_blank">@{$data->username_ig}</a></td>
									<td class="text-center">
										<select class="form-control input-sm set-review seminar-{$data->id}" data-id="{$data->id}" data-mode="seminar">
											<option value="0">Tidak</option>
											<option value="1" {if $data->ikut_seminar == 1}selected{/if}>Ya</option>
										</select>
									</td>
									<td class="text-center">
										<select class="form-control input-sm set-review pelatihan-{$data->id}" data-id="{$data->id}" data-mode="pelatihan">
											<option value="0">Tidak</option>
											<option value="1" {if $data->ikut_pelatihan == 1}selected{/if}>Ya</option>
										</select>
									</td>
								</tr>
							{/foreach}
						</tbody>
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
		function removeDomSlow(dom) {
			$(dom).hide('slow');
			$(dom).remove();
		}
		
		$(document).ready(function() {
			
			$('[name="kegiatan_id"]').on('change', function() {
				$('[name="lokasi_workshop_id"]').html('<option value="">-- Pilih Lokasi --</option>');
				$.getJSON('{site_url('workshop/data-lokasi')}/' + $(this).val(), function(data) {
					$.each(data, function(key, val) {
						$('[name="lokasi_workshop_id"]').append('<option value="' + val.id + '">' + val.kota + ' - ' + val.tempat + ' - ' + val.waktu_pelaksanaan + '</option>');
					});
				});
			});
			
			$('select.set-review').on('change', function() {
				var loading = '<span>Saving...</span>';
				$(this).after(loading);
				
				var $this = $(this);
				
				$.post('{site_url('workshop/set_review')}', {
					peserta_id: $(this).data('id'),
					mode: $(this).data('mode'),
					status: $(this).val()
				}, function(result) {
					if (result === '1') {
						$this.next().hide('fast', function() {
							$(this).remove();
						});
						
						// Jika Pelatihan Ikut, Seminar otomatis ikut
						if ($this.data('mode') === 'pelatihan' && $this.val() === '1') {
							if ($('select.seminar-'+$this.data('id')).val() !== '1') {
								$('select.seminar-'+$this.data('id')).val('1').trigger('change');
							}
						}
						
						// Jika Seminar dibatalkan, Pelatihan yang sudah Ya, dibatalkan
						if ($this.data('mode') === 'seminar' && $this.val() === '0') {
							if ($('select.pelatihan-'+$this.data('id')).val() === '1') {
								$('select.pelatihan-'+$this.data('id')).val('0').trigger('change');
							}
						}
						
						// Update info jumlah peserta seminar
						$.post('{site_url('workshop/get-peserta-seminar')}', {
							lokasi_workshop_id: $('select[name="lokasi_workshop_id"]').val()
						}, function(jumlah) {
							$('#pesertaSeminar').val(jumlah);
						});
						// Update info jumlah peserta pelatihan
						$.post('{site_url('workshop/get-peserta-pelatihan')}', {
							lokasi_workshop_id: $('select[name="lokasi_workshop_id"]').val()
						}, function(jumlah) {
							$('#pesertaPelatihan').val(jumlah);
						});
					}
					else {
						$this.next().html('Error.. Reload halaman.');
						$this.hide();
					}
				});
			});
			
			$('#reviewPesertaWorkshop').DataTable({ 
				ordering : false, 
				stateSave: true,
				autoWidth: false
			});
			
			$('#reviewPesertaWorkshop').show();
			
		});
	</script>
{/block}