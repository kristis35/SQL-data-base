<?php
	// suformuojame puslapių kelio (breadcrumb) elementų masyvą
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Pradžia'), array('title' => 'Mantija'));
	
	// puslapių kelio šabloną
	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas mantija</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Mantija nebuvo pašalinta, nes yra įtrauktas į sutartį (-is).
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>aukstoji_mokykla</th>
		<th>dydis</th>
		<th>galvos_dydis</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['nr']}</td>"
					. "<td>{$val['aukstoji_mokykla']}</td>"
					. "<td>{$val['dydis']}</td>"
					. "<td>{$val['galvos_dydis']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['nr']}'>redaguoti</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['nr']}\"); return false;'>šalinti</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// įtraukiame puslapių šabloną
	include 'templates/common/paging.tpl.php';
?>