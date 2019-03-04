{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.css')}" />
{/block}
{block name='content'}
	<h2 class="page-header">Pendaftaran Proposal KBMI</h2>
	<div class="row">
		<div class="col-md-12">
			
			<h4>Selamat datang di Kompetisi Bisnis Mahasiswa Indonesa!</h4>
			
			<h4>Kemeristekdikti melalui Direktorat Jenderal Pembelajaran dan Kemahasiswaan mengapresiasi kontribusi Anda
				dalam usaha menambah jumlah pengusaha di Indonesia.</h4>
			
			<h4>Sebagai bahan penilaian juri dalam kompetisi ini, silakan isi beberapa pertanyaan berikut</h4>
			
			<!-- <script type="text/javascript" src="https://form.jotform.me/jsform/90408060856457"></script> -->
			
			<form action="{current_url()}" method="post" class="form-horizontal" id="workshopForm" enctype="multipart/form-data">
				
				<fieldset>
					<legend>Informasi Umum</legend>
					
					<div class="form-group">
						<label class="col-lg-2 control-label" for="perguruan_tinggi">Perguruan Tinggi</label>  
						<div class="col-lg-6">
							<input type='text' class="form-control input-md" name="perguruan_tinggi" value="{set_value('perguruan_tinggi')}"/>
							<input type='hidden' name="perguruan_tinggi_id" value='' />
						</div>
					</div>
				
					<div class="form-group">
						<label class="col-lg-2 control-label" for="nama_perusahaan">Nama (Calon) Perusahaan</label>  
						<div class="col-lg-8">
							<input type='text' class="form-control input-md" name="nama_perusahaan" value="{set_value('nama_perusahaan')}"/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-lg-2 control-label">Ketua</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_ketua" placeholder="NIM / NPM" >
						</div>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="nama_ketua" placeholder="Nama Ketua" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Anggota 1</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_anggota[1]" placeholder="NIM / NPM" >
						</div>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="nama_anggota[1]" placeholder="Nama Anggota 1" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Anggota 2</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_anggota[2]" placeholder="NIM / NPM" >
						</div>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="nama_anggota[2]" placeholder="Nama Anggota 2" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Anggota 3</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_anggota[3]" placeholder="NIM / NPM" >
						</div>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="nama_anggota[3]" placeholder="Nama Anggota 3" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Anggota 4</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="nim_anggota[4]" placeholder="NIM / NPM" >
						</div>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="nama_anggota[4]" placeholder="Nama Anggota 4" >
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-lg-2 control-label" for="email">Email Ketua</label>  
						<div class="col-lg-4">
							<input type='text' class="form-control input-md" name="email" value="{set_value('email')}"/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-lg-2 control-label" for="dosen_pembimbing">Dosen Pembimbing</label>
						<div class="col-lg-6">
							<input type='text' class="form-control input-md" name="dosen_pembimbing" value="{set_value('dosen_pembimbing')}"/>
						</div>
					</div>
					
				</fieldset>
						
				<fieldset>
					<legend>Noble Purpose</legend>
					
					<h4>Menjadi pengusaha membutuhkan yang tekad kuat, mampu memunculkan ide-ide inovatif, sekaligus determinasi tinggi dalam
						menghadapi tantangan. Neil Patel, seorang angel investor dalam dunia digital, pada tahun 2016 mengatakan,
						sebanyak 9 dari 10 startup gagal di tengah jalan dalam membangun bisnis yang berkelanjutan. Untuk itu,
						dibutuhkan sebuah alasan yang kuat untuk menjadi pengusaha (noble purpose).</h4>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" for="isian1">Hal mulia apa yang tim Anda ingin wujudkan dalam membangun bisnis?</label>
							<p class="help-block">Contoh: 1) Noble purpose-nya Steve Jobs (Apple, Inc.) adalah memberikan kontribusi
								kepada dunia dengan menciptakan alat untuk pikiran demi kemajuan umat manusia. 2) Noble purpose-nya Mursida
								Rambe (BMT Beringharjo Yogyakarta) membantu sebanyak mungkin kaum papa dari jeratan rentenir.</p>
							<textarea class="form-control" name="isian1" rows="5"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" for="isian2">Apa atau siapa yang menjadi pemicu hal mulia yang ingin diwujudkan tersebut?</label>
							<p class="help-block">Contoh: Mursida Rambe menyaksikan seorang ibu-ibu tua dan anaknya diusir dari rumah
								gubuknya oleh rentenir karena tidak mampu membayar hutangnya.</p>
							<textarea class="form-control" name="isian2" rows="5"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-8">
							<label class="control-label" for="isian3">Topik Bisnis</label>
							<input type='text' class="form-control input-md" name="isian3" value="{set_value('isian3')}" 
								   placeholder="Contoh: Pendidikan bisnis untuk anak-anak."/>
						</div>
					</div>
						
					<div class="form-group">
						<div class="col-lg-8">
							<label class="control-label" for="isian4">Goal/target omset dan net profit usaha Anda di tahun ini?</label>
							<input type='text' class="form-control input-md" name="isian4" value="{set_value('isian4')}" 
								   placeholder="Contoh: Omset 500 juta per tahun dan net profit 100 juta"/>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-8">
							<label class="control-label" for="isian5">Realitas omset dan net profit usaha Anda di tahun ini?</label>
							<p class='help-block'>Contoh: Omset 100 juta per tahun dan net profit 20 juta, dan bagi yang belum memulai bisnis, isi ini dengan "belum memulai bisnis"</p>
							<input type='text' class="form-control input-md" name="isian5" value="{set_value('isian5')}"/>
						</div>
					</div>
						
				</fieldset>
						
				<fieldset>
					<legend>Sasaran Pelanggan</legend>
					
					<div class="form-group">
						<div class="col-lg-8">
							<label class="control-label" for="isian6">Segmen spesifik pelanggan mana yang akan Anda sasar?</label>
							<input type='text' class="form-control input-md" name="isian6" value="{set_value('isian6')}" 
								   placeholder="Contoh: Orang tua yang memiliki anak usia 10-15 tahun."/>
						</div>
					</div>
						
					<div class="form-group">
						<div class="col-lg-8">
							<label class="control-label" for="isian7">
								Area mana yang akan menjadi target ideal jangkauan bisnis Anda?</label>
							<input type='text' class="form-control input-md" name="isian7" value="{set_value('isian7')}" 
								   placeholder="Contoh: Indonesia"/>
						</div>
					</div>
						
					<div class="form-group">
						<div class="col-lg-8">
							<label class="control-label" style="text-align: left" for="isian8">
								Dalam 4 bulan pertama bisnis Anda berjalan, daerah mana yang akan menjadi
								awal target pasar Anda?</label>
							<input type='text' class="form-control input-md" name="isian8" value="{set_value('isian8')}" 
								   placeholder="Contoh: Kota Yogyakarta"/>
						</div>
					</div>
								   
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian9">
								Coba Anda amati dan tanyakan kepada calon pelanggan yang Anda sasar.
								Aktifitas apa saja yang perlu mereka lakukan untuk mendapatkan produk/jasa
								yang menjadi konteks bisnis Anda?</label>
							<p class="help-block">Contoh : Orang tua dengan profesi pengusaha melakukan hal-hal untuk mendidik anaknya supaya
								belajar bisnis sedini mungkin, orang tua itu mencarikan pendidikan bisnis, mencari buku bisnis untuk anak,
								mencari game bisnis online maupun offline untuk anak, mencari mentor bisnis untuk anak.</p>
							<textarea class="form-control" name="isian9" rows="5"></textarea>
						</div>
					</div>
								   
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian10">
								Kesulitan apa saja yang benar-benar dirasakan oleh calon pelanggan Anda,
								terkait dengan hal-hal yang perlu dilakukan untuk mendapatkan produk/jasa
								yang menjadi konteks bisnis Anda?</label>
							<p class="help-block">Contoh : orang tua kesulitan mencari game bisnis offline,
								kesulitan mencari pendidikan bisnis anak</p>
							<textarea class="form-control" name="isian10" rows="5"></textarea>
						</div>
					</div>
								   
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian11">
								Jika kesulitan-kesulitan tersebut dapat terselesaikan, harapan apa saja
								yang ingin diwujudkan oleh calon pelanggan Anda?</label>
							<p class="help-block">Harapan orang tua : adanya sebuah komunitas bisnis untuk anak</p>
							<textarea class="form-control" name="isian11" rows="5"></textarea>
						</div>
					</div>
								   
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian12">
								Dari semua kesulitan dan harapan calon pelanggan anda, produk/layanan anda akan
								menyelesaikan kesulitan dan memenuhi harapan yang mana?</label>
							<p class="help-block">Jasa : Sekolah bisnis untuk anak setiap sabtu-minggu</p>
							<textarea class="form-control" name="isian12" rows="5"></textarea>
						</div>
					</div>
					
				</fieldset>
								   
				<fieldset>
					<legend>Informasi Produk</legend>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian13">
								Produk/jasa apa yang Anda tawarkan kepada calon pelanggan Anda?</label>
							<input type='text' class="form-control input-md" name="isian13" value="{set_value('isian13')}" />
						</div>
					</div>
						
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian14">
								Referensi produk/layanan apa saja atau hasil riset maupun jurnal dari pakar siapa yang Anda jadikan pertimbangan untuk membuat produk/layanan Anda?</label>
							<p class="help-block">Isian pisahkan dengan koma</p>
							<textarea class="form-control" name="isian14" rows="2"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian15">
								Bagaimana produk/jasa Anda tersebut bekerja menyelesaikan masalah dan memenuhi keinginan pelanggan yang Anda sasar?</label>
							<textarea class="form-control" name="isian15" rows="3"></textarea>
						</div>
					</div>
						
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian16">
								Menurut Anda, siapa saja yang akan menjadi kompetitor dalam menyediakan produk/jasa tersebut?</label>
							<textarea class="form-control" name="isian16" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian17">
								Apa saja keunggulan produk/jasa yang disediakan oleh kompetitor Anda?</label>
							<textarea class="form-control" name="isian17" rows="3"></textarea>
						</div>
					</div>
						
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian18">
								Lalu, hal apa saja yang menjadi keunggulan kompetitif produk/jasa Anda dibandingkan dengan produk/jasa kompetitor?</label>
							<textarea class="form-control" name="isian18" rows="3"></textarea>
						</div>
					</div>
						
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian19">
								Dari sisi mana saja bisnis Anda akan mendapatkan revenue dari pelanggan?</label>
							<textarea class="form-control" name="isian19" rows="3"></textarea>
						</div>
					</div>
					
				</fieldset>
						
				<fieldset>
					<legend>Hubungan dengan Pelanggan</legend>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian20">
								Bagaimana strategi Anda untuk membuat calon pelanggan mengetahui produk/jasa yang Anda sediakan?</label>
							<textarea class="form-control" name="isian20" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian21">
								Bagaimana strategi Anda untuk membuat calon pelanggan tertarik dan akhirnya memutuskan membeli produk/jasa yang Anda sediakan?</label>
							<textarea class="form-control" name="isian21" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian22">Bagaimana caranya anda merespon pelanggan yang bertanya, membeli dan komplain terhadap layanan anda?</label>
							<textarea class="form-control" name="isian22" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian23">
								Strategi apa yang akan Anda lakukan untuk menjadikan pelanggan Anda loyal?</label>
							<textarea class="form-control" name="isian23" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian24">
								Dimana calon pelanggan dapat memperoleh produk/jasa Anda?</label>
							<div class="radio">
								<label><input type="radio" value="" name="isian24"> Melalui sistem <i>online</i></label>
							</div>
							<div class="radio">
								<label><input type="radio" value="" name="isian24"> Melalui sistem <i>online</i> dan <i>offline</i></label>
							</div>
							<div class="radio">
								<label><input type="radio" value="" name="isian24"> Melalui sistem <i>offline</i></label>
							</div>
						</div>
					</div>
					
				</fieldset>
						
				<fieldset>
					<legend>Sumber Daya</legend>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian24">
								Siapa saja anggota tim terbaik yang akan Anda libatkan dalam bisnis, dan apa keahlian masing-masing?</label>
							<p class="help-block">Tuliskan nama tim, dan keahlian spesifiknya.</p>
							<textarea class="form-control" name="isian24" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian25">
								Apa saja tanggung jawab masing-masing tim Anda tersebut?</label>
							<p class="help-block">Tuliskan nama tim, dan tanggung jawabnya.</p>
							<textarea class="form-control" name="isian25" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian25">
								Apa indikator keberhasilan dari tanggung jawab masing-masing tim Anda tersebut?</label>
							<p class="help-block">Indikator kebarhasilan terukur secara Spesific, Measurable,
								Achievable, Realistic, Time-Based, contoh : Andi sebagai marketer, tanggung
								jawabnya adalah melalkukan proses marketing dengan indikator keberhasilan
								adalah dalam sebulan bisa menjual kepala 100 klien.</p>
							<textarea class="form-control" name="isian25" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian26">
								Peralatan dan bahan utama apa saja yang Anda butuhkan untuk membuat produk/jasa tersebut?</label>
							<textarea class="form-control" name="isian26" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian27">
								Jika Anda harus bermitra dalam menyediakan produk/jasa Anda, pihak mana yang akan Anda ajak kerja sama?</label>
							<textarea class="form-control" name="isian27" rows="3"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian28">
								Biaya apa saja yang Anda butuhkan dalam menyediakan, menjual, dan mengantarkan produk/jasa kepada pelanggan?</label>
							<textarea class="form-control" name="isian28" rows="3"></textarea>
						</div>
					</div>
					
				</fieldset>
						
				<fieldset>
					<legend>Ketentuan Lain</legend>
					
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" style="text-align: left" for="isian29">
								Jika terpilih sebagai penerima hibah, apa Anda sanggup memenuhi ketentuan dan syarat yang sudah ditetapkan?</label>
							<div class="radio">
								<label><input type="radio" value="" name="isian29"> Ya</label>
							</div>
							<div class="radio">
								<label><input type="radio" value="" name="isian29"> Tidak</label>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-8">
							<label class="control-label" for="file1">Surat Persetujuan dari Perguruan Tinggi</label>  
							<input id="file1" name="file1" class="form-control input-md" type="file">
							<span class="text-info">File yang di ijinkan: PDF</span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-8">
							<button name="submit" class="btn btn-primary">Daftar</button>
						</div>
					</div>
					
				</fieldset>
				
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.js')}" type="text/javascript"></script>
	<script src="{base_url('assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script src="{base_url('assets/js/jquery.validate.min.js')}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function () {

			/* Autocomplete */
			$('input[name="perguruan_tinggi"]').autocomplete({
				source: '{site_url('auth/search_pt/')}',
				minLength: 6
			});

			/* File Style */
			$(':file').filestyle();
			
		});
	</script>
{/block}