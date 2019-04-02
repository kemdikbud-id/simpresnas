{extends file='site_layout.tpl'}
{block name='content'}
	<div class="panel panel-default">
		<div class="panel-body text-center">
			<h1>Halo {$ci->session->user->mahasiswa->nama},</h1>
			
			<h4>Selamat datang di Kompetisi Bisnis Mahasiswa Indonesia !</h4>
			
			<h4>Kemeristekdikti melalui Direktorat Jenderal Pembelajaran dan Kemahasiswaan mengapresiasi kontribusi Anda
				dalam usaha menambah jumlah pengusaha di Indonesia.</h4>
			
			{if $kegiatan != NULL}
				{if $kegiatan->available == FALSE}
					<h5 style="color: red">Tidak ada jadwal kegiatan KBMI aktif.</h5>
				{else if $proposal != NULL}
					<h4>Sebagai bahan penilaian juri dalam kompetisi ini, silakan isi beberapa pertanyaan berikut</h4>
					<a href="{site_url('kbmi/identitas')}" class="btn btn-lg btn-primary">Mulai</a>
				{else}
					<h5 style="color: red">Proposal belum ada. Silahkan hubungi operator perguruan tinggi.</h5>
				{/if}
			{else}
				<h5 style="color: red">Tidak ada jadwal kegiatan KBMI aktif.</h5>
			{/if}
			
		</div>
	</div>
{/block}