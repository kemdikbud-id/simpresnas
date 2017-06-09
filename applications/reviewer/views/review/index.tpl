{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style type="text/css">
		.table-condensed>thead>tr>th,.table-condensed>tbody>tr>td { font-size: 13px; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Review Proposal</h2>

	<div class="row">
		<div class="col-lg-12">

			<form class="form-inline" action="{current_url()}" method="get" style="margin-bottom: 10px">
				<div class="form-group">
					<label for="kegiatan_id">Kegiatan</label>
					<select name="kegiatan_id" class="form-control input-sm">
						<option value="">-- Pilih Kegiatan --</option>
						{html_options options=$kegiatan_option_set selected=$smarty.get.kegiatan_id}
					</select>
				</div>
				<div class="form-group">
					<label for="tahapan_id">Tahapan</label>
					<select name="tahapan_id" class="form-control input-sm">
						<option value="">-- Pilih Tahapan --</option>
						{html_options options=$tahapan_option_set selected=$smarty.get.tahapan_id}
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">Lihat</button>
			</form>
					
			<table class="table table-bordered table-condensed" id="table">
				<thead>
					<tr>
						<th>Judul</th>
						<th>Perguruan Tinggi</th>
						<th>Nilai</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{if isset($data_set)}
						{foreach $data_set as $data}
							<tr>
								<td>{$data->judul}</td>
								<td>{$data->nama_pt}</td>
								<td class="text-center"><strong>{$data->nilai_reviewer}</strong></td>
								<td>
									<a class="btn btn-sm btn-info" href="{site_url('review/penilaian/')}{$data->id}">Nilai</a>{* id = plot_reviewer_id *}
								</td>
							</tr>
						{/foreach}
					{else}
						<tr><td colspan="5">Pilih Kegiatan dan Tahapan</td></tr>
					{/if}
				</tbody>
			</table>
			
		</div>
	</div>
{/block}