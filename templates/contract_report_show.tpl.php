<ul id="reportInfo">
	<li class="title">Sudarytų sutarčių ataskaita</li>
	<li>Sudarymo data: <span><?php echo date("Y-m-d"); ?></span></li>
	<li>Sutarčių kainos :
		<span>
		<?php
			if(!empty($data['kainaNuo'])) {
				if(!empty($data['kainaIki'])) {
					echo "nuo {$data['kainaNuo']} iki {$data['kainaIki']}";
				} else {
					echo "nuo {$data['kainaNuo']}";
				}
			} else {
				if(!empty($data['kainaIki'])) {
					echo "iki {$data['kainaIki']}";
				} else {
					echo "nenurodyta";
				}
			}
		?>
		</span>
	</li>
</ul>
<?php
	if(sizeof($contractData) > 0) { ?>
		<table class="table">
			<thead>	
				<tr>
					<th>Sutartis</th>
					<th>Data</th>
					<th>Sudarytų sutarčių vertė</th>
					<th>Užsakyta paslaugų vertė</th>
				</tr>
			</thead>

			<tbody>
				<?php
					// suformuojame lentelę
					for($i = 0; $i < sizeof($contractData); $i++) {
						
						if($i == 0 || $contractData[$i]['nr'] != $contractData[$i-1]['nr']) {
							echo
								"<tr class='table-primary'>"
									. "<td colspan='4'>{$contractData[$i]['vardas']} {$contractData[$i]['pavarde']}</td>"
								. "</tr>";
						}
						
						if($contractData[$i]['sutarties_paslaugu_kaina'] == 0) {
							$contractData[$i]['sutarties_paslaugu_kaina'] = "neužsakyta";
						} else {
							$contractData[$i]['sutarties_paslaugu_kaina'] .= " &euro;";
						}
						
						echo
							"<tr>"
								. "<td>#{$contractData[$i]['nr']}</td>"
								. "<td>{$contractData[$i]['sutarties_data']}</td>"
								. "<td>{$contractData[$i]['sutarties_kaina']} &euro;</td>"
								. "<td>{$contractData[$i]['sutarties_paslaugu_kaina']}</td>"
							. "</tr>";
						if($i == (sizeof($contractData) - 1) || $contractData[$i]['nr'] != $contractData[$i+1]['nr']) {
							if($contractData[$i]['bendra_kliento_paslaugu_kaina'] == 0) {
								$contractData[$i]['bendra_kliento_paslaugu_kaina'] = "neužsakyta";
							} else {
								$contractData[$i]['bendra_kliento_paslaugu_kaina'] .= " &euro;";
							}
							
							echo 
								"<tr>"
									. "<td colspan='2'></td>"
									. "<td>{$contractData[$i]['bendra_kliento_sutarciu_kaina']} &euro;</td>"
									. "<td>{$contractData[$i]['bendra_kliento_paslaugu_kaina']}</td>"
								. "</tr>";
						}
					}
				?>
				
				<tr>
					<td colspan='4'>Bendra suma</td>
				</tr>
				
				<tr>
					<td colspan="2"></td>
					<td><?php echo $totalPrice[0]['nuomos_suma']; ?> &euro;</td>
					<td>
						<?php
							if($totalServicePrice[0]['paslaugu_suma'] == 0) {
								$totalServicePrice[0]['paslaugu_suma'] = "neužsakyta";
							} else {
								$totalServicePrice[0]['paslaugu_suma'] .= " &euro;";
							}
							
							echo $totalServicePrice[0]['paslaugu_suma'];
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<a href="index.php?module=contract&action=report" title="Nauja ataskaita" style="margin-bottom: 15px" class="button large float-right">nauja ataskaita</a>
<?php   
	} else {
?>
		<div class="warningBox">
			Nurodytu kainomis sutarčių sudaryta nebuvo.
		</div>
<?php
	}
?>