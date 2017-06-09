{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Review Proposal</h2>

	<form class="form-inline" method="get" action="{current_url()}">
		<div class="form-group">
			<label for="kegiatan_id">Kegiatan</label>
			<select name="kegiatan_id" class="form-control input-sm"></select>
		</div>
		<button type="submit" class="btn btn-sm btn-default">View</button>
	</form>

	<div class="row">
		<div class="col-lg-12">

		</div>
	</div>
{/block}