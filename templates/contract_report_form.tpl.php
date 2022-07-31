<?php
	// suformuojame puslapių kelio (breadcrumb) elementų masyvą
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Pradžia'), array('link' => "index.php?module=report&action=list", 'title' => "Ataskaitos"), array("title" => "Sutarčių ataskaita"));
	
	// puslapių kelio šabloną
	include 'templates/common/breadcrumb.tpl.php';
?>

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
		<label for="kainaNuo">Sutartys sudarytos nuo</label>
		<input type="text" id="kainaNuo" name="kainaNuo" class="form-control" value="<?php echo isset($data['kaina']) ? $data['kaina'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="kainaIki">Sutartys sudarytos iki</label>
		<input type="text" id="kainaIki" name="kainaIki" class="form-control" value="<?php echo isset($data['kaina']) ? $data['kaina'] : ''; ?>">
	</div>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Sudaryti ataskaitą">
</form>