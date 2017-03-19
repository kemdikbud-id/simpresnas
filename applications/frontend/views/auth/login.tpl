{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Login {$judul}</h1>

	<div class="row">
        <div class="col-lg-5">
			<form action="{current_url()}" method="post">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title"><strong>Login </strong></h3></div>
					<div class="panel-body">
						{if $ci->session->flashdata('failed_login')}
							<div class="alert alert-danger" role="alert">Username atau Password tidak sesuai ! Silahkan ulangi.</div>
						{/if}
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username">
						</div>
						<div class="form-group">
							<label for="password">Password <!--<a href="">(forgot password)</a>--></label>
							<input type="password" class="form-control" id="password" name="password">
						</div>
						<button type="submit" class="btn btn-sm btn-default">Login</button>
					</div>
				</div>
			</form>
        </div>
				
		<div class="col-lg-5">
			<h3>Hal yang perlu diperhatikan</h3>
			<ul>
				<li>Username & password yang Resmi hanya yang berasal dari Kemenristekdikti</li>
				<li>Ketika mengganti password selalu gunakan password yang sulit ditebak</li>
				<li>Jangan membagikan password ke sembarang orang</li>
				<li>Selalu Logout setelah menggunakan sistem</li>
			</ul>
		</div>
    </div>
{/block}