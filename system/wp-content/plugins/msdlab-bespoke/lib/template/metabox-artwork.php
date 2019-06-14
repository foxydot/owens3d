<?php global $wpalchemy_media_access;
?>
<table class="form-table">
    <tbody>
    <tr>
        <?php $mb->the_field('date'); ?>

        <th scope="row"><label for="<?php $mb->the_name(); ?>">Date Created</label></th>
        <td>
            <p><input class="large-text" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" /></p>
        </td>
    </tr>
    <tr>
        <?php $mb->the_field('price'); ?>
        <th scope="row"><label for="<?php $mb->the_name(); ?>">Valued at</label></th>
        <td>
            <p><input class="large-text" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
            </p>
        </td>
    </tr>
    <tr>
        <?php $mb->the_field('height'); ?>
        <th scope="row"><label for="<?php $mb->the_name(); ?>">Height</label></th>
        <td>
            <p><input class="large-text" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
            </p>
        </td>
    </tr>
    <tr>
        <?php $mb->the_field('width'); ?>
        <th scope="row"><label for="<?php $mb->the_name(); ?>">Width</label></th>
        <td>
            <p><input class="large-text" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
            </p>
        </td>
    </tr>
    <tr>
        <?php $mb->the_field('depth'); ?>
        <th scope="row"><label for="<?php $mb->the_name(); ?>">Depth</label></th>
        <td>
            <p><input class="large-text" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
            </p>
        </td>
    </tr>
	<tr>
		<?php $mb->the_field('video'); ?>
		<th scope="row"><label for="<?php $mb->the_name(); ?>">Video</label></th>
		<td>
			<?php $group_name = 'video' ?>
			<?php $wpalchemy_media_access->setGroupName($group_name)->setInsertButtonLabel('Insert This')->setTab('upload'); ?>
			<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			<?php echo $wpalchemy_media_access->getButton(array('label' => 'Add Video')); ?>
		</td>
    </tr>
    <tr>
        <?php $mb->the_field('gallery'); ?>
        <th scope="row"><label for="<?php $mb->the_name(); ?>">Gallery</label></th>
        <td>
            <p>
                <?php
                $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                $mb_editor_id = sanitize_key($mb->get_the_name());
                $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '10',);
                wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                ?>
            </p>
        </td>
    </tr>
	</tbody>
</table>