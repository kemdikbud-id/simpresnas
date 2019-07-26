{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Hapus Usulan Startup</h2>
	<div class="row">
		<div class="col-lg-12">
			
			<form action="{current_url()}" method="post" class="form-horizontal">
				<input type="hidden" name="proposal_id" value="{$proposal->id}" />
				<fieldset>
					
					<div class="alert alert-danger">
						<p>Apakah data ini akan dihapus ?</p>
						<p>{$proposal->judul}</p>
					</div>

					<div class="form-group">
						<div class="col-lg-4">
							<a href="{site_url('proposal-kbmi/index')}" class="btn btn-default">Kembali</a>
							<button class="btn btn-danger">Hapus</button>
						</div>
					</div>

				</fieldset>
			</form>
			
		</div>
	</div>
{/block}