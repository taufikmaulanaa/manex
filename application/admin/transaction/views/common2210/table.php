<?php 
	$no = 0;
	foreach($factory as $m1) { 
		$no++;

		$bgedit ="";
		$contentedit ="false" ;
		$id = 'id';

		?>
		<tr>
			<td><?php echo isset($m1->cost_centre) ? $m1->cost_centre : ''; ?></td>
			<td><?php echo isset($m1->cost_centre_name) ? $m1->cost_centre_name : ''; ?></td>
			<?php

			$bgedit ="";
			$contentedit ="true" ;
			echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right" data-name="prsn_aloc" data-id="'.$m1->id.'" data-value="'.$m1->prsn_aloc.'"</div>'.custom_format($m1->prsn_aloc,false,2).'</td>';
		
			?>

		</tr>
	<?php 
	$t_tahun = 0;
	} ?>

<tr>
	<?php
	echo '<td colspan ="2"><div style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="false" class="text-centre"><b>TOTAL</b></div></td>';
	echo '<td></d>'
?>
</tr>

			
