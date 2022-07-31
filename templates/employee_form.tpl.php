<<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Saskaita</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Saskaitos redagavimas"; else echo "Nauja saskaita"; ?></li>
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
		<label for="fk_Sutartisnr">Sutartis<?php echo in_array('fk_Sutartisnr ', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_Sutartisnr" name="fk_Sutartisnr " class="form-select form-control">
			<option value="-1">Pasirinkite sutarties nr</option>
			<?php
				// išrenkame visas markes
				$brands = $employeeObj -> getList();
				echo $brands;
				foreach($brands as $key => $val) {
					$selected = "";
					if(isset($data['fk_Sutartisnr']) && $data['fk_Sutartisnr'] == $val['nr']) {
						$selected = "selected='selected'";
					}
					echo "<option{$selected} value='{$val['nr']}'>{$val['sutarties_data']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="data">data<?php echo in_array('	data', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="data" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="data" class="form-control datepicker" value="<?php echo isset($data['data']) ? $data['data'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="suma">suma<?php echo in_array('suma', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="suma" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="suma" class="form-control" value="<?php echo isset($data['suma']) ? $data['suma'] : ''; ?>">
	</div>


	<?php if(isset($data['nr'])) { ?>
		<input type="hidden" name="nr" value="<?php echo $data['nr']; ?>" />
	<?php } ?>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>