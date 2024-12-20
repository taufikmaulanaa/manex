<?php
// $gtotal = array_fill(0, 4, 0);
$monthly_totals = array_fill(0, 12, array_fill(0, 4, 0));

// // Define months array
// $months = array(
//     'jan' => array_fill(0, 4, 0),
//     'feb' => array_fill(0, 4, 0),
//     'mar' => array_fill(0, 4, 0),
//     'apr' => array_fill(0, 4, 0),
//     'may' => array_fill(0, 4, 0),
//     'jun' => array_fill(0, 4, 0),
//     'jul' => array_fill(0, 4, 0),
//     'aug' => array_fill(0, 4, 0),
//     'sep' => array_fill(0, 4, 0),
//     'oct' => array_fill(0, 4, 0),
//     'nov' => array_fill(0, 4, 0),
//     'dec' => array_fill(0, 4, 0)
// );

$bgedit = '#A9A9A9';
$contentedit = 'false';

foreach ($budget_sales as $key => $value) {
	$bgedit = '#A9A9A9';
	$contentedit = 'false';

    echo "<tr>
		<td><b>$key</b></td>
		<td><b>$key</b></td>";

	for( $i = 1; $i <= 12; $i++ ){
		echo '<td style="background: ' . $bgedit . '"><div style="background:' . $bgedit . '" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="' . $contentedit . '"></td>';
	}

	echo '<td style="background: ' . $bgedit . '"><div style="background:' . $bgedit . '" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="' . $contentedit . '"></td>';

	echo "</tr>";
    
    foreach ($value as $sub_key => $sub_value) {
		$bgedit = '#A9A9A9';
		$contentedit = 'false';
        // Print sub key (e.g., Basic Solution) in second row
        echo "<tr>
			<td class='sub-1'><b>$sub_key</b></td>
			<td><b>$sub_key</b></td>";

		for( $i = 1; $i <= 12; $i++ ){
			echo '<td style="background: ' . $bgedit . '"><div style="background:' . $bgedit . '" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="' . $contentedit . '"></td>';
		}

		echo '<td style="background: ' . $bgedit . '"><div style="background:' . $bgedit . '" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="' . $contentedit . '"></td>';
	
		echo "</tr>";
        
        foreach ($sub_value as $item_key => $item_value) {
			$bgedit = '#A9A9A9';
			$contentedit = 'false';
			// Print description for each product in third row
			echo "<tr>
				<td class='sub-2'><b>$item_key</b></td>
				<td><b>$item_key</b></td>";

			for( $i = 1; $i <= 12; $i++ ){
				echo '<td style="background: ' . $bgedit . '"><div style="background:' . $bgedit . '" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="' . $contentedit . '"></td>';
			}
	
			echo '<td style="background: ' . $bgedit . '"><div style="background:' . $bgedit . '" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="' . $contentedit . '"></td>';
		
			echo "</tr>";

			foreach($item_value as $product){
				$bgedit = '';
				$contentedit = 'true';

				// Print description for each product in third row
				echo "<tr>
					<td class='sub-2'>{$product['description']}</td>
					<td>{$product['code']}</td>";
				
				for( $i = 1; $i <= 12; $i++ ){
					$field = 'B_' . sprintf('%02d', $i);
					// $x = ($contentedit == 'true' ? number_format($item[$field]) : '');
					$x = number_format($product[$field]);
	
					echo '<td style="background: ' . $bgedit . '"><div style="background:' . $bgedit . '" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="' . $contentedit . '" class="edit-value text-right budget ' . $field . '" data-name="' . $field . '" data-id="' . $product['id'] . '">' . $x . '</td>';
				}
	
				echo '<td style="background: ' . $bgedit . '"><div style="background:' . $bgedit . '" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="false" class="edit-value text-right total_budget" data-name="total_budget" data-id="' . $product['id'] . '"></td>';
	
				echo "</tr>";
			}
        }
    }
}
?>
<tr>
    <th colspan="2"><b>TOTAL</b></th>
    <?php
	$count = 0;
    foreach ($monthly_totals as $month_total) {
		$count++;
        echo '<td><div class="text-right total_budget_monthly" id=totalB'.sprintf('%02d', $count).' contenteditable="false">0</div></td>';
    }
    // Print grand total
	echo '<td><div class="text-right grand_total" id="grand_total" contenteditable="false">0</div></td>';
    // echo '<td>' . number_format(array_sum($gtotal)) . '</td>';
    ?>
</tr>
