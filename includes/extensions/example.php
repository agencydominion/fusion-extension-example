<?php
/**
 * @package Fusion_Extension_Example
 */

/**
 * Example Extension.
 *
 * Function for adding a Example element to the Fusion Engine
 *
 * @since 1.0.0
 */

/**
 * Map Shortcode
 */

add_action('init', 'fsn_init_example', 12);
function fsn_init_example() {
 
	if (function_exists('fsn_map')) {
		
		fsn_map(array(
			'name' => __('Example', 'fusion-extension-example'),
			'shortcode_tag' => 'fsn_example',
			'description' => __('An Example Element for Fusion.', 'fusion-extension-example'),
			'icon' => 'info_outline',
			'params' => array(
				array(
					'type' => 'text',
					'param_name' => 'example_text',
					'label' => __('Example Text', 'fusion-extension-example'),
					'help' => __('An example of a text input field.', 'fusion-extension-example'),
					'section' => 'general'
				),
				array(
					'type' => 'textarea',
					'param_name' => 'example_textarea',
					'label' => __('Example Textarea', 'fusion-extension-example'),
					'content_field' => true,
					'help' => __('An example of a textarea field.', 'fusion-extension-example'),
					'section' => 'general'
				),
				array(
					'type' => 'checkbox',
					'param_name' => 'example_checkbox',
					'label' => __('Example Checkbox', 'fusion-extension-example'),
					'help' => __('An example of a checkbox field.', 'fusion-extension-example'),
					'section' => 'general'
				),
				array(
					'type' => 'note',
					'param_name' => 'example_note_checkbox_dependency',
					'help' => __('A note that shows if the Example Checkbox is enabled.', 'fusion-extension-example'),
					'section' => 'general',
					'dependency' => array(
						'param_name' => 'example_checkbox',
						'not_empty' => true
					),
				),
				array(
					'type' => 'radio',
					'param_name' => 'example_radio',
					'options' => array(
						'option1' => __('Option 1', 'fusion-extension-example'),
						'option2' => __('Option 2', 'fusion-extension-example'),
					),
					'label' => __('Example Radio', 'fusion-extension-example'),
					'help' => __('An example of a radio field.', 'fusion-extension-example'),
					'section' => 'general'
				),
				array(
					'type' => 'note',
					'param_name' => 'example_note_radio_dependency',
					'help' => __('A note that shows if Option 2 is selected in the Example Radio.', 'fusion-extension-example'),
					'section' => 'general',
					'dependency' => array(
						'param_name' => 'example_radio',
						'value' => 'option2'
					)
				),
				array(
					'type' => 'select',
					'param_name' => 'example_select',
					'options' => array(
						'' => __('Choose an option.'),
						'option1' => __('Option 1', 'fusion-extension-example'),
						'option2' => __('Option 2', 'fusion-extension-example'),
						'option3' => __('Option 3', 'fusion-extension-example')
					),
					'label' => __('Example Select', 'fusion-extension-example'),
					'help' => __('An example of a select field.', 'fusion-extension-example'),
					'section' => 'general'
				),
				array(
					'type' => 'note',
					'param_name' => 'example_note_select_dependency',
					'help' => __('A note that shows if either Option 1 or Option 2 is selected in the Example Select.', 'fusion-extension-example'),
					'section' => 'general',
					'dependency' => array(
						'param_name' => 'example_select',
						'value' => array('option1', 'option2')
					)
				),
				array(
					'type' => 'colorpicker',
					'param_name' => 'example_colorpicker',
					'label' => __('Example Colorpicker', 'fusion-extension-example'),
					'help' => __('An example of a colorpicker field.', 'fusion-extension-example'),
					'section' => 'general'
				),
				array(
					'type' => 'image',
					'param_name' => 'example_image',
					'label' => __('Example Image', 'fusion-extension-example'),
					'help' => __('An example of an image field.', 'fusion-extension-example'),
					'section' => 'general'
				),
				array(
					'type' => 'button',
					'param_name' => 'example_button',
					'label' => __('Example Button', 'fusion-extension-example'),
					'help' => __('An example of a button field.', 'fusion-extension-example'),
					'section' => 'general'
				)
			)
		));
	}
}

/**
 * Output Shortcode
 */

function fsn_example_shortcode( $atts, $content ) {
	extract( shortcode_atts( array(
		'example_text' => '',
		'example_checkbox' => '',
		'example_radio' => '',
		'example_select' => '',
		'example_colorpicker' => '',
		'example_image' => '',
		'example_button' => '',
	), $atts ) );
	
	//enqueue script
	wp_enqueue_script( 'fsn_example');
	
	$output = '<div class="fsn-example '. fsn_style_params_class($atts) .'">';
		$output .= !empty($example_text) ? '<h5>Example Text:</h5>'. esc_html($example_text): '';
		$output .= !empty($content) ? '<h5>Example Textarea:</h5>'. do_shortcode($content) : ''; 
		$output .= !empty($example_checkbox) ? '<p>Example Checkbox is <strong>on</strong></p>' : '<p>Example Checkbox is <strong>off</strong></p>';
		$output .= !empty($example_radio) ? '<p>Example Radio is set to <strong>'. esc_html($example_radio) .'</strong></p>' : '';
		$output .= !empty($example_select) ? '<p>Example Select is set to <strong>'. esc_html($example_select) .'</strong></p>' : '';
		$output .= !empty($example_colorpicker) ? '<p>Example Colorpicker is set to <span style="display:inline-block;vertical-align:middle;width:20px;height:20px;margin-left:5px;background:'. esc_attr($example_colorpicker) .';"></span></p>' : '';
		if (!empty($example_image)) {
			$output .= '<p>Example Image:';
				$attachment_attrs = wp_get_attachment_image_src(intval($example_image), 'thumbnail');
				$attachment_alt = get_post_meta(intval($example_image), '_wp_attachment_image_alt', true);
				$output .= !empty($attachment_attrs) ? '<img src="'. esc_url($attachment_attrs[0]) .'" width="'. esc_attr($attachment_attrs[1]) .'" height="'. esc_attr($attachment_attrs[2]) .'" alt="'. esc_attr($attachment_alt) .'">' : '';
			$output .= '</p>';
		}
		if (!empty($example_button)) {
			$button_object = fsn_get_button_object($example_button);
			$output .= 'Example Button: <a'. fsn_get_button_anchor_attributes($button_object) .'>'. esc_html($button_object['button_label']) .'</a>';
		}
	$output .= '</div>';
	
	
	return $output;
}
add_shortcode('fsn_example', 'fsn_example_shortcode');
 
?>