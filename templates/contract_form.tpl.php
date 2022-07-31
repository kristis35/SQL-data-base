<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Sutartys</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Sutarties redagavimas"; else echo "Nauja sutartis"; ?></li>
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

	<h4 class="mt-3">Sutarties informacija</h4>
  	
	<div class="form-group">
		<label for="nr">Numeris<?php echo in_array('nr', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="nr" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="nr" class="form-control" value="<?php echo isset($data['nr']) ? $data['nr'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="sutarties_data">Data<?php echo in_array('sutarties_data', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="sutarties_data" name="sutarties_data" class="form-control datepicker" value="<?php echo isset($data['sutarties_data']) ? $data['sutarties_data'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="fk_klientas">Klientas<?php echo in_array('fk_klientas', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_klientas" name="fk_klientas" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// išrenkame klientus
				$customers = $customersObj->getCustomersList();
				foreach($customers as $key => $val) {
					$selected = "";
					if(isset($data['fk_klientas']) && $data['fk_klientas'] == $val['asmens_kodas']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['asmens_kodas']}'>{$val['vardas']} {$val['pavarde']}</option>";
				}
			?>
		</select>
	</div>

	

	<div class="form-group">
		<label for="nuomos_data_laikas">Nuomos data ir laikas<?php echo in_array('nuomos_data_laikas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="nuomos_data_laikas" name="nuomos_data_laikas" class="form-control datetime" value="<?php echo isset($data['nuomos_data_laikas']) ? $data['nuomos_data_laikas'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="planuojama_grazinimo_data_laikas">Planuojama grąžinti<?php echo in_array('planuojama_grazinimo_data_laikas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="planuojama_grazinimo_data_laikas" name="planuojama_grazinimo_data_laikas" class="form-control datetime" value="<?php echo isset($data['planuojama_grazinimo_data_laikas']) ? $data['planuojama_grazinimo_data_laikas'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="faktine_grazinimo_data_laikas">Grąžinta<?php echo in_array('faktine_grazinimo_data_laikas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="faktine_grazinimo_data_laikas" name="faktine_grazinimo_data_laikas" class="form-control datetime" value="<?php echo isset($data['faktine_grazinimo_data_laikas']) ? $data['faktine_grazinimo_data_laikas'] : ''; ?>">
	</div>

	

	<div class="form-group">
		<label for="kaina">Nuomos kaina<?php echo in_array('kaina', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="kaina" name="kaina" class="form-control" value="<?php echo isset($data['kaina']) ? $data['kaina'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="bendra_kaina">Bendra kaina su paslaugomis<?php echo in_array('bendra_kaina', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="bendra_kaina" name="bendra_kaina" class="form-control" value="<?php echo isset($data['bendra_kaina']) ? $data['bendra_kaina'] : ''; ?>">
	</div>

	<h4 class="mt-3">Automobilio informacija</h4>

	<div class="form-group">
		<label for="fk_automobilis">Automobilis<?php echo in_array('fk_automobilis', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_automobilis" name="fk_automobilis" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// išrenkame automobilius
				$cars = $carsObj->getCarList();
				foreach($cars as $key => $val) {
					$selected = "";
					if(isset($data['fk_Mantijanr']) && $data['fk_Mantijanr'] == $val['id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['nr']}'>{$val['dydis']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
	<label for="fk_automobilis">Automobilis<?php echo in_array('fk_automobilis', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_automobilis" name="fk_automobilis" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// išrenkame automobilius
				$cars = $carsObj->getCarList();
				foreach($cars as $key => $val) {
					$selected = "";
					if(isset($data['fk_Mantijanr']) && $data['fk_Mantijanr'] == $val['id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['nr']}'>{$val['galvos_dydis']}</option>";
				}
			?>
		</select>
	</div>


	

	

	<?php if(isset($data['nr'])) { ?>
			<input type="hidden" name="nr" value="<?php echo $data['nr']; ?>" />
	<?php } ?>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>