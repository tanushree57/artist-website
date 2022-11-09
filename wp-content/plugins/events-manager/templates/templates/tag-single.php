<?php
/*
 * This page displays a single event, called during the em_content() if this is an event page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output() 
 */
global $EM_Tag;
/* @var $EM_Tag EM_Tag */
if( empty($args['id']) ) $args['id'] = rand(); // prevent warnings
$id = esc_attr($args['id']);
?>
<div class="<?php em_template_classes('view-container'); ?>" id="em-view-<?php echo $id; ?>" data-view="tag">
	<div class="<?php em_template_classes('tag-single'); ?> em-tag-<?php echo esc_attr($EM_Tag->term_id); ?>" id="em-tag-<?php echo $id; ?>" data-view-id="<?php echo $id; ?>">
		<?php
		echo $EM_Tag->output_single();
		?>
	</div>
</div>