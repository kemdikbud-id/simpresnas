{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Tambah Download File</h1>
	
	<div class="row">
		<div class="col-lg-12">

			<form class="form-horizontal" method="post" action="{current_url()}" enctype="multipart/form-data">
				<fieldset>
					
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="judul">Judul</label>  
						<div class="col-md-6">
							<input id="judul" name="judul" class="form-control input-md" type="text">
						</div>
					</div>
					
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="jenis">Jenis</label>  
						<div class="col-md-6">
							<div class="radio">
								<label><input type="radio" name="is_external" value="0" checked> Upload</label>
							</div>
							<div class="radio">
								<label><input type="radio" name="is_external" value="1"> Link</label>
							</div>
						</div>
					</div>
					
					<!-- File input-->
					<div class="form-group" id="fileInput">
						<label class="col-md-2 control-label" for="file">File</label>  
						<div class="col-md-6">
							<input id="file" name="file" class="form-control input-md" type="file">
							<span class="help-block">Max. File Size: {$upload_max_filesize}</span>
						</div>
					</div>
					
					<!-- Text input-->
					<div class="form-group" id="linkInput" style="display: none">
						<label class="col-md-2 control-label" for="link">Link</label>  
						<div class="col-md-6">
							<input id="link" name="link" class="form-control input-md" type="url">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-2"></div>
						<div class="col-md-10">
							<input type="submit" value="Submit" class="btn btn-primary"/>
							<a href="{site_url('download')}" class="btn btn-default">Kembali</a>
						</div>
					</div>
					
				</fieldset>
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script type='text/javascript'>
		$(document).ready(function() {
			
			$(':file').filestyle();
			
			$('input[name="is_external"][value="0"]').on('change', function() {
				$('#fileInput').show();
				$('#linkInput').hide();
			});
			
			$('input[name="is_external"][value="1"]').on('change', function() {
				$('#fileInput').hide();
				$('#linkInput').show();
			});
			
		});
	</script>
{/block}