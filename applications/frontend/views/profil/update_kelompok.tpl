{extends file='site_layout.tpl'}
{block name='head'}
	<style type="text/css">
		.table>caption { color: #317eac; font-weight: bold; font-size: 1.2em; }
		.table>tbody>tr>td { padding: 4px; }
		.table>tbody>tr>td:nth-child(3)>input.form-control, .table>tbody>tr>td:nth-child(3)>select.form-control,
		.table>tbody>tr>td:nth-child(3)>label.checkbox-inline>input.form-control,
		.table>tbody>tr>td:nth-child(3)>label.radio-inline>input.form-control { height: 30px; padding: 4px 8px; }
		.table>tbody>tr>td:nth-child(3)>label.radio-inline,
		.table>tbody>tr>td:nth-child(3)>label.checkbox-inline { padding-top: 0; }
		.table>tbody>tr>td>input[type=file] { margin-bottom: 10px }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Update Kelompok Mahasiswa Wirausaha yang didanai {if $is_kemenristek}Ristekdikti{else}Non-Ristekdikti{/if} - Kelompok {$kelompok}</h2>
	
	<div class="row">
		<div class="col-lg-12">
			
			<form action="{current_url()}?{$smarty.server.QUERY_STRING}" class="form-horizontal" id="proposalForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				
				<table class="table table-bordered">
					<col style="width: 30px" /><col style="width: 40%" /><col />
					<caption>Profil Kelompok Mahasiswa Wirausaha Yang Didanai {if $is_kemenristek}Ristekdikti{else}Non-Ristekdikti{/if}</caption>
					<tbody>
						<tr>
							<td class="text-center">A.</td>
							<td>Identitas Pendiri</td>
							<td></td>
						</tr>
						<tr>
							<td></td><td colspan="2">Ketua</td>
						</tr>
						<tr>
							<td></td><td>1. Nama</td>
							<td><input type="text" class="form-control" name="nama_ketua" style="width: 80%" value="{$pku->nama_ketua}"/></td>
						</tr>
						<tr>
							<td></td><td>2. NIM</td>
							<td><input type="text" class="form-control" name="nim_ketua" style="width: 150px" value="{$pku->nim_ketua}"/></td>
						</tr>
						<tr>
							<td></td><td>3. Jurusan</td>
							<td><input type="text" class="form-control" name="prodi_ketua" style="width: 50%" value="{$pku->prodi_ketua}"/></td>
						</tr>
						<tr>
							<td></td><td>4. Email</td>
							<td><input type="text" class="form-control" name="email_ketua" style="width: 50%" value="{$pku->email_ketua}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>5. HP</td>
							<td><input type="text" class="form-control" name="hp_ketua" style="width: 50%" value="{$pku->hp_ketua}"/></td>
						</tr>
						<tr>
							<td></td><td colspan="2">Anggota 1</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Nama</td>
							<td><input type="text" class="form-control" name="nama_anggota_1" style="width: 80%" value="{$pku->nama_anggota_1}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>2. NIM</td>
							<td><input type="text" class="form-control" name="nim_anggota_1" style="width: 150px" value="{$pku->nim_anggota_1}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>3. Jurusan</td>
							<td><input type="text" class="form-control" name="prodi_anggota_1" style="width: 50%" value="{$pku->prodi_anggota_1}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>4. Email</td>
							<td><input type="text" class="form-control" name="email_anggota_1" style="width: 50%" value="{$pku->email_anggota_1}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>5. HP</td>
							<td><input type="text" class="form-control" name="hp_anggota_1" style="width: 50%" value="{$pku->hp_anggota_1}"/></td>
						</tr>
						<tr>
							<td></td><td colspan="2">Anggota 2</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Nama</td>
							<td><input type="text" class="form-control" name="nama_anggota_2" style="width: 80%" value="{$pku->nama_anggota_2}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>2. NIM</td>
							<td><input type="text" class="form-control" name="nim_anggota_2" style="width: 150px" value="{$pku->nim_anggota_2}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>3. Jurusan</td>
							<td><input type="text" class="form-control" name="prodi_anggota_2" style="width: 50%" value="{$pku->prodi_anggota_2}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>4. Email</td>
							<td><input type="text" class="form-control" name="email_anggota_2" style="width: 50%" value="{$pku->email_anggota_2}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>5. HP</td>
							<td><input type="text" class="form-control" name="hp_anggota_2" style="width: 50%" value="{$pku->hp_anggota_2}"/></td>
						</tr>
						<tr>
							<td></td><td colspan="2">Anggota 3</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Nama</td>
							<td><input type="text" class="form-control" name="nama_anggota_3" style="width: 80%" value="{$pku->nama_anggota_3}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>2. NIM</td>
							<td><input type="text" class="form-control" name="nim_anggota_3" style="width: 150px" value="{$pku->nim_anggota_3}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>3. Jurusan</td>
							<td><input type="text" class="form-control" name="prodi_anggota_3" style="width: 50%" value="{$pku->prodi_anggota_3}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>4. Email</td>
							<td><input type="text" class="form-control" name="email_anggota_3" style="width: 50%" value="{$pku->email_anggota_3}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>5. HP</td>
							<td><input type="text" class="form-control" name="hp_anggota_3" style="width: 50%" value="{$pku->hp_anggota_3}"/></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2">Anggota 4</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Nama</td>
							<td><input type="text" class="form-control" name="nama_anggota_4" style="width: 80%" value="{$pku->nama_anggota_4}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>2. NIM</td>
							<td><input type="text" class="form-control" name="nim_anggota_4" style="width: 150px" value="{$pku->nim_anggota_4}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>3. Jurusan</td>
							<td><input type="text" class="form-control" name="prodi_anggota_4" style="width: 50%" value="{$pku->prodi_anggota_4}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>4. Email</td>
							<td><input type="text" class="form-control" name="email_anggota_4" style="width: 50%" value="{$pku->email_anggota_4}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>5. HP</td>
							<td><input type="text" class="form-control" name="hp_anggota_4" style="width: 50%" value="{$pku->hp_anggota_4}"/></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2">Anggota 5</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Nama</td>
							<td><input type="text" class="form-control" name="nama_anggota_5" style="width: 80%" value="{$pku->nama_anggota_5}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>2. NIM</td>
							<td><input type="text" class="form-control" name="nim_anggota_5" style="width: 150px" value="{$pku->nim_anggota_5}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>3. Jurusan</td>
							<td><input type="text" class="form-control" name="prodi_anggota_5" style="width: 50%" value="{$pku->prodi_anggota_5}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>4. Email</td>
							<td><input type="text" class="form-control" name="email_anggota_5" style="width: 50%" value="{$pku->email_anggota_5}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>5. HP</td>
							<td><input type="text" class="form-control" name="hp_anggota_5" style="width: 50%" value="{$pku->hp_anggota_5}"/></td>
						</tr>
						<tr>
							<td></td>
							<td>Bidang Bisnis</td>
							<td>
								<select name="kategori_id" class="form-control" style="width: 50%">
									<option value=""></option>
									{html_options options=$kategori_set selected=$pku->kategori_id}
								</select>
							</td>
						</tr>
						{if $is_kemenristek}
							<tr>
								<td></td>
								<td>Sumber Pendanaan</td>
								<td>
									<select name="sumber_pendanaan" class="form-control" style="width: 50%">
										<option value=""></option>
										<option value="KBMI" {if $pku->sumber_pendanaan == 'KBMI'}selected{/if}>KBMI</option>
										<option value="PMW" {if $pku->sumber_pendanaan == 'PMW'}selected{/if}>PMW</option>
										<option value="PBBT" {if $pku->sumber_pendanaan == 'PBBT'}selected{/if}>PBBT</option>
										<option value="Co-OP" {if $pku->sumber_pendanaan == 'Co-OP'}selected{/if}>Co-OP</option>
									</select>
								</td>
							</tr>
						{else}
							<tr>
								<td></td>
								<td>Sumber Pendanaan</td>
								<td>
									<input type="text" class="form-control" name="sumber_pendanaan" value="{$pku->sumber_pendanaan}" />
								</td>
							</tr>
						{/if}
						<tr>
							<td class="text-center">C.</td>
							<td>Nama Produk</td>
							<td>
								<input type="text" class="form-control" name="nama_produk" style="width: 80%" value="{$pku->nama_produk}"/>
							</td>
						</tr>
						<tr>
							<td class="text-center">D.</td>
							<td>Gambaran Bisnis</td>
							<td>
								<textarea rows="3" class="form-control" name="gambaran_bisnis" style="width: 80%">{$pku->gambaran_bisnis}</textarea>
							</td>
						</tr>
						<tr>
							<td class="text-center">E.</td>
							<td>Capaian Bisnis</td>
							<td>
								<textarea rows="3" class="form-control" name="capaian_bisnis" style="width: 80%">{$pku->capaian_bisnis}</textarea>
							</td>
						</tr>
						<tr>
							<td class="text-center">F.</td>
							<td>Rencana Kedepan</td>
							<td>
								<textarea rows="3" class="form-control" name="rencana_kedepan" style="width: 80%">{$pku->rencana_kedepan}</textarea>
							</td>
						</tr>
						<tr>
							<td class="text-center">G.</td>
							<td>Prestasi Bisnis</td>
							<td>
								<textarea rows="3" class="form-control" name="prestasi_bisnis" style="width: 80%">{$pku->prestasi_bisnis}</textarea>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>Foto Anggota Kelompok</td>
							<td>
								{if $pku->file_anggota}
									<input type="hidden" name="file_anggota_remove" value="0" />
									<a href="{base_url('upload/buku-profil')}/{$pt->npsn}/{$pku->file_anggota}" id="file_anggota" target="_blank">{$pku->file_anggota}</a>
									<a href="javascript: setRemoveFile('file_anggota');" class="text-danger" id="file_anggota_btn"><i class="glyphicon glyphicon-remove"></i></a>
									<input type="file" class="form-control" name="file_anggota" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%; display: none" onchange="javascript: setUpdateFile('file_anggota');" />
								{else}
									<input type="file" class="form-control" name="file_anggota" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%" />
								{/if}
							</td>
						</tr>
						<tr>
							<td></td>
							<td>Foto Usaha / Produk</td>
							<td>
								{if $pku->file_produk}
									<input type="hidden" name="file_produk_remove" value="0" />
									<a href="{base_url('upload/buku-profil')}/{$pt->npsn}/{$pku->file_produk}" id="file_produk" target="_blank">{$pku->file_produk}</a>
									<a href="javascript: setRemoveFile('file_produk');" class="text-danger" id="file_produk_btn"><i class="glyphicon glyphicon-remove"></i></a>
									<input type="file" class="form-control" name="file_produk" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%; display: none" onchange="javascript: setUpdateFile('file_produk');" />
								{else}
									<input type="file" class="form-control" name="file_produk" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%" />
								{/if}
							</td>
						</tr>
					</tbody>
				</table>
				
				<div class="text-center">
					<a href="{site_url('profil')}" class="btn btn-default">Kembali</a>
					<input type="submit" value="Simpan" class="btn btn-primary" />
				</div>
					
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script type="text/javascript">
		function setRemoveFile(name) {
			$('#' + name).remove();
			$('#' + name + '_btn').remove();
			$('input[name="'+name+'"]').show(); // tampilkan
			$('input[name="'+name+'_remove"]').val('1');
		}
		
		function setUpdateFile(name) {
			$('input[name="'+name+'_remove"]').val('0');
		}
	</script>
{/block}