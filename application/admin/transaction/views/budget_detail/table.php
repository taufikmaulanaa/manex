<?php 
$gtotal0 = 0;
$gtotal1 = 0;
$gtotal2 = 0;
$gtotal3 = 0;

$jan0 = 0;
$jan1 = 0;
$jan2 = 0;
$jan3 = 0;

$feb0 = 0;
$feb1 = 0;
$feb2 = 0;
$feb3 = 0;

$mar0 = 0;
$mar1 = 0;
$mar2 = 0;
$mar3 = 0;

$apr0 = 0;
$apr1 = 0;
$apr2 = 0;
$apr3 = 0;

$may0 = 0;
$may1 = 0;
$may2 = 0;
$may3 = 0;

$jun0 = 0;
$jun1 = 0;
$jun2 = 0;
$feb3 = 0;

$jul0 = 0;
$jul1 = 0;
$jul2 = 0;
$jul3 = 0;

$aug0 = 0;
$aug1 = 0;
$aug2 = 0;
$aug3 = 0;

$sep0 = 0;
$sep1 = 0;
$sep2 = 0;
$sep3 = 0;

$oct0 = 0;
$oct1 = 0;
$oct2 = 0;
$oct3 = 0;

$nov0 = 0;
$nov1 = 0;
$nov2 = 0;
$nov3 = 0;

$dec0 = 0;
$dec1 = 0;
$dec2 = 0;
$dec3 = 0;


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

			$field0 = '';
			for ($i = 1; $i <= 12; $i++) { 
				$field0 = 'B_' . sprintf('%02d', $i);
				$x0 = ($contentedit == 'true' ? number_format($m0->$field0) : '');
				$xtotal0 = ($contentedit == 'true' ? number_format($m0->total_budget) : '');

				echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right budget '.$field0.'" data-name="'.$field0.'" data-id="'.$m0->id_trx.'" data-value="'.$x0.'">'.$x0.'</td>';
			}
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m0->id_trx.'" data-value="'.$xtotal0.'">'.$xtotal0.'</td>';
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m0->id_trx.'" data-value="'.$m0->actual.'">'.$m0->actual.'</td>';
			$gtotal0 += $m0->total_budget; 
			$jan0 += $m0->B_01;
			$feb0 += $m0->B_02;
			$mar0 += $m0->B_03;
			$apr0 += $m0->B_04;
			$may0 += $m0->B_05;
			$jun0 += $m0->B_06;
			$jul0 += $m0->B_07;
			$aug0 += $m0->B_08;
			$sep0 += $m0->B_09;
			$oct0 += $m0->B_10;
			$nov0 += $m0->B_11;
			$dec0 += $m0->B_12;
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
			for ($i = 1; $i <= 12; $i++) { 
				$field1 = 'B_' . sprintf('%02d', $i);
				$x1 =  ($contentedit == 'true' ? number_format($m1->$field1) : '');
				$xtotal1 = ($contentedit == 'true' ? number_format($m1->total_budget) : '');

				echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right budget '.$field1.'" data-name="'.$field1.'" data-id="'.$m1->id_trx.'" data-value="'.$x1.'">'.$x1.'</td>';
			}
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m1->id_trx.'" data-value="'.$xtotal1.'">'.$xtotal1.'</td>';
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m1->id_trx.'" data-value="'.$m1->actual.'">'.$m1->actual.'</td>';

			$gtotal1 += $m1->total_budget; 
			$jan1 += $m1->B_01;
			$feb1 += $m1->B_02;
			$mar1 += $m1->B_03;
			$apr1 += $m1->B_04;
			$may1 += $m1->B_05;
			$jun1 += $m1->B_06;
			$jul1 += $m1->B_07;
			$aug1 += $m1->B_08;
			$sep1 += $m1->B_09;
			$oct1 += $m1->B_10;
			$nov1 += $m1->B_11;
			$dec1 += $m1->B_12;
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

			for ($i = 1; $i <= 12; $i++) { 
				$field2 = 'B_' . sprintf('%02d', $i);
				$x2 =  ($contentedit == 'true' ? number_format($m2->$field2) : '');
				$xtotal2 = ($contentedit == 'true' ? number_format($m2->total_budget) : '');
	
				echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right budget '.$field2.'" data-name="'.$field2.'" data-id="'.$m2->id_trx.'" data-value="'.$x2.'">'.$x2.'</td>';
			}
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m2->id_trx.'" data-value="'.$xtotal2.'">'.$xtotal2.'</td>';
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m2->id_trx.'" data-value="'.$m2->actual.'">'.$m2->actual.'</td>';

			$gtotal2 +=  $m2->total_budget;
			$jan2 += $m2->B_01;
			$feb2 += $m2->B_02;
			$mar2 += $m2->B_03;
			$apr2 += $m2->B_04;
			$may2 += $m2->B_05;
			$jun2 += $m2->B_06;
			$jul2 += $m2->B_07;
			$aug2 += $m2->B_08;
			$sep2 += $m2->B_09;
			$oct2 += $m2->B_10;
			$nov2 += $m2->B_11;
			$dec2 += $m2->B_12;
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

					for ($i = 1; $i <= 12; $i++) { 
						$field3 = 'B_' . sprintf('%02d', $i);
						$x3 =  ($contentedit == 'true' ? number_format($m3->$field3) : '');
						$xtotal3 = ($contentedit == 'true' ? number_format($m3->total_budget) : '');

						echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right budget '.$field3.'" data-name="'.$field3.'" data-id="'.$m3->id_trx.'" data-value="'.$x3.'">'.$x3.'</td>';
					}
					echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m3->id_trx.'" data-value="'.$xtotal3.'">'.$xtotal3.'</td>';
					echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m3->id_trx.'" data-value="'.$m3->actual.'">'.$m3->actual.'</td>';

					$gtotal3 += $m3->total_budget;
					$jan3 += $m3->B_01;
					$feb3 += $m3->B_03;
					$mar3 += $m3->B_03;
					$apr3 += $m3->B_04;
					$may3 += $m3->B_05;
					$jun3 += $m3->B_06;
					$jul3 += $m3->B_07;
					$aug3 += $m3->B_08;
					$sep3 += $m3->B_09;
					$oct3 += $may3->B_10;
					$nov3 += $m3->B_11;
					$dec3 += $m3->B_12;

			?>
				</tr>
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>

	<tr>
		<th colspan="2"><b>TOTAL</b></th>
		<?php
		$totalmonth = '' ;
		for ($i = 1; $i <= 12; $i++) { 
			$totalmonth = 'totalmonth_' . $i;
			$totalmonth = 0;
			if($i ==1) $totalmonth = $jan0+$jan1+$jan2+$jan3;
			if($i ==2) $totalmonth = $feb0+$jfeb1+$feb2+$feb3;
			if($i ==3) $totalmonth = $mar0+$mar1+$mar2+$mar3;
			if($i ==4) $totalmonth = $apr0+$apr1+$apr2+$apr3;
			if($i ==5) $totalmonth = $may0+$may1+$may2+$may3;
			if($i ==6) $totalmonth = $jun0+$jun1+$jun2+$jun3;
			if($i ==7) $totalmonth = $jul0+$jul1+$jul2+$jul3;
			if($i ==8) $totalmonth = $jaug0+$aug1+$aug2+$aug3;
			if($i ==9) $totalmonth = $sep0+$sep1+$sep2+$sep3;
			if($i ==10) $totalmonth = $oct0+$oct1+$oct2+$oct3;
			if($i ==11) $totalmonth = $nov0+$nov1+$nov2+$nov3;
			if($i ==12) $totalmonth = $dec0+$dec1+$dec2+$dec3;
			?>
			<td><?php echo number_format($totalmonth);?></td>
			<?php
		}
		$grantotal = $gtotal0+$gtotal1+$gtotal2+$gtotal3;
		$grantotal_actual = 0;
		echo '<td style="background:"><div style="background:" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="false" class="edit-value text-right"  data-id="" data-value="">'.number_format($grantotal).'</td>';
		echo '<td style="background:"><div style="background:" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="false" class="edit-value text-right"  data-id="" data-value="">'.number_format($grantotal_actual).'</td>';

		?>	
	
	</tr>





			
