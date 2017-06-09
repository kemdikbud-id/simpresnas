{extends file='site_layout.tpl'}
{block name='head'}
	<style>
		h2.page-header { margin-bottom: 0 }
		h4.judul { color: #555555;}
		.table-condensed>thead>tr>th,.table-condensed>tbody>tr>td { font-size: 14px; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">{$data->tahapan}</h2>

	<div class="row">
		<div class="col-lg-12">
			
			<table class="table" style="width: auto; margin-bottom: 10px">
				<tbody>
					<tr>
						<td>Judul :</td>
						<td>{$data->judul}</td>
					</tr>
					<tr>
						<td>File :</td>
						<td>
							
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Kriteria</th>
						<th class="text-center">Bobot</th>
						<th class="text-center">Skor</th>
						<th class="text-center">Nilai</th>
					</tr>
				</thead>
				<tbody>
					{foreach $penilaian_set as $penilaian}
						<tr>
							<td class="text-center">{$penilaian->urutan}</td>
							<td>{$penilaian->kriteria|nl2br}</td>
							<td class="text-center" style="font-size: 18px"><strong>{$penilaian->bobot}</strong></td>
							<td></td>
							<td></td>
						</tr>
					{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" class="text-right">Jumlah</td>
						<td></td>
					</tr>
				</tfoot>
			</table>
			
		</div>
	</div>
{/block}