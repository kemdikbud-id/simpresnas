{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Jadwal Workshop Kewirausahaan</h2>
    <div class="row">
		<div class="col-lg-12">
			{foreach $kegiatan_set as $kegiatan}
				<h4>Jadwal Kegiatan &amp; Lokasi {$kegiatan->nama_program} {$kegiatan->tahun}</h4>
				
				<table class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Kota</th>
							<th>Tempat</th>
							<th>Waktu</th>
						</tr>
					</thead>
					<tbody>
						{foreach $kegiatan->lokasi_set as $lokasi}
							<tr>
								<td>{$lokasi@index + 1}</td>
								<td>{$lokasi->kota}</td>
								<td>{$lokasi->tempat}</td>
								<td>{$lokasi->waktu_pelaksanaan|date_format:"%d %B %Y"}</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			{/foreach}
		</div>
	</div>
{/block}