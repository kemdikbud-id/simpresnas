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
	<h2 class="page-header">Pengisian Buku Profil Kewirausahaan</h2>
    <div class="row">
		<div class="col-lg-12">

			{form_open_multipart(current_url(), ['class'=>'form-horizontal', 'class'=>'form-horizontal', 'id'=>'proposalForm'])}

			<table class="table table-bordered">
				<col style="width: 30px" /><col style="width: 40%" /><col />
				<caption>Profil Unit Pengelola Kewirausahaan Perguruan Tinggi</caption>
				<tbody>
					<tr>
						<td class="text-center">A.</td>
						<td colspan="2">DATA UMUM PERGURUAN TINGGI</td>
					</tr>
					<tr>
						<td></td>
						<td>1. Nama Perguruan Tinggi</td>
						<td class="text-uppercase">{$pt->nama_pt}</td>
					</tr>
					<tr>
						<td></td>
						<td>2. Alamat Perguruan Tinggi</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 40px">a. Jalan</td>
						<td>
							<input type="text" class="form-control" name="alamat_jalan" style="width: 80%" value="{$pt->alamat_jalan}" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 40px">b. Kecamatan</td>
						<td>
							<input type="text" class="form-control" name="alamat_kecamatan" style="width: 50%" value="{$pt->alamat_kecamatan}" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 40px">c. Kabupaten / Kota</td>
						<td>
							<input type="text" class="form-control" name="alamat_kota" style="width: 50%" value="{$pt->alamat_kota}"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 40px">d. Provinsi</td>
						<td>
							<input type="text" class="form-control" name="alamat_provinsi" style="width: 50%" value="{$pt->alamat_provinsi}"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>3. Status</td>
						<td>
							<label class="radio-inline">{form_radio(['name' => 'status_pt', 'value' => 'ptnbh', 'checked' => ($pt->status_pt == 'ptnbh')])} PTNBH</label>
							<label class="radio-inline">{form_radio(['name' => 'status_pt', 'value' => 'blu', 'checked' => ($pt->status_pt == 'blu')])} BLU</label>
							<label class="radio-inline">{form_radio(['name' => 'status_pt', 'value' => 'swasta', 'checked' => ($pt->status_pt == 'swasta')])} Swasta</label>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>4. Jumlah Mahasiswa (2016/2017)</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 20px">a. D1</td>
						<td>
							<input type="text" class="form-control" style="width: 80px" name="jumlah_d1" value="{$pt->jumlah_d1}"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 20px">b. D2</td>
						<td>
							<input type="text" class="form-control" style="width: 80px" name="jumlah_d2" value="{$pt->jumlah_d2}"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 20px">c. D3</td>
						<td>
							<input type="text" class="form-control" style="width: 80px" name="jumlah_d3" value="{$pt->jumlah_d3}"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 20px">d. D4 / S1</td>
						<td>
							<input type="text" class="form-control" style="width: 80px" name="jumlah_d4s1" value="{$pt->jumlah_d4s1}"/>
						</td>
					</tr>
					<tr>
						<td class="text-center">B.</td>
						<td>
							Apakah di PT Bapak/Ibu sdah memiliki unit yang menangani pembinaan kewirausahaan ? <i>Jika “Tidak” langsung ke point D</i>
						</td>
						<td>

							<label class="radio-inline">{form_radio(['name' => 'ada_unit_kewirausahaan', 'value' => '1', 'checked' => ($pt->ada_unit_kewirausahaan == '1')])} Ya</label>
							<label class="radio-inline">{form_radio(['name' => 'ada_unit_kewirausahaan', 'value' => '0', 'checked' => ($pt->ada_unit_kewirausahaan == '0')])} Tidak</label>
						</td>
					</tr>
					<tr>
						<td class="text-center">C.</td>
						<td colspan="2">
							DATA UNIT PEMBINAAN KEWIRAUSAHAAN
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">Direktorat Kemahasiswaan <i>* Harap diisi jika ada</i></td>
					</tr>
					<tr>
						<td></td>
						<td>1. Nama Unit</td>
						<td><input type="text" class="form-control" style="width: 80%" name="nama_unit_1" value="{$uk->nama_unit_1}"/></td>
					</tr>
					<tr>
						<td></td>
						<td>2. Tahun Berdiri</td>
						<td><input type="text" class="form-control" style="width: 80px" name="tahun_berdiri_1" value="{$uk->tahun_berdiri_1}"/></td>
					</tr>
					<tr>
						<td></td>
						<td>3. Alamat Unit / Telp / Email</td>
						<td>
							<textarea class="form-control" rows="2" maxlength="150" style="width: 80%" name="alamat_1">{$uk->alamat_1}</textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">LPPM <i>* Harap diisi jika ada</i></td>
					</tr>
					<tr>
						<td></td>
						<td>1. Nama Unit</td>
						<td><input type="text" class="form-control" style="width: 80%" name="nama_unit_2" value="{$uk->nama_unit_2}"/></td>
					</tr>
					<tr>
						<td></td>
						<td>2. Tahun Berdiri</td>
						<td><input type="text" class="form-control" style="width: 80px" name="tahun_berdiri_2" value="{$uk->tahun_berdiri_2}"/></td>
					</tr>
					<tr>
						<td></td>
						<td>3. Alamat Unit / Telp / Email</td>
						<td>
							<textarea class="form-control" rows="2" maxlength="150" style="width: 80%" name="alamat_2">{$uk->alamat_2}</textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">Lainnya <i>* Harap diisi jika ada</i></td>
					</tr>
					<tr>
						<td></td>
						<td>1. Nama Unit</td>
						<td><input type="text" class="form-control" style="width: 80%" name="nama_unit_3" value="{$uk->nama_unit_3}" /></td>
					</tr>
					<tr>
						<td></td>
						<td>2. Tahun Berdiri</td>
						<td><input type="text" class="form-control" style="width: 80px" name="tahun_berdiri_3" value="{$uk->tahun_berdiri_3}"/></td>
					</tr>
					<tr>
						<td></td>
						<td>3. Alamat Unit / Telp / Email</td>
						<td>
							<textarea class="form-control" rows="2" maxlength="150" style="width: 80%" name="alamat_3">{$uk->alamat_3}</textarea>
						</td>
					</tr>
					<tr>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td></td>
						<td>4. Jumlah Mentor Kewirausahaan</td>
						<td><input type="text" class="form-control" style="width: 80px" name="jumlah_mentor" value="{$uk->jumlah_mentor}"/></td>
					</tr>
					<tr>
						<td></td>
						<td>5. Jumlah Mahasiswa Binaan (2016/2017)</td>
						<td><input type="text" class="form-control" style="width: 80px" name="jumlah_binaan" value="{$uk->jumlah_binaan}"/></td>
					</tr>
					<tr>
						<td></td>
						<td>6. Pernah / tidak mendapatkan dana / terlibat kegiatan Kewirausahaan Belmawa Ristekdikti :</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 20px">a. PMW / KBMI</td>
						<td>
							<label class="radio-inline">{form_radio(['name' => 'pernah_kbmi', 'value' => '1', 'checked' => ($uk->pernah_kbmi == '1')])} Ya</label>
							<label class="radio-inline">{form_radio(['name' => 'pernah_kbmi', 'value' => '0', 'checked' => ($uk->pernah_kbmi == '0')])} Tidak</label>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 20px">b. Workshop / Studium Generale Kewirausahaan Ristekdikti</td>
						<td>
							<label class="radio-inline">{form_radio(['name' => 'pernah_workshop', 'value' => '1', 'checked' => ($uk->pernah_workshop == '1')])} Ya</label>
							<label class="radio-inline">{form_radio(['name' => 'pernah_workshop', 'value' => '0', 'checked' => ($uk->pernah_workshop == '0')])} Tidak</label>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 20px">c. Co-OP / PBBT</td>
						<td>
							<label class="radio-inline">{form_radio(['name' => 'pernah_pbbt', 'value' => '1', 'checked' => ($uk->pernah_pbbt == '1')])} Ya</label>
							<label class="radio-inline">{form_radio(['name' => 'pernah_pbbt', 'value' => '0', 'checked' => ($uk->pernah_pbbt == '0')])} Tidak</label>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 20px">d. KMI Expo</td>
						<td>
							<label class="radio-inline">{form_radio(['name' => 'pernah_expo', 'value' => '1', 'checked' => ($uk->pernah_expo == '1')])} Ya</label>
							<label class="radio-inline">{form_radio(['name' => 'pernah_expo', 'value' => '0', 'checked' => ($uk->pernah_expo == '0')])} Tidak</label>
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 20px">e. Pelatihan Dosen Kewirausahaan</td>
						<td>
							<label class="radio-inline">{form_radio(['name' => 'pernah_pelatihan', 'value' => '1', 'checked' => ($uk->pernah_pelatihan == '1')])} Ya</label>
							<label class="radio-inline">{form_radio(['name' => 'pernah_pelatihan', 'value' => '0', 'checked' => ($uk->pernah_pelatihan == '0')])} Tidak</label>
						</td>
					</tr>
					<tr>
						<td class="text-center">D.</td>
						<td>1. Apakah selama ini pembinaan kewirausahaan melalui kepanitiaan/tim Adhoc ?</td>
						<td>
							<label class="radio-inline">{form_radio(['name' => 'bina_via_adhoc', 'value' => '1', 'checked' => ($uk->bina_via_adhoc == '1')])} Ya</label>
							<label class="radio-inline">{form_radio(['name' => 'bina_via_adhoc', 'value' => '0', 'checked' => ($uk->bina_via_adhoc == '0')])} Tidak</label>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>2. Apakah ada Rencana untuk membentuk unit kewirausahaan, jika ya, kapan ?</td>
						<td>
							<label class="radio-inline">{form_radio(['name' => 'bentuk_unit', 'value' => '1', 'checked' => ($uk->bentuk_unit == '1')])} Ya</label>
							<input type="input" class="form-control" style="display: inline; width: 100px" name="bentuk_unit_ket" value="{$uk->bentuk_unit_ket}" />
							<label class="radio-inline">{form_radio(['name' => 'bentuk_unit', 'value' => '0', 'checked' => ($uk->bentuk_unit == '0')])} Tidak</label>
						</td>
					</tr>
					<tr>
						<td class="text-center">E.</td>
						<td>Apakah di PT Bapak/Ibu ada Mata kuliah khusus tentang kewirausahaan ?</td>
						<td>
							<label class="radio-inline">{form_radio(['name' => 'ada_mk_kwu', 'value' => '1', 'checked' => ($uk->ada_mk_kwu == '1')])} Ya</label>
							<label class="radio-inline">{form_radio(['name' => 'ada_mk_kwu', 'value' => '0', 'checked' => ($uk->ada_mk_kwu == '0')])} Tidak</label>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>Jika Ya, berapa SKS</td>
						<td><input type="text" class="form-control" name="sks_mk_kwu" style="width: 80px" value="{$uk->sks_mk_kwu}"/></td>
					</tr>
					<tr>
						<td class="text-center">F.</td>
						<td>Foto Papan Nama Unit Kewirausahaan</td>
						<td>
							{if $uk->file_papan_nama_1}
								<input type="hidden" name="file_papan_nama_1_remove" value="0" />
								<a href="{base_url('upload/buku-profil')}/{$pt->npsn}/{$uk->file_papan_nama_1}" id="file_papan_nama_1" target="_blank">{$uk->file_papan_nama_1}</a>
								<a href="javascript: setRemoveFile('file_papan_nama_1');" class="text-danger" id="file_papan_nama_1_btn"><i class="glyphicon glyphicon-remove"></i></a>
								<input type="file" class="form-control" name="file_papan_nama_1" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%; display: none" onchange="javascript: setUpdateFile('file_papan_nama_1');" />
							{else}
								<input type="file" class="form-control" name="file_papan_nama_1" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%" />
							{/if}
							{if $uk->file_papan_nama_2}
								<input type="hidden" name="file_papan_nama_2_remove" value="0" />
								<a href="{base_url('upload/buku-profil')}/{$pt->npsn}/{$uk->file_papan_nama_2}" id="file_papan_nama_2" target="_blank">{$uk->file_papan_nama_2}</a>
								<a href="javascript: setRemoveFile('file_papan_nama_2');" class="text-danger" id="file_papan_nama_2_btn"><i class="glyphicon glyphicon-remove"></i></a>
								<input type="file" class="form-control" name="file_papan_nama_2" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%; display: none" onchange="javascript: setUpdateFile('file_papan_nama_2');" />
							{else}
								<input type="file" class="form-control" name="file_papan_nama_2" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%" />
							{/if}
						</td>
					</tr>
					<tr>
						<td></td>
						<td>Foto Kegiatan Kewirausahaan</td>
						<td>
							{if $uk->file_kegiatan_1}
								<input type="hidden" name="file_kegiatan_1_remove" value="0" />
								<a href="{base_url('upload/buku-profil')}/{$pt->npsn}/{$uk->file_kegiatan_1}" id="file_kegiatan_1" target="_blank">{$uk->file_kegiatan_1}</a>
								<a href="javascript: setRemoveFile('file_kegiatan_1');" class="text-danger" id="file_kegiatan_1_btn"><i class="glyphicon glyphicon-remove"></i></a>
								<input type="file" class="form-control" name="file_kegiatan_1" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%; display: none" onchange="javascript: setUpdateFile('file_kegiatan_1');" />
							{else}
								<input type="file" class="form-control" name="file_kegiatan_1" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%" />
							{/if}
							
							{if $uk->file_kegiatan_2}
								<input type="hidden" name="file_kegiatan_2_remove" value="0" />
								<a href="{base_url('upload/buku-profil')}/{$pt->npsn}/{$uk->file_kegiatan_2}" id="file_kegiatan_2" target="_blank">{$uk->file_kegiatan_2}</a>
								<a href="javascript: setRemoveFile('file_kegiatan_2');" class="text-danger" id="file_kegiatan_2_btn"><i class="glyphicon glyphicon-remove"></i></a>
								<input type="file" class="form-control" name="file_kegiatan_2" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%; display: none" onchange="javascript: setUpdateFile('file_kegiatan_2');" />
							{else}
								<input type="file" class="form-control" name="file_kegiatan_2" accept=".jpeg,.jpg,.bmp,.png" style="width: 80%" />
							{/if}
						</td>
					</tr>
				</tbody>
			</table>

			<table class="table table-bordered">
				<col style="width: 30px" /><col style="width: 40%" /><col />
				<caption>Profil Kelompok Mahasiswa Wirausaha Yang Didanai Ristekdikti</caption>
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
				<input type="submit" value="Simpan" class="btn btn-primary" />
			</div>

			{form_close()}

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