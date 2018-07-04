{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Export PDF</h1>
	
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Jenis PDF</th>
				<th>Status File</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Buku Profil Kewirausahaan Dibiayai Ristekdikti</td>
				<td>
					{if $status_file_1}
						<a href="{base_url()}../download/buku-profil-ristekdikti.pdf" target="_blank" class="btn btn-danger"><i class="glyphicon glyphicon-download-alt"></i> Download</a>
						<a href="{site_url('buku-profil/export-pdf?generate-pdf-1')}" class="btn btn-success"><i class="glyphicon glyphicon-file"></i> Generate Ulang PDF</a>
					{else}
						{if $status_generate_1}
							Proses generate...
						{else}
							<a href="{site_url('buku-profil/export-pdf?generate-pdf-1')}" class="btn btn-success"><i class="glyphicon glyphicon-file"></i> Generate PDF</a>
						{/if}
					{/if}
				</td>
			</tr>
			<tr>
				<td>Buku Profil Kewirausahaan Dibiayai Non-Ristekdikti</td>
				<td>
					{if $status_file_2}
						<a href="{base_url()}../download/buku-profil-non-ristekdikti.pdf" target="_blank" class="btn btn-danger"><i class="glyphicon glyphicon-download-alt"></i> Download</a>
						<a href="{site_url('buku-profil/export-pdf?generate-pdf-2')}" class="btn btn-success"><i class="glyphicon glyphicon-file"></i> Generate Ulang PDF</a>
					{else}
						{if $status_generate_2}
							Proses generate...
						{else}
							<a href="{site_url('buku-profil/export-pdf?generate-pdf-2')}" class="btn btn-success"><i class="glyphicon glyphicon-file"></i> Generate PDF</a>
						{/if}
					{/if}
				</td>
			</tr>
		</tbody>
	</table>
				
	<p>* refresh halaman untuk mengetahui proses generate pdf sudah selesai / belum</p>
	<p>** Proses generate PDF bisa terjadi hingga beberapa menit.</p>
	
{/block}