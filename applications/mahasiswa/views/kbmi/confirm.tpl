{extends file='site_layout.tpl'}
{block name='content'}
	<div class="panel panel-default">
		<div class="panel-body">
			
			<form action="{current_url()}" method="post" class="form-horizontal">
				
				<fieldset>
					<legend class="text-center"><h2>Konfirmasi</h2></legend>
					
					<p style="font-size: 18px">Selamat ! 
						Pada tahap ini ada sudah menyelesaikan semua isian yang diperlukan untuk pengajuan proposal KBMI. 
						Anda bisa memperbaiki isian selama belum melakukan Submit termasuk mengganti file yang telah di upload.
						Jika sudah tidak ada yang akan diperbaiki lagi, anda bisa melakukan submit proposal dan setelah itu isian proposal tidak akan bisa dirubah lagi.
						</p>
					
					{if isset($error_message)}
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							{$error_message}
						</div>
					{/if}
					
					{* Berbentuk array jika ada yang kurang lengkap *}
					{if is_array($kelengkapan)}
						
						<div class="alert alert-danger" role="alert">
							<p>Usulan belum bisa di submit karena : </p>
							<ul>
								{foreach $kelengkapan as $item}
									<li>{$item}</li>
								{/foreach}
							</ul>
						</div>
						
					{else}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" for="isian">Kode Keamanan</label>
								<p class="form-control-static">{$img_captcha}</p>
								<input type="text" class="form-control" id="captcha" name="captcha" />
							</div>
						</div>
					{/if}
							
					<div class="form-group">
						<div class="col-lg-6">
							<input type="submit" class="btn btn-primary" name="tombol" value="Sebelumnya" />
						</div>
						<div class="col-lg-6 text-right">
							{if !is_array($kelengkapan)}
								<input type="submit" class="btn btn-success" name="tombol" value="Submit Proposal" />
							{/if}
						</div>
					</div>
					
				</fieldset>
				
			</form>
			
		</div>
	</div>
{/block}