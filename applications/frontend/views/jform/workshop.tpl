{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.css')}" />
	<link rel="stylesheet" href="{base_url('assets/select2/css/select2.min.css')}" />
	<style>
		.col-centered {
			float: none;
			margin-right: auto;
			margin-left: auto;
		}
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Pendaftaran Workshop Rencana Bisnis</h2>
	<div class="row">
		<div class="col-md-12">
			
			<!-- <script type="text/javascript" src="https://form.jotform.me/jsform/90402646886464"></script> -->
			
			<form action="{current_url()}" method="post" class="form-horizontal" id="workshopForm" enctype="multipart/form-data">
				
				<fieldset>
					<h4>Dalam rangka mendorong munculnya pengusaha muda di perguruan tinggi, Kementerian Riset, Teknologi, dan Pendidikan Tinggi
						kembali menyelenggarakan Kompetisi Bisnis Mahasiswa Indonesia tahun 2019,
						yang akan dimulai dengan Workshop Rencana Bisnis bagi di 11 kota di seluruh Indonesia.</h4>

					<h4>Menjadi pengusaha membutuhkan tekad kuat, mampu memunculkan ide-ide inovatif, sekaligus determinasi tinggi dalam
						menghadapi tantangan. Neil Patel, seorang angel investor dalam dunia digital, pada tahun 2016 mengatakan,
						sebanyak 9 dari 10 startup gagal di tengah jalan dalam membangun bisnis yang berkelanjutan. Untuk itu,
						dibutuhkan sebuah alasan yang kuat untuk menjadi pengusaha (noble purpose).</h4>

					<h4>Beberapa isian berikut ini memandu Anda dalam menentukan noble purpose Anda.</h4>
					
					<div class="form-group text-center">
						<a class="btn btn-default btn-next">Mulai Pendaftaran</a>
					</div>
				</fieldset>
				
				<fieldset style="display: none">
					<legend>Biodata Mahasiswa</legend>
				
					<div class="form-group">
						<label class="col-md-3 control-label" for="nama">Nama Lengkap</label>  
						<div class="col-md-5">
							<input type='text' class="form-control input-md" name="nama" required/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label" for="perguruan_tinggi">Perguruan Tinggi</label>
						<div class="col-md-5">
							<select name="perguruan_tinggi_id" class="form-control" style="width: 100%" required>
								<option value=""></option>
								{foreach $pt_set as $pt}
									<option value="{$pt->id}">{$pt->nama_pt}</option>
								{/foreach}
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label" for="program_studi">Program Studi</label>  
						<div class="col-md-5">
							<input type='text' class="form-control input-md" name="program_studi" required/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label" for="nim">NIM</label>  
						<div class="col-md-5">
							<input type='text' class="form-control input-md" name="nim" required/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label" for="angkatan">Angkatan</label>  
						<div class="col-md-2 col-xs-3">
							<input type='text' class="form-control input-md" name="angkatan" maxlength="4" required placeholder="Cth: 2017"/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label" for="email">Email</label>  
						<div class="col-md-5">
							<input type='email' class="form-control input-md" name="email" required/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label" for="no_hp">No HP</label>  
						<div class="col-md-5">
							<input type='text' class="form-control input-md" name="no_hp" required/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label" for="username_ig">Username Instagram</label>  
						<div class="col-md-5">
							<input type='text' class="form-control input-md" name="username_ig" required/>
							<span class="help-block">Pastikan mengupload <i>noble purpose</i> dengan hashtag
								<a href="https://www.instagram.com/explore/tags/KBMI2019/">#KBMI2019</a>
								dengan username yang didaftarkan. Boleh menggunakan username bisnis yang
								sudah dimiliki</span>
						</div>
					</div>
							
					<div class="form-group text-center">
						<a class="btn btn-default btn-prev">Sebelumnya</a>
						<a class="btn btn-default btn-next check-pt">Berikutnya</a>
					</div>
					
				</fieldset>
						
				<fieldset style="display: none">
					<legend>Workshop</legend>
					
					<div class="form-group">
						<label class="col-md-3 control-label" for="lokasi_workshop_id">Pilihan Lokasi</label>  
						<div class="col-md-5">
							<select name="lokasi_workshop_id" class="form-control" required>
								<option value="">-- Pilih Lokasi --</option>
								{foreach $lokasi_set as $lokasi}
									<option value="{$lokasi->id}">{$lokasi->kota} - {$lokasi->tempat} - {$lokasi->waktu_pelaksanaan}</option>
								{/foreach}
							</select>
						</div>
					</div>
							
					<div class="form-group">
						<div class="col-md-12">
							<label class="control-label" for="noble_purpose">
								Dengan menjadi pengusaha, hal mulia apa yang ingin Anda wujudkan di masa mendatang?</label>
							<p class="help-block">Contoh: <br/>1) Noble purpose-nya Steve Jobs (Apple, Inc.) adalah "Memberikan kontribusi 
								kepada dunia dengan menciptakan alat untuk pikiran demi kemajuan umat manusia." <br/>2) Noble purpose-nya Mursida
								Rambe (BMT Beringharjo Yogyakarta) "Membantu sebanyak mungkin kaum papa dari jeratan rentenir."</p>
							<textarea class="form-control" name="noble_purpose" rows="5" placeholder="Isi Noble Purpose Anda disini maksimal 30 kata" required></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-12">
							<label class="control-label" for="tujuan_mulia">
								Hal apa yang memicu Anda untuk mewujudkan tujuan mulia tersebut?</label>
							<p class="help-block">Contoh: Mursida Rambe menyaksikan seorang ibu-ibu tua dan anaknya diusir dari 
								rumah gubuknya oleh rentenir karena tidak mampu membayar hutangnya.</p>
							<textarea class="form-control" name="tujuan_mulia" rows="5" placeholder="Isi apa yang menjadi pemicu tujuan mulia Anda disini" required></textarea>
						</div>
					</div>
					
					<div class="form-group text-center">
						<a class="btn btn-default btn-prev">Sebelumnya</a>
						<button class="btn btn-primary" id="submit">Daftar</button>
					</div>
					
				</fieldset>
			
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.js')}" type="text/javascript"></script>
	<script src="{base_url('assets/select2/js/select2.min.js')}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('select[name="perguruan_tinggi_id"]').select2();
			
			$('.btn-next').on('click', function(e) {
				// get all inputs
				var inputs = $(this).parent().parent().find('input');
				
				// Ada satu input tidak valid batalkan action
				for (var i = 0; i < inputs.length; i++) {
					if (!inputs[i].checkValidity()) {
						$('#submit').trigger('click');
						return;
					}
				}
				
				// Current Fieldset
				$(this).parent().parent().hide();
				// Next Fieldset
				$(this).parent().parent().next().show();
			});
			
			$('.btn-prev').on('click', function(e) {
				// Current Fieldset
				$(this).parent().parent().hide();
				// Previous Fieldset
				$(this).parent().parent().prev().show();
			});
			
		});
	</script>
{/block}