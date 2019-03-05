{extends file='site_layout.tpl'}
{block name='head'}
	<style>
		@import url('https://fonts.googleapis.com/css?family=Boogaloo');
		.jumbotron { background-color: transparent;  }
		.jumbotron h1 { font-size: 46px; font-family: 'Boogaloo', cursive; }
		.btn-daftar { padding: 10px 15px; }
		h4 { font-weight: bold; }
		.btn { margin-top: 5px; }
	</style>
{/block}
{block name='content'}
	<div class="jumbotron text-center">
        <h1>Salam Wirausaha Muda</h1>
		<p class="lead">Penerimaan usulan proposal <strong>Kompetisi Bisnis Mahasiswa Indonesia (KBMI)</strong> dan <strong>Workshop Rencana Usaha</strong> tahun 2019 telah dibuka !</p>
    </div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-body">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="{base_url('assets/kbmi.png')}" alt="KBMI" style="width: 64px; height: 64px">
							</a>
						</div>
						<div class="media-body">
							<h4 class="media-heading">Kompetisi Bisnis Mahasiswa Indonesia</h4>
							<p>Wadah untuk mempraktekan ilmu dan keterampilan berwirausaha yang sudah
								didapat oleh mahasiswa melalui pemberian modal</p>
							<a class="btn btn-success" href="download/panduan_kbmi_2019.pdf"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Panduan</a>
							<a class="btn btn-info btn-disabled" href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Registrasi</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-body">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="{base_url('assets/workshop.png')}" alt="Workshop" style="width: 64px; height: 64px;">
							</a>
						</div>
						<div class="media-body">
							<h4 class="media-heading">Workshop Rencana Bisnis</h4>
							<p>Kegiatan workshop untuk mahasiswa agar mampu membuat rencana bisnis yang baik
								dimulai dengan memahami noble purpose dan dapat menjelaskan pelanggan,
								produk, delivery, strategi manajemen SDM serta strategi keuangan.</p>
							<a class="btn btn-success" href="download/panduan_workshop_2019.pdf"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Panduan</a>
							<a class="btn btn-info" href="{site_url('jform/workshop')}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Registrasi</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
{/block}