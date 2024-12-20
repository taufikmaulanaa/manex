<?php 
$gtotal0 = 0;
$gtotal1 = 0;
$gtotal2 = 0;
$gtotal3 = 0;

foreach($mst_account[0] as $m0) { 
	
	if(count(@$mst_account[$m0->id]) >=1 || empty($m0->id_trx)) {
		$bgedit ="#A9A9A9";
		$contentedit ="false" ;
	}else{
		$bgedit ="";
		$contentedit ="true" ;
	}
	
	?>
	<tr>
		<td><b><?php echo $m0->account_code . '-' .$m0->account_name; ?></b></td>
		<td><?php echo $m0->account_code ; ?></td>
			
			<?php
			$x0 = ($contentedit == 'true' ? number_format($m0->total_actual) : '');
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_actual" data-name="total_actual" data-id="'.$m0->id_trx.'" data-value="'.$m0->total_actual.'">'.$x0.'</td>';
			$gtotal0 += $m0->total_actual; 

			?>
	</tr>
 
	<?php 
	foreach($mst_account[$m0->id] as $m1) { 

		if(count(@$mst_account[$m1->id]) >=1 || empty($m1->id_trx)) {
			$bgedit ="#A9A9A9";
			$contentedit ="false" ;
		}else{
			$bgedit ="";
			$contentedit ="true" ;
		}

		?>

		<tr>
			<td class="sub-1"><b><?php echo $m1->account_code . '-' .$m1->account_name; ?></b></td>
			<td><?php echo $m1->account_code ; ?></td>
			<?php
			$x1 = ($contentedit == 'true' ? number_format($m1->total_actual) : '');
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_actual" data-name="total_actual" data-id="'.$m1->id_trx.'" data-value="'.$m1->total_actual.'">'.$x1.'</td>';

			$gtotal1 += $m1->total_actual; 

			?>
		</tr>
		<?php 
		foreach($mst_account[$m1->id] as $m2) { 
					if(count(@$mst_account[$m2->id]) >=1 || empty($m2->id_trx)) {
						$bgedit ="#A9A9A9";
						$contentedit ="false" ;
					}else{
						$bgedit ="";
						$contentedit ="true" ;
					}
			
			?>
			<tr>
				<td class="sub-2"><?php echo $m2->account_code . '-' .$m2->account_name; ?></td>
				<td><?php echo $m2->account_code ; ?></td>
				<?php
			$x2 = ($contentedit == 'true' ? number_format($m2->total_actual) : '');
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_actual" data-name="total_actual" data-id="'.$m2->id_trx.'" data-value="'.$m2->total_actual.'">'.$x2.'</td>';

			$gtotal2 +=  $m2->total_actual;

			?>
			</tr>
			
			<?php 
			foreach($mst_account[$m2->id] as $m3) { 
				
				if(count(@$mst_account[$m3->id]) >=1 || empty($m3->id_trx)) {
					$bgedit ="#A9A9A9";
					$contentedit ="false" ;
				}else{
					$bgedit ="";
					$contentedit ="true" ;
				}

				?>
				<tr>
					<td class="sub-3"><?php echo $m3->account_code . '-' .$m3->account_name; ?></td>
					<td><?php echo $m3->account_code ; ?></td>
					<?php
					$x3 = ($contentedit == 'true' ? number_format($m3->total_actual) : '');
					echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_actual" data-name="total_actual" data-id="'.$m3->id_trx.'" data-value="'.$m3->total_actual.'">'.$x3.'</td>';

					$gtotal3 += $m3->total_actual;


			?>
				</tr>
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>

	<tr>
		<th colspan="2"><b>TOTAL</b></th>
		<?php
		echo '<td style="background:"><div style="background:" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="false" class="edit-value text-right"  data-id="" data-value="">'.number_format($grantotal_actual).'</td>';

		?>	
	
	</tr>





			
