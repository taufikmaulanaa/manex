<tr>
	<td><b>% Idlle Cost (Fixed FOH)</b></td>
</tr>
<?php 
foreach($mst_account[0] as $m0) { 
	?>
	<tr>
		<td><b><?php echo strtoupper($m0->grup); ?></b></td>
	</tr>

	<?php 
	foreach($mst_account[$m0->grup] as $m1) { 
		foreach($total_budget as $v => $t){
			if($m1->account_code == $v) {
		?>
		<tr>
			<td class="sub-1"><b><?php echo $m1->account_code . '-' .$m1->account_name; ?></b></td>
			<?php
						foreach($production as $p) { 

							$x1 =  0;
							$xtotal1 = 0;
			
							echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right budget '.$field1.'" data-name="'.$field1.'" data-id="'.$m1->id_trx.'" data-value="'.$x1.'">'.$x1.'</td>';
						}
						echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m1->id_trx.'" data-value="'.$xtotal1.'">'.$xtotal1.'</td>';
			
			?>
		</tr>
		<?php 
		 ?>
         
	<?php }}} ?>
    <tr>
        <td><b><?php echo 'TOTAL ' . strtoupper($m0->grup);?></b></td>
        <?php
      			foreach($production as $p) { 

					$x1 =  0;
					$xtotal1 = 0;
	
					echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right budget '.$field1.'" data-name="'.$field1.'" data-id="'.$m1->id_trx.'" data-value="'.$x1.'">'.$x1.'</td>';
				}
				echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right total_budget" data-name="total_budget" data-id="'.$m1->id_trx.'" data-value="'.$xtotal1.'">'.$xtotal1.'</td>';
	
        ?>
    </tr>
 
<?php } ?>


	





			
