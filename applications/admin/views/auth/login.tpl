{extends file='site_layout.tpl'}
{block name='content'}
	<div class="row">
        <div class="col-md-4 col-md-offset-4">
			<form action="{current_url()}" method="post">
				<div class="panel panel-danger">
					<div class="panel-heading"><h3 class="panel-title"><strong>Login Administrator</strong></h3></div>
					<div class="panel-body">
						{if $ci->session->flashdata('failed_login')}
							<div class="alert alert-danger" role="alert">Username atau Password tidak sesuai ! Silahkan ulangi.</div>
						{/if}
						<div class="form-group">
							<input type="text" class="form-control" id="username" name="username" placeholder="Username">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-primary">Login</button>
					</div>
				</div>
			</form>
					
			<p><a href="..">Ke halaman utama</a></p>
        </div>
    </div>
{/block}