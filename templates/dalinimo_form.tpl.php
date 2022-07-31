<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Dalinimo vieta</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Dalinimo vietos redagavimas"; else echo "Nauja Dalinimo vieta"; ?></li>
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
		<label for="brand">Miesto pavadinimas<?php echo in_array('fk_Miestasid', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="brand" name="fk_Miestasid" class="form-select form-control">
			<option value="-1">Pasirinkite miesta</option>
			<?php
				// išrenkame visas markes
				$brands = $brandsObj->getBrandList();
				foreach($brands as $key => $val) {
					$selected = "";
					if(isset($data['fk_Miestasid']) && $data['fk_Miestasid'] == $val['id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id']}'>{$val['pavadinimas']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="kabineto_nr">kabineto_nr<?php echo in_array('kabineto_nr', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="kabineto_nr" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="kabineto_nr" class="form-control" value="<?php echo isset($data['kabineto_nr']) ? $data['kabineto_nr'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="adresas">adresas<?php echo in_array('adresas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="adresas" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="adresas" class="form-control" value="<?php echo isset($data['adresas']) ? $data['adresas'] : ''; ?>">
	</div>


	<?php if(isset($data['id'])) { ?>
		<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
	<?php } ?>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>