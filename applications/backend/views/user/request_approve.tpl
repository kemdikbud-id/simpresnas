{extends file='site_layout.tpl'}
{block name='head'}
	<link rel='stylesheet' href="{base_url('../assets/select2/css/select2.min.css')}" />
{/block}
{block name='content'}
	<h2 class="page-header">Daftar User Request</h2>

	<div class="row">
		<div class="col-lg-6">

			<form class="form-horizontal" action="{current_url()}?{$smarty.server.QUERY_STRING}" method="post">
				<fieldset>

					<!-- Form Name -->
					<legend>Buat User Baru</legend>

					<!-- Label Info -->
					<div class="form-group">
						<label class="col-md-3 control-label" for="selectbasic">Program</label>
						<div class="col-md-9">
							<p class="form-control-static">{$program->nama_program}</p>
						</div>
					</div>

					<!-- Label Info -->
					<div class="form-group">
						<label class="col-md-3 control-label" for="selectbasic">PT Pengusul</label>
						<div class="col-md-9">
							<p class="form-control-static">{$data->perguruan_tinggi}</p>
						</div>
					</div>

					<!-- Label Info -->
					<div class="form-group">
						<label class="col-md-3 control-label">Nama Pengusul</label>
						<div class="col-md-9">
							<p class="form-control-static">{$data->nama_pengusul} - {$data->kontak_pengusul}</p>
						</div>
					</div>

					<!-- Label Info -->
					<div class="form-group">
						<label class="col-md-3 control-label">Email Lembaga Pengusul</label>
						<div class="col-md-9">
							<p class="form-control-static"><samp>{$data->email}</samp></p>
							<p class="help-block"><span class="text-warning">Pastikan email yang disini bukan email pribadi</span></p>
						</div>
					</div>

					<!-- Select Basic -->
					<div class="form-group">
						<label class="col-md-3 control-label" for="selectbasic">Perguruan Tinggi</label>
						<div class="col-md-9">
							<p class="form-control-static">
								{* tampilkan jika ada yang match *}
								{if count($pt_set) > 0}
									<select id="perguruan_tinggi_id" name="perguruan_tinggi_id" class="form-control">
										{foreach $pt_set as $pt}
											<option value="{$pt->id}">[{$pt->npsn}] {$pt->nama_pt}</option>
										{/foreach}
									</select>
								{else}
									<select id="perguruan_tinggi_id" name="perguruan_tinggi_id" class="form-control"></select>
									<span class="help-block">Perguruan tinggi tidak ada match, silahkan pilih yang sesuai.</span>
								{/if}
							</p>
						</div>
					</div>

					<!-- Button -->
					<div class="form-group">
						<label class="col-md-3 control-label" for="singlebutton"></label>
						<div class="col-md-9">
							<a href="{site_url('user/request')}" class="btn btn-default">Batal</a>
							<input type="submit" class="btn btn-primary" value="Kirim Info User" />
						</div>
					</div>

				</fieldset>
			</form>
		</div>

		<div class="col-lg-6">
			<object type="application/pdf" width="100%" height="400px" data="{base_url("../upload/request-user/{$data->nama_file}")}">
				<p>File PDF tidak bisa ditampilkan</p>
			</object>
		</div>
	</div>
{/block}

{block name="footer-script"}
	<script type="text/javascript" src="{base_url('../assets/select2/js/select2.min.js')}"></script>
	<script type="text/javascript">
		{if count($pt_set) == 0}
			$('#perguruan_tinggi_id').select2({
				placeholder: 'Pilih Perguruan Tinggi',
				allowClear: true,
				ajax: {
					url: "{site_url('user/find-pt-for-select2/')}",
					dataType: 'json',
					delay: 200,
					data: function (params) {
						return {
							q: params.term, // search term
							page: params.page
						};
					},
					processResults: function (data, params) {
						params.page = params.page || 1;
						return {
							results: data.items,
							pagination: { 
								more: (params.page * 30) < data.total_count 
							}
						};
					},
					cache: true
				},
				escapeMarkup: function (markup) {
					return markup;
				},
				minimumInputLength: 5,
				templateResult: function(item) {
					return item.nama_pt;
				},
				templateSelection: function(item) {
					return item.nama_pt;
				}
			});
		{/if}
	</script>
{/block}