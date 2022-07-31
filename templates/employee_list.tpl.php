<?php
	// suformuojame puslapių kelio (breadcrumb) elementų masyvą
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Pradžia'), array('title' => 'Saskaitos'));
	
	// puslapių kelio šabloną
	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Saskaita nauja</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
	Saskaitos nebuvo pašalintas. Pirmiausia pašalinkite saskaitos nr sutartyje.
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Data</th>
		<th>Suma</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['nr']}</td>"
					. "<td>{$val['data']}</td>"
					. "<td>{$val['suma']}</td>"
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