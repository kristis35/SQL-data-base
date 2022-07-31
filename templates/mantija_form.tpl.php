<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Mantijos</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Mantijos redagavimas"; else echo "Nauja mantija"; ?></li>
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
		<label for="aukstoji_mokykla">aukstoji_mokykla<?php echo in_array('aukstoji_mokykla', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="aukstoji_mokykla" name="aukstoji_mokykla" class="form-control" value="<?php echo isset($data['aukstoji_mokykla']) ? $data['aukstoji_mokykla'] : ''; ?>">
    </div>

    <div class="form-group">
					<label for="dydis">dydis<?php echo in_array('dydis', $required) ? '<span> *</span>' : ''; ?></label>
					<select id="dydis" name="dydis" class="form-select form-control">
					<option value="-1">---------------</option>
					<?php
						// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
						$gearboxes = $carsObj->getGearboxList();
						foreach($gearboxes as $key => $val) {
							$selected = "";
							if(isset($data['dydis']) && $data['dydis'] == $val['id']) {
							$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
					</select>
    

					<label for="galvos_dydis">galvos_dydis<?php echo in_array('galvos_dydis', $required) ? '<span> *</span>' : ''; ?></label>
					<select id="galvos_dydis" name="galvos_dydis" class="form-select form-control">
						<option value="-1">---------------</option>
						<?php
						// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
						$fueltypes = $carsObj->getFuelTypeList();
						foreach($fueltypes as $key => $val) {
							$selected = "";
							if(isset($data['galvos_dydis']) && $data['galvos_dydis'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
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
    </div>
</form>
