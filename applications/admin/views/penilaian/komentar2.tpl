{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style>
		.table>thead>tr>th, .table>tbody>tr>td { font-size: 13px }
		.table>tbody>tr>td:nth-child(5),
		.table>tbody>tr>td:nth-child(6),
		.table>tbody>tr>td:nth-child(7){
			vertical-align: top;
		}
	</style>
{/block}
{block name='container'}container-fluid{/block}
{block name='content'}
	<h2 class="page-header">Hasil Penilaian Proposal (Daftar Komentar)</h2>
	
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
				<div class="form-group">
					<label for="tampilan">Tampilan</label>
					<select name="tampilan" class="form-control input-sm">
						<option value="">Nilai</option>
						<option value="komentar" {if !empty($smarty.get.tampilan)}selected{/if}>Komentar</option>
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">Lihat</button>
			</form>
					
			<table class="table table-bordered table-striped table-condensed" id="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Judul</th>
						<th>Kategori</th>
						<th>Perguruan Tinggi</th>
						<th>R1</th>
						<th>R2</th>
						<th>R3</th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data@index + 1}</td>
							<td>{$data->judul}</td>
							<td>{$data->nama_kategori}</td>
							<td>{$data->nama_pt}</td>
							<td><strong>{$data->reviewer_1}</strong>:<br/>{$data->komentar_1|nl2br}</td>
							<td><strong>{$data->reviewer_2}</strong>:<br/>{$data->komentar_2|nl2br}</td>
							<td><strong>{$data->reviewer_3}</strong>:<br/>{$data->komentar_3|nl2br}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type="text/javascript">
		//$('#table').DataTable({
		//	paging: false
		//});
	</script>
{/block}