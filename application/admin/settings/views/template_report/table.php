<?php foreach($template_report[0] as $m0) { ?>
	<tr>
		<td><b><?php echo $m0->account_code . '-' .$m0->account_name; ?></b></td>
		<td><?php echo $m0->description; ?></td>
		<td><?php echo $m0->sum_of; ?></td>
		<td class="text-center"><?php echo $m0->account_code; ?></td>
		<td class="text-center"><?php echo $m0->urutan; ?></td>
		<td class="text-center"><?php echo $m0->is_active ? '<span class="badge badge-success">TRUE</span>' : '<span class="badge badge-danger">FALSE</span>' ; ?></td>
		<td class="button">
			<?php if($access_edit && user('id_group') == 1 && ENVIRONMENT == 'development') { ?>
			<button type="button" class="btn btn-warning btn-input" data-key="edit" data-id="<?php echo $m0->id; ?>" title="<?php echo lang('ubah'); ?>"><i class="fa-edit"></i></button>
			<?php } if($access_delete && user('id_group') == 1 && ENVIRONMENT == 'development') { ?>
			<button type="button" class="btn btn-danger btn-delete" data-key="delete" data-id="<?php echo $m0->id; ?>" title="<?php echo lang('hapus'); ?>"><i class="fa-trash-alt"></i></button>
			<?php } ?>
		</td>
	</tr>
	<?php foreach($template_report[$m0->id] as $m1) { ?>
		<tr>
			<td class="sub-1"><b><?php echo $m1->account_code . '-' .$m1->account_name; ?></b></td>
			<td><?php echo $m1->description; ?></td>
			<td><?php echo $m1->sum_of; ?></td>
			<td class="text-center"><?php echo $m1->account_code; ?></td>
			<td class="text-center"><?php echo $m1->urutan; ?></td>
			<td class="text-center"><?php echo $m1->is_active ? '<span class="badge badge-success">TRUE</span>' : '<span class="badge badge-danger">FALSE</span>' ; ?></td>
			<td class="button">
				<?php if($access_edit && user('id_group') == 1 && ENVIRONMENT == 'development') { ?>
				<button type="button" class="btn btn-warning btn-input" data-key="edit" data-id="<?php echo $m1->id; ?>" title="<?php echo lang('ubah'); ?>"><i class="fa-edit"></i></button>
				<?php } if($access_delete && user('id_group') == 1 && ENVIRONMENT == 'development') { ?>
				<button type="button" class="btn btn-danger btn-delete" data-key="delete" data-id="<?php echo $m1->id; ?>" title="<?php echo lang('hapus'); ?>"><i class="fa-trash-alt"></i></button>
				<?php } ?>
			</td>
		</tr>
		<?php foreach($template_report[$m1->id] as $m2) { ?>
			<tr>
				<td class="sub-2"><?php echo $m2->account_code . '-' .$m2->account_name; ?></td>
				<td><?php echo $m2->description; ?></td>
				<td><?php echo $m2->sum_of; ?></td>
				<td class="text-center"><?php echo $m2->account_code; ?></td>
				<td class="text-center"><?php echo $m2->urutan; ?></td>
				<td class="text-center"><?php echo $m2->is_active ? '<span class="badge badge-success">TRUE</span>' : '<span class="badge badge-danger">FALSE</span>' ; ?></td>
				<td class="button">
					<?php if($access_edit && user('id_group') == 1 && ENVIRONMENT == 'development') { ?>
					<button type="button" class="btn btn-warning btn-input" data-key="edit" data-id="<?php echo $m2->id; ?>" title="<?php echo lang('ubah'); ?>"><i class="fa-edit"></i></button>
					<?php } if($access_delete && user('id_group') == 1 && ENVIRONMENT == 'development') { ?>
					<button type="button" class="btn btn-danger btn-delete" data-key="delete" data-id="<?php echo $m2->id; ?>" title="<?php echo lang('hapus'); ?>"><i class="fa-trash-alt"></i></button>
					<?php } ?>
				</td>
			</tr>
			<?php foreach($template_report[$m2->id] as $m3) { ?>
				<tr>
					<td class="sub-3"><?php echo $m3->account_code . '-' .$m3->account_name; ?></td>
					<td><?php echo $m3->description; ?></td>
					<td><?php echo $m3->sum_of; ?></td>
					<td class="text-center"><?php echo $m3->account_code; ?></td>
					<td class="text-center"><?php echo $m3->urutan; ?></td>
					<td class="text-center"><?php echo $m3->is_active ? '<span class="badge badge-success">TRUE</span>' : '<span class="badge badge-danger">FALSE</span>' ; ?></td>
					<td class="button">
						<?php if($access_edit && user('id_group') == 1 && ENVIRONMENT == 'development') { ?>
						<button type="button" class="btn btn-warning btn-input" data-key="edit" data-id="<?php echo $m3->id; ?>" title="<?php echo lang('ubah'); ?>"><i class="fa-edit"></i></button>
						<?php } if($access_delete && user('id_group') == 1 && ENVIRONMENT == 'development') { ?>
						<button type="button" class="btn btn-danger btn-delete" data-key="delete" data-id="<?php echo $m3->id; ?>" title="<?php echo lang('hapus'); ?>"><i class="fa-trash-alt"></i></button>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>