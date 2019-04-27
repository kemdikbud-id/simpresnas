{doctype('html5')}
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>SIM-PKMI Program Kewirausahaan Mahasiswa Indonesia</title>
		{if ENVIRONMENT == 'development'}
			<link href="{base_url('vendor/twbs/bootstrap/dist/css/bootstrap.css')}" rel="stylesheet"/>
			<link href="{base_url('vendor/thomaspark/bootswatch/cerulean/bootstrap.css')}" rel="stylesheet"/>
		{/if}
		{if ENVIRONMENT == 'production'}
			<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			<link href="https://stackpath.bootstrapcdn.com/bootswatch/3.3.7/cerulean/bootstrap.min.css" rel="stylesheet" integrity="sha384-S0cN63+vYrG1/kfcUhtXsKZfyE9azrjw5p+Q5yYU+Dzjg60sZUEYsIKIb5O/oaT3" crossorigin="anonymous">
			<link href="https://fonts.googleapis.com/css?family=Oswald|Comfortaa|Nunito+Sans:400,700" rel="stylesheet">
		{/if}
		<link href="{base_url('assets/css/site.css')}" rel="stylesheet"/>
		{block name='head'}
		{/block}
	</head>
	<body>
		<!-- Fixed navbar -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{current_url()}">SIM-PKMI Dashboard</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">

				</div><!--/.nav-collapse -->
			</div>
		</nav>

		<!-- Begin page content -->
		<div class="container">
			{block name='content'}
			{/block}
		</div>

		<footer class="footer">
			<div class="container">
				<p class="text-center">&copy; {date('Y')} Direktorat Jenderal Pembelajaran dan Kemahasiswaan<br/>
					Gedung D Lt 7, Jl. Jenderal Sudirman, Pintu I Senayan, Daerah Khusus Ibukota Jakarta 10270, Indonesia<br/>
					Email: kk.ditmawa@ristekdikti.go.id</p>
			</div>
		</footer>

		{if ENVIRONMENT == 'development'}
			<script src="{base_url('vendor/components/jquery/jquery.js')}"></script>
			<script src="{base_url('vendor/twbs/bootstrap/dist/js/bootstrap.js')}"></script>
		{/if}
		{if ENVIRONMENT == 'production'}
			<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		{/if}
		{block name='footer-script'}
		{/block}
	</body>
</html>