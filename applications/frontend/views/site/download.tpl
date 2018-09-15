{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Download File</h2>

	<div class="row">
		
		<div class="col-lg-12">
			
			{foreach $download_set as $download}
				<div class="media">
					<div class="media-left">
						{if $download->is_external}
							<a href="{$download->link}" target="_blank">
								<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
							</a>
						{else}
							<a href="{base_url()}download/{$download->nama_file}" target="_blank">
								<span class="glyphicon glyphicon-file" aria-hidden="true"></span>
							</a>
						{/if}
					</div>
					<div class="media-body">
						{if $download->is_external}
							<h5 class="media-heading"><a href="{$download->link}" style="color:#317eac">{$download->judul}</a></h5>
						{else}
							<h5 class="media-heading"><a href="{base_url()}download/{$download->nama_file}" style="color:#317eac">{$download->judul}</a></h5>
						{/if}
					</div>
				</div>
			{/foreach}

		</div>

	</div>
{/block}