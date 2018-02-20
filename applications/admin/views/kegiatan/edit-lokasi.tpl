{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Edit Lokasi Workshop</h1>

	<div class="row">
		<div class="col-lg-12">
			
			<form class="form-horizontal" method="post" action="{current_url()}" id="addLokasiForm">
				<fieldset>
					
					<!-- Static -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="kegiatan">Kegiatan</label>  
						<div class="col-md-4">
							<p class="form-control-static">{$kegiatan->nama_program} {$kegiatan->tahun}</p>
						</div>
					</div>
						
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="kota">Kota</label>  
						<div class="col-md-3">
							<input id="kota" name="kota" placeholder="" class="form-control input-md" type="text" value="{$data->kota}">
						</div>
					</div>
					
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tempat">Tempat</label>  
						<div class="col-md-4">
							<input id="tempat" name="tempat" placeholder="" class="form-control input-md" type="text" value="{$data->tempat}">
						</div>
					</div>
					
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="waktu_pelaksanaan">Waktu Pelaksanaan</label>  
						<div class="col-md-4">
							{html_select_date field_order="DMY" prefix="waktu_pelaksanaan_" time=$data->waktu_pelaksanaan all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
						</div>
					</div>
						
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tgl_awal_registrasi">Awal Registrasi</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="awal_registrasi_" time=$data->tgl_awal_registrasi all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="awal_registrasi_time" value="{$data->tgl_awal_registrasi|date_format:'%H:%M:%S'}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tgl_akhir_registrasi">Akhir Registrasi</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="akhir_registrasi_" time=$data->tgl_akhir_registrasi all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="akhir_registrasi_time" value="{$data->tgl_akhir_registrasi|date_format:'%H:%M:%S'}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>
							
					<!-- Button -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="singlebutton"></label>
						<div class="col-md-4">
							<a href="{site_url('kegiatan/lokasi')}?kegiatan_id={$data->kegiatan_id}" class="btn btn-default">Kembali</a>
							<input type="submit" value="Simpan" class="btn btn-primary"/>
							<input type="hidden" name="kegiatan_id" value="{$data->kegiatan_id}" />
						</div>
					</div>
						
				</fieldset>
			</form>
			
		</div>
	</div>
{/block}