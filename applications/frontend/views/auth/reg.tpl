{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Registrasi Akun SIM-PKMI</h2>
	<div class="row">
		<div class="col-md-12">

			<form action="{current_url()}" method="post" class="form-horizontal" id="signupForm" enctype="multipart/form-data">

				<!-- Multiple Radios -->
				<div class="form-group">
					<label class="col-md-3 control-label" for="program_id">Program</label>
					<div class="col-md-1">
						<div class="radio">
							<label for="program_id-0">
								<input name="program_id" id="program_id-0" value="1" type="radio" {set_radio('program_id', '1')}>PBBT
							</label>
						</div>
					</div>
					<div class="col-md-1">
						<div class="radio">
							<label for="program_id-1">
								<input name="program_id" id="program_id-1" value="2" type="radio" {set_radio('program_id', '2')}>PKMI
							</label>
						</div>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="perguruan_tinggi">Perguruan Tinggi</label>  
					<div class="col-md-5">
						<input id="perguruan_tinggi" name="perguruan_tinggi" placeholder="Nama perguruan tinggi" class="form-control input-md" type="text" value="{set_value('perguruan_tinggi')}">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="unit_lembaga">Nama Unit</label>  
					<div class="col-md-5">
						<input id="unit_pengusul" name="unit_lembaga" class="form-control input-md" type="text" value="{set_value('unit_lembaga')}">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="nama_pengusul">Nama Pengusul</label>  
					<div class="col-md-5">
						<input id="nama_pengusul" name="nama_pengusul" class="form-control input-md" type="text" value="{set_value('nama_pengusul')}">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="jabatan_pengusul">Jabatan Pengusul</label>  
					<div class="col-md-5">
						<input id="jabatan_pengusul" name="jabatan_pengusul" class="form-control input-md" type="text" value="{set_value('jabatan_pengusul')}">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="kontak_pengusul">Kontak</label>  
					<div class="col-md-3">
						<input id="kontak_pengusul" name="kontak_pengusul" class="form-control input-md" type="text" value="{set_value('kontak_pengusul')}">
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="email">Email</label>  
					<div class="col-md-5">
						<input id="email" name="email" class="form-control input-md" type="email" value="{set_value('email')}">
						<span class="help-block">
							<span class="text-danger">Email resmi unit/lembaga yg akan digunakan untuk menerima login akun.
								<strong>Tidak Boleh</strong> menggunakan email pribadi / email dosen
							</span>
						</span> 
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-3 control-label" for="file1">Scan Surat Permintaan Akun User</label>  
					<div class="col-md-5">
						<input id="file1" name="file1" class="form-control input-md" type="file">
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
	<script src="{base_url('assets/js/jquery.validate.min.js')}" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
			/* File Style */
			$(':file').filestyle();
			
			/* Validation */
			$('#signupForm').validate({
				rules: {
					pt: "required",
					nama_pengusul: "required",
					unit_lembaga: "required",
					jabatan_pengusul: "required",
					kontak_pengusul: "required",
					email: "required",
					file1: "required"
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parent().addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parent().addClass( "has-success" ).removeClass( "has-error" );
				}
			});
		});
	</script>
{/block}