{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Plotting Reviewer Peserta Workshop</h2>

	<div class="row">
		<div class="col-lg-12">
			
			<form class="form-horizontal" action="{site_url('workshop/plotting/save')}" method="post">
				<legend>Pilih Reviewer</legend>
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="">Jumlah Peserta di Pilih</label>  
					<div class="col-md-1">
						<p class="form-control-static">{count($peserta_ids)}</p>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="reviewer_id">Reviewer</label>
					<div class="col-md-6">
						<select name="reviewer_id" class="form-control" required>
							{foreach $reviewer_set as $reviewer}
								<option value="{$reviewer->id}">{$reviewer->nama} - {$reviewer->asal}</option>
							{/foreach}
						</select>
					</div>
				</div>
						
				<div class="form-group">
					<div class="col-md-2 col-md-offset-3">
						<a href="{site_url('workshop/plotting')}" class="btn btn-default">Kembali</a>
						<input type="submit" value="Simpan" class="btn btn-primary" />
					</div>
				</div>
						
				{foreach $peserta_ids as $peserta_id}
					<input type="hidden" name="peserta_ids[]" value="{$peserta_id}" />
				{/foreach}
				
			</form>
			
		</div>
	</div>
	
{/block}