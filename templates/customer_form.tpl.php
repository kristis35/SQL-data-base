<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Klientai</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Kliento redagavimas"; else echo "Naujas klientas"; ?></li>
	</ol>
</nav>

<?php if($formErrors != null) { ?>
	<div class="alert alert-danger" role="alert">
		Neįvesti arba neteisingai įvesti šie laukai:
		<?php 
			echo $formErrors;
		?>
	</div>
<?php } ?>

<form action="" method="post" class="d-grid gap-3">
	<div class="form-group">
		<label for="nr">Nr<?php echo in_array('nr', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="nr" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="nr" class="form-control" value="<?php echo isset($data['nr']) ? $data['nr'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="vardas">Vardas<?php echo in_array('vardas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="vardas" name="vardas" class="form-control" value="<?php echo isset($data['vardas']) ? $data['vardas'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="pavarde">Pavardė<?php echo in_array('pavarde', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavarde" name="pavarde" class="form-control" value="<?php echo isset($data['pavarde']) ? $data['pavarde'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="fakultetas">fakultetas<?php echo in_array('fakultetas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="fakultetas" name="fakultetas" class="form-control" value="<?php echo isset($data['fakultetas']) ? $data['fakultetas'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="tel_nr">Telefonas<?php echo in_array('tel_nr', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="tel_nr" name="tel_nr" class="form-control" value="<?php echo isset($data['tel_nr']) ? $data['tel_nr'] : ''; ?>">
	</div>



	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>