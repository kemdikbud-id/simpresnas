{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Update User</h2>
	
	<form action="{current_url()}" method="post" class="form-horizontal">
		
		{if isset($result)}
			{if $result}
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Data berhasil disimpan.
				</div>
			{/if}
		{/if}
		
		<div class="form-group">
			<label class="control-label col-lg-2">Program</label>
			<div class="col-lg-6">
				<p class="form-control-static">{$user->program->nama_program_singkat}</p>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-lg-2">Perguruan Tinggi</label>
			<div class="col-lg-6">
				<p class="form-control-static">{$user->perguruan_tinggi->nama_pt}</p>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-lg-2">Email</label>
			<div class="col-lg-6">
				<input type="text" class="form-control" name="email" value="{$user->email}" />
			</div>
		</div>
			
		<div class="form-group">
			<div class="col-lg-4 col-lg-offset-2">
				<a class="btn btn-default" href="{site_url('user')}">Kembali</a>
				<input type="submit" class="btn btn-primary" value="Simpan" />
			</div>
		</div>
		
	</form>
	
{/block}