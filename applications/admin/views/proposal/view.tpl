{extends file='site_layout.tpl'}
{block name='head'}
	<style>.form-group { margin-bottom: 0 }</style>
{/block}
{block name='content'}
	<h2 class="page-header">Detail Proposal</h2>
	<div class="row">
		<div class="col-lg-12">
			<form class="form-horizontal">
				<h4>Info Proposal</h4>
				<div class="form-group">
					<label class="col-md-2 control-label">Judul Proposal</label>
					<div class="col-md-10">
						<p class="form-control-static">{$data->judul}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Ketua</label>
					<div class="col-md-10">
						<p class="form-control-static">{$data->nim_ketua} - {$data->nama_ketua}</p>
					</div>
				</div>
				<h4>File Proposal</h4>
				{foreach $data->file_proposal_set as $file_proposal}
					<div class="form-group">
						<label class="col-md-2 control-label">File</label>
						<div class="col-md-10">
							<p class="form-control-static">{$file_proposal->nama_asli}</p>
						</div>
					</div>
				{/foreach}
				<div class="form-group">
					<label class="col-md-2 control-label"></label>
					<div class="col-md-10">
						{if $data->program_id == 1}
							<a href="{site_url('proposal/index-pbbt')}" class="btn btn-default">Kembali</a>
						{else if $data->program_id == 2}
							<a href="{site_url('proposal/index-kbmi')}" class="btn btn-default">Kembali</a>
						{/if}
					</div>
				</div>
			</form>
		</div>
	</div>
{/block}
