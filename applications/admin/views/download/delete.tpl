{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Hapus Download File</h1>
	
	<div class="row">
		<div class="col-lg-12">

			<form class="form-horizontal" method="post" action="{current_url()}">
				<fieldset>
					
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="judul">Judul</label>  
						<div class="col-md-6">
							<p class="form-control-static">{$data->judul}</p>
						</div>
					</div>
					
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="jenis">Jenis</label>  
						<div class="col-md-6">
							<div class="radio">
								<label><input type="radio" name="is_external" value="0" {if $data->is_external == false}checked{/if}> Upload</label>
							</div>
							<div class="radio">
								<label><input type="radio" name="is_external" value="1" {if $data->is_external == true}checked{/if}> Link</label>
							</div>
						</div>
					</div>
					
					<!-- File input-->
					<div class="form-group" id="fileInput">
						<label class="col-md-2 control-label" for="file">File / Link</label>  
						<div class="col-md-6">
							{if $data->is_external}
								<p class="form-control-static">{$data->link}</p>
							{else}
								<p class="form-control-static">{$data->nama_file}</p>
							{/if}
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-2"></div>
						<div class="col-md-10">
							<input type="submit" value="Hapus" class="btn btn-danger"/>
							<a href="{site_url('download')}" class="btn btn-default">Kembali</a>
						</div>
					</div>
					
				</fieldset>
			</form>
			
		</div>
	</div>
{/block}