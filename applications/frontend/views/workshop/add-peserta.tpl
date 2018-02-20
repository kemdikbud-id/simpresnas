{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Tambah Mahasiswa Peserta Workshop</h2>
    <div class="row">
		<div class="col-lg-12">
			<form class="form-horizontal" method="post" action="{current_url()}" id="pesertaForm">
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
							
					<!-- Multiple Input -->
					<div class="form-group" id="mahasiswa0">
						<label class="col-md-2 control-label" for="">Mahasiswa</label>
						<div class="col-md-2">
							<input type="text" class="form-control" name="nim[0]" placeholder="NIM / NPM" required/>
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama[0]" placeholder="Nama" required/>
						</div>
						<div class="col-md-1">
							<input type="text" class="form-control" name="angkatan[0]" placeholder="Angkatan" required 
								   data-rule-digits="true" data-rule-minlength="4" data-rule-maxlength="4" data-rule-max="{date('Y')}"/>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" name="program_studi[0]" placeholder="Program Studi" required/>
						</div>
					</div>
					
					<!-- Mini Button -->
					<div class="form-group">
						<div class="col-md-2">
						</div>
						<div class="col-md-2">
							<a href="#" class="btn btn-xs btn-success" id="tambahButton"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Mahasiswa</a>
						</div>
					</div>
					
					<!-- Button -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="singlebutton"></label>
						<div class="col-md-4">
							<a href="{site_url('workshop')}" class="btn btn-default">Kembali</a>
							<input type="submit" value="Simpan" class="btn btn-primary"/>
							<input type="hidden" name="perguruan_tinggi_id" value="{$ci->session->perguruan_tinggi->id}" />
						</div>
					</div>
					
					
				</fieldset>
			</form>
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/js/jquery.validate.min.js')}" type="text/javascript"></script>
	<script type="text/javascript">
		var mahasiswaLength = 1;
		$(document).ready(function() {
			
			$('[name="kegiatan_id"]').on('change', function() {
				$('[name="lokasi_workshop_id"]').html('<option value="">-- Pilih Lokasi --</option>');
				$.getJSON('{site_url('workshop/data-lokasi')}/' + $(this).val(), function(data) {
					$.each(data, function(key, val) {
						$('[name="lokasi_workshop_id"]').append('<option value="' + val.id + '">' + val.kota + ' - ' + val.tempat + ' - ' + val.waktu_pelaksanaan + '</option>');
					});
				});
			});
			
			$('#tambahButton').on('click', function() {
				
				var formGroupHtml = 
					'<div class="form-group" id="mahasiswa' + mahasiswaLength + '">' +
					'<label class="col-md-2 control-label" for="">Mahasiswa</label>' +
					'<div class="col-md-2"><input type="text" class="form-control" name="nim[' + mahasiswaLength + ']" placeholder="NIM / NPM" required /></div>' +
					'<div class="col-md-4"><input type="text" class="form-control" name="nama[' + mahasiswaLength + ']" placeholder="Nama" required /></div>' +
					'<div class="col-md-1"><input type="text" class="form-control" name="angkatan[' + mahasiswaLength + ']" placeholder="Angkatan" required data-rule-digits="true" data-rule-minlength="4" data-rule-maxlength="4" data-rule-max="{date('Y')}"/></div>' +
					'<div class="col-md-3"><input type="text" class="form-control" name="program_studi[' + mahasiswaLength + ']" placeholder="Program Studi" required /></div>' +
					'</div>';
				
				$('#mahasiswa' + (mahasiswaLength - 1)).after(formGroupHtml);
				
				mahasiswaLength++;
			});
			
			// Change default message
			$.validator.messages.required = 'Required';
			
			$('#pesertaForm').validate({
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