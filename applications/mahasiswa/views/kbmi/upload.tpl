{extends file='site_layout.tpl'}
{block name='content'}
	<div class="panel panel-default">
		<div class="panel-body">
			
			<form action="{current_url()}" method="post" enctype="multipart/form-data">
				
				<fieldset>
					<legend class="text-center"><h2>Unggah Berkas Pendukung</h2></legend>
					
					{foreach $syarat_set as $syarat}
						{if $syarat->is_aktif}
							{if $syarat->file_proposal_id == ''}
								<div class="form-group {if isset($syarat->upload_error_msg)}has-error{/if}">
									<label class="control-label">{$syarat->syarat} {if $syarat->is_wajib}(Wajib){/if}</label>
									<input type="file" name="file_syarat_{$syarat->id}" class="filestyle" />
									<span class="help-block">{$syarat->keterangan} ({$syarat->allowed_types}) - Maks. {$syarat->max_size}MB</span>
									{if isset($syarat->upload_error_msg)}
										<span class="help-block">ERROR: {$syarat->upload_error_msg}</span>
									{/if}
								</div>
							{else}
								<div class="form-group">
									<label class="control-label">{$syarat->syarat} {if $syarat->is_wajib}(Wajib){/if}</label>
									<p class="form-control-static"><a href="{base_url()}/../../upload/lampiran/{$syarat->nama_file}" target="_blank">{$syarat->nama_file}</a></p>
								</div>
							{/if}
						{/if}
					{/foreach}
					
					<div class="form-group">
						<div class="col-lg-5">
							<input type="submit" class="btn btn-primary" name="tombol" value="Sebelumnya" />
						</div>
						<div class="col-lg-2 text-center">
							<input type="submit" class="btn btn-info" name="tombol" value="Unggah" />
						</div>
						<div class="col-lg-5 text-right">
							<input type="submit" class="btn btn-primary" name="tombol" value="Berikutnya" />
						</div>
					</div>
					
				</fieldset>
				
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script>
		$(':file').filestyle();
	</script>
{/block}