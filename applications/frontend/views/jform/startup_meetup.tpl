{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.css')}" />
	<link rel="stylesheet" href="{base_url('assets/select2/css/select2.min.css')}" />
	<style>
		.col-centered {
			float: none;
			margin-right: auto;
			margin-left: auto;
		}
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Pendaftaran Startup Meetup</h2>
	<div class="row">
		<div class="col-md-12">
			
			<form action="{current_url()}" method="post" class="form-horizontal" id="workshopForm" enctype="multipart/form-data">
				
				<fieldset>
				
					<div class="form-group">
						<label class="col-md-3 control-label" for="nama">Nama Lengkap</label>  
						<div class="col-md-5">
							<input type='text' class="form-control input-md" name="nama" required/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label" for="perguruan_tinggi">Perguruan Tinggi</label>
						<div class="col-md-5">
							<select name="perguruan_tinggi_id" class="form-control" style="width: 100%" required>
								<option value=""></option>
								{foreach $pt_set as $pt}
									<option value="{$pt->id}">{$pt->nama_pt}</option>
								{/foreach}
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label" for="program_studi">Program Studi</label>  
						<div class="col-md-5">
							<input type='text' class="form-control input-md" name="program_studi" required/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label" for="nim">NIM</label>  
						<div class="col-md-5">
							<input type='text' class="form-control input-md" name="nim" required/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label" for="angkatan">Angkatan</label>  
						<div class="col-md-2 col-xs-3">
							<input type='text' class="form-control input-md" name="angkatan" maxlength="4" required placeholder="Cth: 2017"/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label" for="email">Email</label>  
						<div class="col-md-5">
							<input type='email' class="form-control input-md" name="email" required/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label" for="no_hp">No HP</label>  
						<div class="col-md-5">
							<input type='text' class="form-control input-md" name="no_hp" required/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label" for="lokasi_workshop_id">Pilihan Lokasi</label>  
						<div class="col-md-5">
							<select name="lokasi_workshop_id" class="form-control" required>
								<option value="">-- Pilih Lokasi --</option>
								{foreach $lokasi_set as $lokasi}
									<option value="{$lokasi->id}">{$lokasi->kota} - {$lokasi->tempat} - {$lokasi->waktu_pelaksanaan}</option>
								{/foreach}
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-5 col-md-offset-3">
							<button class="btn btn-primary" id="submit">Daftar</button>
						</div>
					</div>
					
				</fieldset>
			
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.js')}" type="text/javascript"></script>
	<script src="{base_url('assets/select2/js/select2.min.js')}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('select[name="perguruan_tinggi_id"]').select2();
			
		});
	</script>
{/block}