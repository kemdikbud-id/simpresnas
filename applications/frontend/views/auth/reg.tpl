{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Registrasi Akun SIM-PKMI</h2>
	<div class="row">
		<div class="col-md-12">

			<form action="{current_url()}" method="post" class="form-horizontal">

				<!-- Multiple Radios -->
				<div class="form-group">
					<label class="col-md-3 control-label" for="radios">Program</label>
					<div class="col-md-4">
						<div class="radio">
							<label for="radios-0">
								<input name="radios" id="radios-0" value="1" type="radio">PBBT
							</label>
						</div>
						<div class="radio">
							<label for="radios-1">
								<input name="radios" id="radios-1" value="2" type="radio">PKMI
							</label>
						</div>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="pt">Perguruan Tinggi</label>  
					<div class="col-md-5">
						<input name="pt" placeholder="Nama perguruan tinggi" class="form-control input-md" type="text">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="unit_pengusul">Nama Unit</label>  
					<div class="col-md-5">
						<input name="unit_pengusul" class="form-control input-md" type="text">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="nama_pengusul">Nama Pengusul</label>  
					<div class="col-md-5">
						<input name="nama_pengusul" class="form-control input-md" type="text">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="jabatan_pengusul">Jabatan Pengusul</label>  
					<div class="col-md-5">
						<input name="jabatan_pengusul" class="form-control input-md" type="text">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="kontak_pengusul">Kontak</label>  
					<div class="col-md-3">
						<input name="kontak_pengusul" class="form-control input-md" type="text">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="email">Email</label>  
					<div class="col-md-5">
						<input name="email" class="form-control input-md" type="email">
						<span class="help-block">
							<span class="text-danger">Email resmi unit/lembaga yg akan digunakan untuk menerima login akun.
								<strong>Tidak Boleh</strong> menggunakan email pribadi / email dosen
							</span>
						</span> 
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="email">Scan Surat Permintaan Akun User</label>  
					<div class="col-md-5">
						<input name="surat" class="form-control input-md" type="file">
					</div>
				</div>

				<!-- Button -->
				<div class="form-group">
					<label class="col-md-3 control-label" for="singlebutton"></label>
					<div class="col-md-4">
						<button name="submit" class="btn btn-primary">Daftar</button>
					</div>
				</div>

			</form>

		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script>
		$(':file').filestyle();
	</script>
{/block}