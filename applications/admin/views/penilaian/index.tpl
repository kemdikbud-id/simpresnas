{extends file='site_layout.tpl'}
{block name='head'}
	<style>.table>thead>tr>th, .table>tbody>tr>td { font-size: 13px }</style>
{/block}
{block name='content'}
	<h2 class="page-header">Hasil Penilaian Proposal</h2>
	
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
					
			<table class="table table-bordered table-striped table-condensed" id="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Judul</th>
						<th>Perguruan Tinggi</th>
						<th>R1</th>
						<th>R2</th>
						<th>Rekom R1</th>
						<th>Rekom R2</th>
						<th>Nilai R1</th>
						<th>Nilai R2</th>
						<th>Selisih</th>
						<th>Rata</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data@index + 1}</td>
							<td>{$data->judul}</td>
							<td>{$data->nama_pt}</td>
							<td>{$data->reviewer_1}</td>
							<td>{$data->reviewer_2}</td>
							<td class="text-right">{$data->biaya_rekomendasi_1|number_format:0:",":"."}</td>
							<td class="text-right">{$data->biaya_rekomendasi_2|number_format:0:",":"."}</td>
							<td class="text-center">{$data->nilai_reviewer_1}</td>
							<td class="text-center">{$data->nilai_reviewer_2}</td>
							<td class="text-center">{$data->nilai_selisih}</td>
							<td class="text-center">{$data->nilai_rata}</td>
							<td class="text-center">{$data->nilai_total}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			
		</div>
	</div>
{/block}