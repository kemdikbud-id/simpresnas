{doctype('html5')}
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Program Kewirausahaan Mahasiswa Indonesia</title>
		{if ENVIRONMENT == 'development'}
			<link href="{base_url('../assets/css/bootstrap.min.css')}" rel="stylesheet"/>
		{/if}
		{if ENVIRONMENT == 'production'}
			<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			<link href="https://fonts.googleapis.com/css?family=Oswald|Comfortaa|Nunito+Sans:400,700" rel="stylesheet">
		{/if}
		<link href="{base_url('../assets/css/bootstrap-cerulean.min.css')}" rel="stylesheet"/>
		<link href="{base_url('../assets/css/site.css')}" rel="stylesheet"/>
		{block name='head'}
		{/block}
	</head>
	<body>
		<!-- Fixed navbar -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="{block name='container'}container{/block}">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					{if $ci->session->user}
						<a class="navbar-brand" href="{site_url('home')}">SIM-PKMI</a>
					{else}
						<a class="navbar-brand" href="{base_url()}">SIM-PKMI</a>
					{/if}
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					{if $ci->session->user}
						<ul class="nav navbar-nav">
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Setting <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="{site_url('kegiatan')}">Jadwal Kegiatan</a></li>
									<li><a href="{site_url('kegiatan/lokasi')}">Lokasi Workshop</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="{site_url('download')}">Download File</a></li>
								</ul>
							</li>
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master Data <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="{site_url('user/request')}">User Request</a></li>
									<li><a href="{site_url('user/request-rejected')}">User Request Ditolak</a></li>
									<li><a href="{site_url('user/request-approved')}">User Request Disetujui</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="{site_url('user')}">User</a></li>
									<li><a href="{site_url('pt')}">Perguruan Tinggi</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="{site_url('user-reviewer')}">Reviewer</a></li>
									<li><a href="{site_url('user-reviewer/plotting')}">Plotting Reviewer</a></li>
								</ul>
							</li>
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Proposal / Kegiatan <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="{site_url('proposal/index-pbbt')}">Proposal PBBT</a></li>
									<li><a href="{site_url('proposal/index-kbmi')}">Proposal KBMI</a></li>
									<li role="separator" class="divider"></li>
									<li><h5 style="padding: 3px 20px; margin: 0"><i>Workshop</i></h5></li>
									<li><a href="{site_url('workshop/peserta')}">Daftar Peserta</a></li>
									<li><a href="{site_url('workshop/plotting')}">Plotting Reviewer</a></li>
									<li><a href="{site_url('workshop/proposal')}">Daftar Proposal</a></li>
									<li role="separator" class="divider"></li>
									<li><h5 style="padding: 3px 20px; margin: 0"><i>Expo KMI</i></h5></li>
									<li><a href="{site_url('expo')}">Usulan Expo KMI</a></li>
									<li><a href="{site_url('expo/rekap-per-pt')}">Rekap per PT</a></li>
									<li><a href="{site_url('expo/rekap-per-kategori')}">Rekap per Kategori</a></li>
								</ul>
							</li>
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Penilaian <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="{site_url('penilaian')}">Hasil Penilaian Proposal</a></li>
									<li><a href="{site_url('penilaian/tahap2')}">Hasil Penilaian Proposal Tahap II</a></li>
									<li><a href="{site_url('penilaian/kmi-award')}">Hasil Penilaian KMI Award</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="{site_url('penilaian/didanai-pt')}">Didanai per PT</a></li>
									<li><a href="{site_url('penilaian/didanai-kategori')}">Didanai per Kategori</a></li>
								</ul>
							</li>
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Buku Profil <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="{site_url('buku-profil')}">Daftar Isian</a></li>
									<li><a href="{site_url('buku-profil/export-pdf')}">Export PDF</a></li>
								</ul>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							{if $ci->session->user}
								<li>
									<a href="{site_url('auth/logout')}">Logout ({$ci->session->user->username})</a>
								</li>
							{/if}
						</ul>
					{/if}

				</div><!--/.nav-collapse -->
			</div>
		</nav>

		<!-- Begin page content -->
		<div class="{block name='container'}container{/block}">
			{block name='content'}
			{/block}
		</div>

		<footer class="footer">
			<div class="container">
				<p class="text-center">&copy; Direktorat Jenderal Pembelajaran dan Kemahasiswaan<br/>
					Gedung D Lt 7, Jl. Jenderal Sudirman, Pintu I Senayan, Daerah Khusus Ibukota Jakarta 10270, Indonesia<br/>
					Email: kk.ditmawa@ristekdikti.go.id</p>
			</div>
		</footer>

		{if ENVIRONMENT == 'development'}
			<script src="{base_url('../assets/js/jquery-1.12.4.min.js')}"></script>
			<script src="{base_url('../assets/js/bootstrap.min.js')}"></script>
		{/if}
		{if ENVIRONMENT == 'production'}
			<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		{/if}
		{block name='footer-script'}
		{/block}
	</body>
</html>