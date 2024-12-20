<?php 
//debug($dtx_core2018);die;
	$hno = 0;
	foreach($grup[0] as $m0) { 
	$hno++;
	$v = '';
	$vt = '';
	for ($i = 1; $i <= 12; $i++) { 
		$v = 't_'. 'b'.sprintf("%02d", $i);
		$vt = 'tdpk' . 'b'.sprintf("%02d", $i);
		$$v = 0;
		$$vt = 0;
	}	


	$t_tahun=0;
	$t_d01=0;

	$total =0;
	$no=0;
    ?>
		<tr>
			<th colspan="8" style="background: #757575;" style="min-height: 10px; width: 50px; overflow: hidden;"><font color="#fff"><?php echo $m0->group_department; ?></font></th>
		</tr>		
  <?php
	$mtahun = '';
	$cetakno ='';	


	foreach($cc[$m0->id] as $m2 => $m1) { 
		// debug($m1->product_name);die;
		// debug(isset($m1['product_name']) ? $m1['product_name'] : '');die;
			$no++;
						
			$B = '';
			for ($i = 1; $i <= 12; $i++) { 
				$v = 't_'. 'b'.sprintf("%02d", $i);
				$B = 'B_'. sprintf("%02d", $i);
			}
				
	
	

		$bgedit ="";
		$contentedit ="false" ;
		$id = 'id';

		?>
		<tr>

			<td><?php echo isset($m1->kode) ? $m1->kode : ''; ?></td>
			<td><?php echo isset($m1->abbreviation) ? $m1->abbreviation : ''; ?></td>
			<td><?php echo isset($m1->cost_centre) ? $m1->cost_centre : ''; ?></td>
			<?php


			// for ($i = 1; $i <= 12; $i++) { 

			// 	$rbulan = '';
			// 	$rtahun = '';
				$bgedit ="";
				$contentedit ="true" ;
			// 	$id ="";

			// 	// debug($rencana);die;

			// 	$v_field  = 'B_' . sprintf("%02d", $i);

				
			

			// 	// $field_v = custom_format(view_report($m1->$v_field));
			$checked1 = '';
			$checked2 = '';
			$checked3 = '';
			if($m1->user_level == 3){
				$checked3 = 'checked';
			}else{
				$checked3 = '';
			}

			if($m1->user_level == 2){
				$checked2 = 'checked';
			}else{
				$checked2 = '';
			}

			if($m1->user_level == 1){
				$checked1 = 'checked';
			}else{
				$checked1 = '';
			}


			
			echo '<td class="text-center">';
			echo '<div class="custom-checkbox custom-control">';
			echo '<input class="custom-control-input chk" type="checkbox" id="chk-div-'.$m1->id.'" name="div['.$m1->id.']" value="1" '.$checked1.' >';
			echo '<label class="custom-control-label" for="chk-div-'.$m1->id.'">&nbsp;</label></div>';
			echo '</td>';

			echo '<td class="text-center">';
			echo '<div class="custom-checkbox custom-control">';
			echo '<input class="custom-control-input chk" type="checkbox" id="chk-dep-'.$m1->id.'" name="dep['.$m1->id.']" value="1" '.$checked2.' >';
			echo '<label class="custom-control-label" for="chk-dep-'.$m1->id.'">&nbsp;</label></div>';
			echo '</td>';
			
			echo '<td class="text-center">';
			echo '<div class="custom-checkbox custom-control">';
			echo '<input class="custom-control-input chk" type="checkbox" id="chk-sec-'.$m1->id.'" name="sec['.$m1->id.']" value="1" '.$checked3.'>';
			echo '<label class="custom-control-label" for="chk-sec-'.$m1->id.'">&nbsp;</label></div>';
			echo '</td>';

			// echo '<td style="background: '.$bgedit.'"><div style="background:'.$bgedit.'" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="'.$contentedit.'" contenteditable="true" class="edit-value text-right" data-name="" data-id="" data-value=""</div></td>';
	


			// }
			?>

			<td style="width:1px; white-space: nowrap;">							
			<select class="select2 filter infinity" style="width: 350px;" multiple data-width="200" name="user_pic[<?php echo $m1->id; ?>][]"> 
				<?php $user1 = json_decode($m1->user_id, true); 
				$selected = '';
				?>
				<?php foreach ($user as $v) 
				{
					if(in_array($v['id'],$user1)) {
						$selected = 'selected';
					}else{
						$selected = '';
					}
					echo '<option value="'.$v['id'].'" '.$selected.'>'.trim($v['nama']).'</option>';
				} ?>
			</select>
			</td>

		</tr>
	<?php 
	$t_tahun = 0;
	} ?>

<?php } ?>
			