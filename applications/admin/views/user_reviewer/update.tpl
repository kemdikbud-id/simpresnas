{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Update Reviewer</h2>
	<div class="row">
		<div class="col-lg-12">
			
			{if isset($updated)}
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Update Berhasil !</strong>
				</div>
			{/if}

			<form method="post" action="{current_url()}">
				<div class="row">
					<div class="col-sm-2">
						<div class="form-group">
							<label for="username" class="control-label">Username/NIDN</label>
							<input type="text" class="form-control" name="username" placeholder="NIDN/Username" value="{$data->username}">
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label for="password" class="control-label">Password</label>
							<input type="text" class="form-control" name="password" placeholder="Password" value="{$data->password}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="nama" class="control-label">Nama Reviewer</label>
							<input type="text" class="form-control" name="nama" id="nama" placeholder="Nama reviewer" value="{$data->reviewer->nama}">
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label for="gelar_depan" class="control-label">Gelar Depan</label>
							<input type="text" class="form-control" name="gelar_depan" value="{$data->reviewer->gelar_depan}">
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label for="gelar_belakang" class="control-label">Gelar Belakang</label>
							<input type="text" class="form-control" name="gelar_belakang" value="{$data->reviewer->gelar_belakang}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label for="kompetensi" class="control-label">Kompetensi</label>
							<input type="text" class="form-control" name="kompetensi" placeholder="Kompetensi reviewer" value="{$data->reviewer->kompetensi}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label for="no_kontak" class="control-label">No Kontak</label>
							<input type="text" class="form-control" name="no_kontak" value="{$data->reviewer->no_kontak}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label for="asal_institusi" class="control-label">Asal Institusi (Jika tidak berasal dari PT)</label>
							<input type="text" class="form-control" name="asal_institusi" value="{$data->reviewer->asal_institusi}">
						</div>
					</div>
				</div>
				<input type="submit" class="btn btn-primary" value="Simpan" />
				<a href="{site_url('user-reviewer')}" class="btn btn-default">Kembali</a>
			</form>

		</div>
	</div>
{/block}