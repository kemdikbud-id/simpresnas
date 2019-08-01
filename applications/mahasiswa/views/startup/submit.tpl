{extends file='site_layout.tpl'}
{block name='content'}
	<div class="row">
		<div class="col-lg-12">

			<form action="{current_url()}" method="post">
				
				<fieldset>
					<legend><h2>Submit Usulan Startup</h2></legend>
					
					{if isset($error_msg)}
						<div class="alert alert-danger" role="alert">{$error_msg}</div>
					{/if}
					
					{if isset($success_msg)}
						<div class="alert alert-success" role="alert">{$success_msg}</div>
					{/if}
					
					<div class="form-group">
						<h4>Apakah Anda yakin akan melakukan Submit ? Usulan yang akan disubmit tidak bisa di batalkan</h4>
					</div>
					
					{foreach $syarat_set as $syarat}
						
						{if $syarat->is_aktif and $syarat->is_upload}
							
							<div class="form-group fg-view-{$syarat->id}" {if $syarat->file_proposal_id == ''}style="display: none"{/if}>
								<label class="control-label">{$syarat->syarat} {if $syarat->is_wajib}(Wajib){/if}</label>
								<p class="form-control-static">
									<a href="{base_url()}/../../upload/lampiran/{$syarat->nama_file}" target="_blank">{$syarat->nama_file}</a>
								</p>
							</div>
								
						{elseif $syarat->is_aktif and not $syarat->is_upload}
							
							<div class="form-group fg-view-{$syarat->id}" {if $syarat->file_proposal_id == ''}style="display: none"{/if}>
								<label class="control-label">Link {$syarat->syarat} {if $syarat->is_wajib}(Wajib){/if}</label>
								<p class="form-control-static">
									<a href="{$syarat->nama_file}" target="_blank">{$syarat->nama_file}</a>
								</p>
							</div>

						{/if}
						
					{/foreach}
					
					<div class="form-group">
						
						<a href="{site_url('home')}" class="btn btn-default">Kembali</a>
						{if $proposal->is_submited == FALSE}
							<input type="submit" class="btn btn-primary" name="tombol" value="Submit" />
						{/if}
					</div>
					
				</fieldset>
				
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script type="text/javascript">
		$(':file').filestyle();
		
		$('.btn-edit').on('click', function() {
			var syarat_id = $(this).data('id');
			
			$('.fg-view-' + syarat_id).hide();
			$('.fg-upload-' + syarat_id).show();
			
		});
	</script>
{/block}