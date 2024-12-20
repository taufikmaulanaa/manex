
<?php 

foreach($grup as $g) { ?>
    <tr>
    <td colspan="2"><b><?php echo $g['cost_centre'] . ' - '. $g['cost_centre_name']; ?></b></td>
    </tr>
    <?php
    $nomor = 0;
    foreach($record as $u) { 
    if($u['cost_centre'] == $g['cost_centre']){
    $nomor++;
    ?>
    <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $u['description'];?></td>
        <td><?php echo $u['account_code']; ?></td>
        <td><?php echo $u['account_name']; ?></td>
        <td><div style="background:''" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="true" class="edit-value sub_account" data-name="sub_account" data-id="<?php echo $u['id'] ;?>" data-value="<?php echo $u['sub_account'] ;?>"><?php echo $u['sub_account']; ?></td>
        <td><?php echo $u['sub_account_name']; ?></td>
        <?php
        for ($i = 1; $i <= 12; $i++) { 
            $field = 'B_' . sprintf('%02d', $i);
            ?>
            <!-- <td class="text-right"><?php echo number_format($u[$field]); ?></td> -->
            <td style="background: ''"><div style="background:''" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="true" class="edit-value text-right budget <?php echo $field ;?>" data-name="<?php echo $field ;?>" data-id="<?php echo $u['id'] ;?>" data-value="<?php echo $u[$field] ;?>"><?php echo number_format($u[$field]) ;?></td>

        <?php 
        }
        ?>
        <!-- <td class="text-right"><?php echo number_format($u['total']); ?></td> -->
        <td style="background: ''"><div style="background:''" style="min-height: 10px; width: 50px; overflow: hidden;" contenteditable="false" class="text-right" data-name="total" data-id="<?php echo $u['id'] ;?>" data-value="<?php echo $u['total'] ;?>"><?php echo number_format($u['total']) ;?></td>

    
    </tr>
    <?php }} ?>
<?php } ?>