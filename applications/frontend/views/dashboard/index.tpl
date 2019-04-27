{extends file='dashboard_layout.tpl'}
{block name='head'}
	{if ENVIRONMENT == 'development'}
		<link href="{base_url('vendor/nnnick/chartjs/dist/Chart.css')}" rel="stylesheet"/>
	{/if}
	{if ENVIRONMENT == 'production'}
		<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" rel="stylesheet" />
	{/if}
	<style>
		.panel .text-center { margin: 0; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Dashboard</h2>
	
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title text-center">Submit Proposal</h3>
				</div>
				<div class="panel-body">
					<p class="text-center" style="font-size: xx-large; font-weight: bold">{$jumlah.proposal_submit}</p>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title text-center">Semua Proposal</h3>
				</div>
				<div class="panel-body">
					<p class="text-center" style="font-size: xx-large; font-weight: bold">{$jumlah.proposal_all}</p>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h3 class="panel-title text-center">Perguruan Tinggi</h3>
				</div>
				<div class="panel-body">
					<p class="text-center" style="font-size: xx-large; font-weight: bold">{$jumlah.pt}</p>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title text-center">Peserta Workshop</h3>
				</div>
				<div class="panel-body">
					<p class="text-center" style="font-size: xx-large; font-weight: bold">{$jumlah.mahasiswa}</p>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-8 col-sm-12">
			
			<h3>Grafik Submit Proposal</h3>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<canvas id="myChart" width="100" height="40"></canvas>
				</div>
			</div>
			
		</div>
		<div class="col-lg-4 col-sm-12">
			
			<h3>Top 10 Perguruan Tinggi</h3>
			
			<table class="table table-condensed table-striped">
				<tbody>
					{foreach $top10pt_set as $pt}
						<tr>
							<td>{$pt->nama_pt}</td>
							<td class="text-right">{$pt->jumlah}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			
		</div>
		<div class="col-lg-6 col-sm-12">
			
			<h3>Sebaran</h3>
			
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>LLDikti/PT Negeri</th>
						<th class="text-right">PT</th>
						<th class="text-right">Proposal</th>
					</tr>
				</thead>
				<tbody>
					{foreach $lldikti_set as $lldikti}
						<tr>
							<td>
								{if $lldikti->kode_lldikti == '00'}Perguruan Tinggi Negeri{else}LLDikti {$lldikti->kode_lldikti}{/if}
							</td>
							<td class="text-right">{$lldikti->jumlah_pt}</td>
							<td class="text-right">{$lldikti->jumlah_proposal}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			
		</div>
		<div class="col-lg-6 col-sm-12">
			
			<h3>Bentuk Perguruan Tinggi</h3>
			
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>Bentuk Pendidikan</th>
						<th class="text-right">PT</th>
						<th class="text-right">Proposal</th>
					</tr>
				</thead>
				<tbody>
					{foreach $bentuk_pt_set as $bentuk_pt}
						<tr>
							<td>{$bentuk_pt->bentuk_pendidikan}</td>
							<td class="text-right">{$bentuk_pt->jumlah_pt}</td>
							<td class="text-right">{$bentuk_pt->jumlah_proposal}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	{if ENVIRONMENT == 'development'}
		<script src="{base_url('vendor/nnnick/chartjs/dist/Chart.js')}"></script>
	{/if}
	{if ENVIRONMENT == 'production'}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
	{/if}
	<script type="text/javascript">
		var ctx = document.getElementById('myChart');
		var chart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: [ {$chart_proposal.labels} ],
				datasets: [
					{
						label: 'Submit Proposal',
						data: [ {$chart_proposal.data} ],
						borderColor: 'rgb(0,0,0)',
						borderWidth: 2
					}
				]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	</script>
{/block}