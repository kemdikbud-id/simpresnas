{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Tambah Proposal Workshop</h2>
    <div class="row">
		<div class="col-lg-12">
			
			<form action="{current_url()}" method="post" enctype="multipart/form-data" class="form-horizontal" id="proposalForm">
				<fieldset>
					
					<!-- Select input -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="kegiatan_id">Kegiatan</label>  
						<div class="col-md-5">
							<select name="kegiatan_id" class="form-control" required>
								<option value="">-- Pilih Kegiatan --</option>
								{foreach $kegiatan_set as $kegiatan}
									<option value="{$kegiatan->id}">{$kegiatan->nama_program} {$kegiatan->tahun}</option>
								{/foreach}
							</select>
						</div>
					</div>
							
					<!-- Select input -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="lokasi_workshop_id">Lokasi</label>  
						<div class="col-md-5">
							<select name="lokasi_workshop_id" class="form-control" required>
								<option value="">-- Pilih Lokasi --</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="judul" class="col-lg-2 control-label">Judul Proposal</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="judul" placeholder="Tulis judul proposal disini" required />
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">File Proposal</label>
						<div class="col-lg-6">
							<input type="file" name="file" class="filestyle" required />
							<p class="help-block">File proposal dalam bentuk PDF dan tidak lebih dari 5 MB</p>
						</div>
						<div class="col-lg-4">
							<!-- untuk yg sudah terupload -->
						</div>
					</div>	

					<div class="form-group">
						<div class="col-lg-2"></div>
						<div class="col-lg-10">
							<a href="{site_url('workshop/proposal')}" class="btn btn-default">Kembali</a>
							<input type="submit" value="Submit" class="btn btn-primary"/>
						</div>
					</div>

				</fieldset>
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script src="{base_url('assets/js/jquery.validate.min.js')}" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
			
			$(':file').filestyle();
			
			$('[name="kegiatan_id"]').on('change', function() {
				$('[name="lokasi_workshop_id"]').html('<option value="">-- Pilih Lokasi --</option>');
				$.getJSON('{site_url('workshop/data-lokasi')}/' + $(this).val(), function(data) {
					$.each(data, function(key, val) {
						$('[name="lokasi_workshop_id"]').append('<option value="' + val.id + '">' + val.kota + ' - ' + val.tempat + ' - ' + val.waktu_pelaksanaan + '</option>');
					});
				});
			});
			
			// Change default message
			$.validator.messages.required = 'Required';
			
			$('#proposalForm').validate({
				errorElement: "em",
				errorPlacement: function (error, element) {
					error.addClass("help-block");
					error.insertAfter(element);
				},
				highlight: function (element, errorClass, validClass) {
					$(element).parent().addClass("has-error").removeClass("has-success");
				},
				unhighlight: function (element, errorClass, validClass) {
					$(element).parent().addClass("has-success").removeClass("has-error");
				}
			});
			
		});
		
	</script>
{/block}