{extends file='site_layout.tpl'}
{block name='header'}
{/block}
{block name='content'}
	<h1 class="page-header">Update Kegiatan</h1>

	<div class="row">
		<div class="col-lg-12">

			<form class="form-horizontal" action="{current_url()}" method="post">
				<input type="hidden" name="id" value="{$data->id}" />
				<fieldset>

					<!-- Label-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="proposal_per_pt">Program</label>  
						<div class="col-md-5">
							<label class="form-control-static">{$data->nama_program} Tahun {$data->tahun}</label>
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="proposal_per_pt">Jumlah Proposal</label>  
						<div class="col-md-1">
							<input id="proposal_per_pt" name="proposal_per_pt" placeholder="" class="form-control input-md" type="text" value="{set_value('proposal_per_pt', $data->proposal_per_pt)}">
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tgl_awal_upload">Tanggal Awal Upload</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="awal_upload_" time=$data->tgl_awal_upload all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="awal_upload_HMS" value="{$data->tgl_awal_upload|date_format:"%H:%M:%S"}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tgl_akhir_upload">Tanggal Akhir Upload</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="akhir_upload_" time=$data->tgl_akhir_upload all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="akhir_upload_HMS" value="{$data->tgl_akhir_upload|date_format:"%H:%M:%S"}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tgl_awal_review">Tanggal Awal Review</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="awal_review_" time=$data->tgl_awal_review all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="awal_review_HMS" value="{$data->tgl_awal_review|date_format:"%H:%M:%S"}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tgl_akhir_review">Tanggal Akhir Review</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="akhir_review_" time=$data->tgl_akhir_review all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="akhir_review_HMS" value="{$data->tgl_akhir_review|date_format:"%H:%M:%S"}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tgl_pengumuman">Tanggal Pengumuman</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="pengumuman_" time=$data->tgl_pengumuman all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="pengumuman_HMS" value="{$data->tgl_pengumuman|date_format:"%H:%M:%S"}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Button -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="singlebutton"></label>
						<div class="col-md-4">
							<a href="{site_url('kegiatan')}" class="btn btn-default">Kembali</a>
							<input type="submit" value="Simpan" class="btn btn-primary"/>
						</div>
					</div>

				</fieldset>
			</form>

		</div>
	</div>
{/block}
{block name='footer-script'}

{/block}