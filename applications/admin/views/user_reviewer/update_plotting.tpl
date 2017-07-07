{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Plotting Reviewer</h2>
	<div class="row">
		<div class="col-lg-12">
			
			{if isset($updated)}
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Update Berhasil !</strong>
				</div>
			{/if}
			
			<form class="form-horizontal" method="post" action="{current_url()}">
				<div class="form-group">
					<label class="col-md-2 control-label">Judul Proposal</label>
					<div class="col-md-10">
						<p class="form-control-static">{$data->judul}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Perguruan Tinggi</label>
					<div class="col-md-10">
						<p class="form-control-static">{$data->nama_pt}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Reviewer 1</label>
					<div class="col-md-10">
						<select name="reviewer_id[1]" class="form-control">
							<option value="">-- Pilih Reviewer --</option>
							{html_options options=$reviewer_option_set selected=$reviewer_1->reviewer_id}
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Reviewer 2</label>
					<div class="col-md-10">
						<select name="reviewer_id[2]" class="form-control">
							<option value="">-- Pilih Reviewer --</option>
							{html_options options=$reviewer_option_set selected=$reviewer_2->reviewer_id}
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Reviewer 3</label>
					<div class="col-md-10">
						<select name="reviewer_id[3]" class="form-control">
							<option value="">-- Pilih Reviewer --</option>
							{html_options options=$reviewer_option_set selected=$reviewer_3->reviewer_id}
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-10">
						<button type="submit" class="btn btn-primary">Simpan</button>
						<a href="{site_url('user-reviewer/plotting/')}?kegiatan_id={$data->kegiatan_id}&tahapan_id={$data->tahapan_id}" class="btn btn-default">Kembali</a>
					</div>
				</div>
			</form>
			
		</div>
	</div>
{/block}