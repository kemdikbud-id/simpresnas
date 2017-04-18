{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Daftar User Request</h1>

	<div class="row">
		<div class="col-md-12">

			<form class="form-horizontal" action="{current_url()}?{$smarty.server.QUERY_STRING}" method="post">
				<fieldset>

					<!-- Form Name -->
					<legend>Buat User Baru</legend>
					
					<!-- Label Info -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="selectbasic">Program</label>
						<div class="col-md-5">
							<p class="form-control-static">{$program->nama_program}</p>
						</div>
					</div>
					
					<!-- Label Info -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="selectbasic">PT Pengusul</label>
						<div class="col-md-5">
							<p class="form-control-static">{$data->perguruan_tinggi}</p>
						</div>
					</div>
						
					<!-- Label Info -->
					<div class="form-group">
						<label class="col-md-2 control-label">Nama Pengusul</label>
						<div class="col-md-5">
							<p class="form-control-static">{$data->nama_pengusul} - {$data->kontak_pengusul}</p>
						</div>
					</div>
						
					<!-- Label Info -->
					<div class="form-group">
						<label class="col-md-2 control-label">Email Lembaga Pengusul</label>
						<div class="col-md-5">
							<p class="form-control-static"><samp>{$data->email}</samp></p>
							<p class="help-block"><span class="text-warning">Pastikan email yang disini bukan email pribadi</span></p>
						</div>
					</div>

					<!-- Select Basic -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="selectbasic">Perguruan Tinggi</label>
						<div class="col-md-5">
							<select id="perguruan_tinggi_id" name="perguruan_tinggi_id" class="form-control">
								{foreach $pt_set as $pt}
								<option value="{$pt->id}">[{$pt->npsn}] {$pt->nama_pt}</option>
								{/foreach}
							</select>
						</div>
					</div>

					<!-- Button -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="singlebutton"></label>
						<div class="col-md-4">
							<a href="{site_url('user/request')}" class="btn btn-default">Batal</a>
							<input type="submit" class="btn btn-primary" value="Kirim Info User" />
						</div>
					</div>

				</fieldset>
			</form>


		</div>
	</div>
{/block}