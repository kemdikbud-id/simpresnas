{extends file='site_layout.tpl'}
{block name='content'}
	<div class="panel panel-default">
		<div class="panel-body">
			
			<form action="{current_url()}" method="post" class="form-horizontal">
				<input type="hidden" name="isian_ke" value="{$step}" />
				
				<fieldset>
					<legend class="text-center"><h2>{if isset($heading)}{$heading}{/if}</h2></legend>
					
					{if $step == 0}
						<h4>Menjadi pengusaha membutuhkan yang tekad kuat, mampu memunculkan ide-ide inovatif, sekaligus determinasi tinggi dalam
							menghadapi tantangan. Neil Patel, seorang angel investor dalam dunia digital, pada tahun 2016 mengatakan,
							sebanyak 9 dari 10 startup gagal di tengah jalan dalam membangun bisnis yang berkelanjutan. Untuk itu,
							dibutuhkan sebuah alasan yang kuat untuk menjadi pengusaha (<i>noble purpose</i>).</h4>
					{/if}
					
					{if $step == 1}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" for="isian">Hal mulia apa yang tim Anda ingin wujudkan dalam membangun bisnis?</label>
								<p class="help-block">Contoh: 1) Noble purpose-nya Steve Jobs (Apple, Inc.) adalah memberikan kontribusi
									kepada dunia dengan menciptakan alat untuk pikiran demi kemajuan umat manusia. 2) Noble purpose-nya Mursida
									Rambe (BMT Beringharjo Yogyakarta) membantu sebanyak mungkin kaum papa dari jeratan rentenir.</p>
								<textarea class="form-control" name="isian" rows="5" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 2}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" for="isian">Apa atau siapa yang menjadi pemicu hal mulia yang ingin diwujudkan tersebut?</label>
								<p class="help-block">Contoh: Mursida Rambe menyaksikan seorang ibu-ibu tua dan anaknya diusir dari rumah
									gubuknya oleh rentenir karena tidak mampu membayar hutangnya.</p>
								<textarea class="form-control" name="isian" rows="5" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 3}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" for="isian">Topik Bisnis</label>
								<input type='text' class="form-control input-md" name="isian" value="{$isian_proposal->isian|htmlspecialchars}" 
									   placeholder="Contoh: Pendidikan bisnis untuk anak-anak." required />
							</div>
						</div>
					{/if}
					
					{if $step == 4}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" for="isian">Goal/target omset dan net profit usaha Anda di tahun ini?</label>
								<input type='text' class="form-control input-md" name="isian" value="{$isian_proposal->isian|htmlspecialchars}" 
									   placeholder="Contoh: Omset 500 juta per tahun dan net profit 100 juta" required/>
							</div>
						</div>
					{/if}
					
					{if $step == 5}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" for="isian">Realitas omset dan net profit usaha Anda di tahun ini?</label>
								<p class='help-block'>Contoh: Omset 100 juta per tahun dan net profit 20 juta, dan bagi yang belum memulai bisnis, isi ini dengan "belum memulai bisnis"</p>
								<input type='text' class="form-control input-md" name="isian" value="{$isian_proposal->isian|htmlspecialchars}" required/>
							</div>
						</div>
					{/if}
					
					{if $step == 6}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" for="isian">Segmen spesifik pelanggan mana yang akan Anda sasar?</label>
								<input type='text' class="form-control input-md" name="isian" value="{$isian_proposal->isian|htmlspecialchars}" 
									   placeholder="Contoh: Orang tua yang memiliki anak usia 10-15 tahun." required />
							</div>
						</div>
					{/if}
					
					{if $step == 7}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" for="isian">
									Area mana yang akan menjadi target ideal jangkauan bisnis Anda?</label>
								<input type='text' class="form-control input-md" name="isian" value="{$isian_proposal->isian|htmlspecialchars}" 
									   placeholder="Contoh: Indonesia" required />
							</div>
						</div>
					{/if}
					
					{if $step == 8}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Dalam 4 bulan pertama bisnis Anda berjalan, daerah mana yang akan menjadi
									awal target pasar Anda?</label>
								<input type='text' class="form-control input-md" name="isian" value="{$isian_proposal->isian|htmlspecialchars}" 
									   placeholder="Contoh: Kota Yogyakarta" required />
							</div>
						</div>
					{/if}
					
					{if $step == 9}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Coba Anda amati dan tanyakan kepada calon pelanggan yang Anda sasar.
									Aktifitas apa saja yang perlu mereka lakukan untuk mendapatkan produk/jasa
									yang menjadi konteks bisnis Anda?</label>
								<p class="help-block">Contoh : Orang tua dengan profesi pengusaha melakukan hal-hal untuk mendidik anaknya supaya
									belajar bisnis sedini mungkin, orang tua itu mencarikan pendidikan bisnis, mencari buku bisnis untuk anak,
									mencari game bisnis online maupun offline untuk anak, mencari mentor bisnis untuk anak.</p>
								<textarea class="form-control" name="isian" rows="5" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 10}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Kesulitan apa saja yang benar-benar dirasakan oleh calon pelanggan Anda,
									terkait dengan hal-hal yang perlu dilakukan untuk mendapatkan produk/jasa
									yang menjadi konteks bisnis Anda?</label>
								<p class="help-block">Contoh : orang tua kesulitan mencari game bisnis offline,
									kesulitan mencari pendidikan bisnis anak</p>
								<textarea class="form-control" name="isian" rows="5" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 11}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Jika kesulitan-kesulitan tersebut dapat terselesaikan, harapan apa saja
									yang ingin diwujudkan oleh calon pelanggan Anda?</label>
								<p class="help-block">Harapan orang tua : adanya sebuah komunitas bisnis untuk anak</p>
								<textarea class="form-control" name="isian" rows="5" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 12}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Dari semua kesulitan dan harapan calon pelanggan anda, produk/layanan anda akan
									menyelesaikan kesulitan dan memenuhi harapan yang mana?</label>
								<p class="help-block">Jasa : Sekolah bisnis untuk anak setiap sabtu-minggu</p>
								<textarea class="form-control" name="isian" rows="5" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 13}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Produk/jasa apa yang Anda tawarkan kepada calon pelanggan Anda?</label>
								<input type='text' class="form-control input-md" name="isian" value="{$isian_proposal->isian|htmlspecialchars}" required />
							</div>
						</div>
					{/if}
						
					{if $step == 14}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Referensi produk/layanan apa saja atau hasil riset maupun jurnal dari pakar siapa yang Anda jadikan pertimbangan untuk membuat produk/layanan Anda?</label>
								<p class="help-block">Isian pisahkan dengan koma</p>
								<textarea class="form-control" name="isian" rows="2" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 15}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Bagaimana produk/jasa Anda tersebut bekerja menyelesaikan masalah dan memenuhi keinginan pelanggan yang Anda sasar?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 16}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Menurut Anda, siapa saja yang akan menjadi kompetitor dalam menyediakan produk/jasa tersebut?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 17}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Apa saja keunggulan produk/jasa yang disediakan oleh kompetitor Anda?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
						
					{if $step == 18}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Lalu, hal apa saja yang menjadi keunggulan kompetitif produk/jasa Anda dibandingkan dengan produk/jasa kompetitor?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
						
					{if $step == 19}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Dari sisi mana saja bisnis Anda akan mendapatkan revenue dari pelanggan?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 20}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Bagaimana strategi Anda untuk membuat calon pelanggan mengetahui produk/jasa yang Anda sediakan?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 21}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Bagaimana strategi Anda untuk membuat calon pelanggan tertarik dan akhirnya memutuskan membeli produk/jasa yang Anda sediakan?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 22}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">Bagaimana caranya anda merespon pelanggan yang bertanya, membeli dan komplain terhadap layanan anda?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 23}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Strategi apa yang akan Anda lakukan untuk menjadikan pelanggan Anda loyal?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 24}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Dimana calon pelanggan dapat memperoleh produk/jasa Anda?</label>
								<div class="radio">
									<label><input type="radio" name="isian" required value="Online" {if $isian_proposal->isian == 'Online'}checked{/if}> Melalui sistem <i>online</i></label>
								</div>
								<div class="radio">
									<label><input type="radio" name="isian" required value="Online dan Offline" {if $isian_proposal->isian == 'Online dan Offline'}checked{/if}> Melalui sistem <i>online</i> dan <i>offline</i></label>
								</div>
								<div class="radio">
									<label><input type="radio" name="isian" required value="Offline" {if $isian_proposal->isian == 'Offline'}checked{/if}> Melalui sistem <i>offline</i></label>
								</div>
							</div>
						</div>
					{/if}
					
					{if $step == 25}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Siapa saja anggota tim terbaik yang akan Anda libatkan dalam bisnis, dan apa keahlian masing-masing?</label>
								<p class="help-block">Tuliskan nama tim, dan keahlian spesifiknya.</p>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 26}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Apa saja tanggung jawab masing-masing tim Anda tersebut?</label>
								<p class="help-block">Tuliskan nama tim, dan tanggung jawabnya.</p>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 27}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Apa indikator keberhasilan dari tanggung jawab masing-masing tim Anda tersebut?</label>
								<p class="help-block">Indikator kebarhasilan terukur secara Spesific, Measurable,
									Achievable, Realistic, Time-Based, contoh : Andi sebagai marketer, tanggung
									jawabnya adalah melalkukan proses marketing dengan indikator keberhasilan
									adalah dalam sebulan bisa menjual kepala 100 klien.</p>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 28}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Peralatan dan bahan utama apa saja yang Anda butuhkan untuk membuat produk/jasa tersebut?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 29}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Jika Anda harus bermitra dalam menyediakan produk/jasa Anda, pihak mana yang akan Anda ajak kerja sama?</label>
								<textarea class="form-control" name="isian" rows="3" required>{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 30}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Biaya apa saja yang Anda butuhkan dalam menyediakan, menjual, dan mengantarkan produk/jasa kepada pelanggan?</label>
								<textarea class="form-control" name="isian" rows="3">{$isian_proposal->isian}</textarea>
							</div>
						</div>
					{/if}
					
					{if $step == 31}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" style="text-align: left" for="isian">
									Jika terpilih sebagai penerima hibah, apa Anda sanggup memenuhi ketentuan dan syarat yang sudah ditetapkan?</label>
								<div class="radio">
									<label><input type="radio" value="Ya" name="isian" required {if $isian_proposal->isian == 'Ya'}checked{/if}> Ya</label>
								</div>
								<div class="radio">
									<label><input type="radio" value="Tidak" name="isian" required {if $isian_proposal->isian == 'Tidak'}checked{/if}> Tidak</label>
								</div>
							</div>
						</div>
					{/if}
					
					<div class="form-group">
						<div class="col-lg-6">
							<input type="submit" class="btn btn-primary" name="tombol" value="Sebelumnya" />
						</div>
						<div class="col-lg-6 text-right">
							<input type="submit" class="btn btn-primary" name="tombol" value="Berikutnya" />
						</div>
					</div>
					
				</fieldset>
				
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src='{base_url('../assets/js/jquery.validate.min.js')}' type='text/javascript'></script>
	<script type='text/javascript'>
		$(document).ready(function() {
			$('form').validate();
		});
	</script>
{/block}