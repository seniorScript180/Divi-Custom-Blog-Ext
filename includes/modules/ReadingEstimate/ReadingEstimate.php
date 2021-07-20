<?php

class CBR_ReadEstimate extends ET_Builder_Module {

	//public $slug       = 'cbr_reading_estimate';
	//public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Antonis Ntoumanis',
		'author_uri' => '',
	);

	public function init() {
		$this->name 			= esc_html__('Reading Estimate', 'custom-blog-ext');
		$this->vb_support 		= 'on';
		$this->slug 			= 'cbr_reading_estimate';
		$this->main_css_element = '%%order_class%%.cbr_reading_estimate';

		//Words by minute for calculating est reading time
		$this->wpm = 250;

		$this->custom_css_fields = array(
			'estimate_text' => array(
				'label'    => esc_html__('Time Estimate', 'custom-blog-ext'),
				'selector' => '%%order_class%% .dmn_estimate_text',
			)
		);

		// Add Shortcode
		add_shortcode('dotiavatar', 'dotiavatar_function');
	}

	public function get_advanced_fields_config() {

		$fields = [
			'text'              => false,
			'text_shadow'       => false,
			'fonts'             => array(
				'estimate_text' => array(
					'label'     => esc_html__('Time Estimate', 'custom-blog-ext'),
					'css'       => array(
						'main'  => "{$this->main_css_element} .dmn_estimate_text",
					),
				),
			)
		];

		return $fields;
	}

	public function get_fields() {

		//$et_accent_color = et_builder_accent_color();

		// $image_icon_placement = array(
		// 	'Top' => et_builder_i18n( 'top' ),
		// );

		$fields = [];

		$fields['use_est_time'] = [
			'label'            => esc_html__('Use estimate reading time', 'et_builder'),
			'type'             => 'yes_no_button',
			'option_category'  => '',
			'options'          => array(
				'on'  => et_builder_i18n('Yes'),
			),
			'description'      => esc_html__('Use estimate reading time', 'et_builder'),
			'computed_affects' => array(
				'__minutes',
			),
			'toggle_slug'      => '',
			'default'          => 'on'
		];

		$fields['__minutes'] = [
			'type'                => 'computed',
			'computed_callback'   => array('CBR_ReadEstimate', 'post_estimate_reading_time'),
			'computed_depends_on' => array('use_est_time'),
			'computed_minimum'    => array('use_est_time'),
		];

		// $fields['use_icon' ]      = array(
		// 	'label'            => esc_html__( 'Use Icon', 'et_builder' ),
		// 	'type'             => 'yes_no_button',
		// 	'option_category'  => 'basic_option',
		// 	'options'          => array(
		// 		'off' => et_builder_i18n( 'No' ),
		// 		'on'  => et_builder_i18n( 'Yes' ),
		// 	),
		// 	'toggle_slug'      => 'image',
		// 	'affects'          => array(
		// 		'border_radii_image',
		// 		'border_styles_image',
		// 		'font_icon',
		// 		'image_max_width',
		// 		'use_icon_font_size',
		// 		'use_circle',
		// 		'icon_color',
		// 		'image',
		// 		'alt',
		// 		'child_filter_hue_rotate',
		// 		'child_filter_saturate',
		// 		'child_filter_brightness',
		// 		'child_filter_contrast',
		// 		'child_filter_invert',
		// 		'child_filter_sepia',
		// 		'child_filter_opacity',
		// 		'child_filter_blur',
		// 		'child_mix_blend_mode',
		// 	),
		// 	'description'      => esc_html__( 'Here you can choose whether icon set below should be used.', 'et_builder' ),
		// 	'default_on_front' => 'off',
		// );

		// $fields['font_icon']           = array(
		// 	'label'           => esc_html__( 'Icon', 'et_builder' ),
		// 	'type'            => 'select_icon',
		// 	'option_category' => 'basic_option',
		// 	'class'           => array( 'et-pb-font-icon' ),
		// 	'toggle_slug'     => 'image',
		// 	'description'     => esc_html__( 'Choose an icon to display with your blurb.', 'et_builder' ),
		// 	'depends_show_if' => 'on',
		// 	'mobile_options'  => true,
		// 	'hover'           => 'tabs',
		// );

		// $fields['raw_content'] = array(
		// 	'label'           => esc_html__( 'Code', 'et_builder' ),
		// 	'type'            => 'codemirror',
		// 	'mode'            => 'html',
		// 	'option_category' => 'basic_option',
		// 	'description'     => esc_html__( 'Here you can create the content that will be used within the module.', 'et_builder' ),
		// 	'is_fb_content'   => true,
		// 	'toggle_slug'     => 'main_content',
		// 	'mobile_options'  => true,
		// 	'hover'           => 'tabs',
		// );

		$fields['icon_color']          = array(
			//'default'         => $et_accent_color,
			'label'           => esc_html__('Icon Color', 'et_builder'),
			'type'            => 'color-alpha',
			'description'     => esc_html__('Here you can define a custom color for your icon.', 'et_builder'),
			// 'depends_show_if' => 'on',
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'icon_settings',
			'hover'           => 'tabs',
			//'mobile_options'  => true,
			'sticky'          => true,
		);

		// $fields['use_circle']          = array(
		// 	'label'            => esc_html__( 'Circle Icon', 'et_builder' ),
		// 	'type'             => 'yes_no_button',
		// 	'option_category'  => 'configuration',
		// 	'options'          => array(
		// 		'off' => et_builder_i18n( 'No' ),
		// 		'on'  => et_builder_i18n( 'Yes' ),
		// 	),
		// 	'affects'          => array(
		// 		'use_circle_border',
		// 		'circle_color',
		// 	),
		// 	'tab_slug'         => 'advanced',
		// 	'toggle_slug'      => 'icon_settings',
		// 	'description'      => esc_html__( 'Here you can choose whether icon set above should display within a circle.', 'et_builder' ),
		// 	'depends_show_if'  => 'on',
		// 	'default_on_front' => 'off',
		// );

		// $fields['circle_color']        = array(
		// 	'default'         => $et_accent_color,
		// 	'label'           => esc_html__( 'Circle Color', 'et_builder' ),
		// 	'type'            => 'color-alpha',
		// 	'description'     => esc_html__( 'Here you can define a custom color for the icon circle.', 'et_builder' ),
		// 	'depends_show_if' => 'on',
		// 	'tab_slug'        => 'advanced',
		// 	'toggle_slug'     => 'icon_settings',
		// 	'hover'           => 'tabs',
		// 	'mobile_options'  => true,
		// 	'sticky'          => true,
		// );

		// $fields['use_circle_border']   = array(
		// 	'label'            => esc_html__( 'Show Circle Border', 'et_builder' ),
		// 	'type'             => 'yes_no_button',
		// 	'option_category'  => 'layout',
		// 	'options'          => array(
		// 		'off' => et_builder_i18n( 'No' ),
		// 		'on'  => et_builder_i18n( 'Yes' ),
		// 	),
		// 	'affects'          => array(
		// 		'circle_border_color',
		// 	),
		// 	'description'      => esc_html__( 'Here you can choose whether if the icon circle border should display.', 'et_builder' ),
		// 	'depends_show_if'  => 'on',
		// 	'tab_slug'         => 'advanced',
		// 	'toggle_slug'      => 'icon_settings',
		// 	'default_on_front' => 'off',
		// );

		// $fields['circle_border_color'] = array(
		// 	'default'         => $et_accent_color,
		// 	'label'           => esc_html__( 'Circle Border Color', 'et_builder' ),
		// 	'type'            => 'color-alpha',
		// 	'description'     => esc_html__( 'Here you can define a custom color for the icon circle border.', 'et_builder' ),
		// 	'depends_show_if' => 'on',
		// 	'tab_slug'        => 'advanced',
		// 	'toggle_slug'     => 'icon_settings',
		// 	'hover'           => 'tabs',
		// 	'mobile_options'  => true,
		// 	'sticky'          => true,
		// );

		// $fields['image']         = array(
		// 	'label'              => et_builder_i18n( 'Image' ),
		// 	'type'               => 'upload',
		// 	'option_category'    => 'basic_option',
		// 	'upload_button_text' => et_builder_i18n( 'Upload an image' ),
		// 	'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
		// 	'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
		// 	'depends_show_if'    => 'off',
		// 	'description'        => esc_html__( 'Upload an image to display at the top of your blurb.', 'et_builder' ),
		// 	'toggle_slug'        => 'image',
		// 	'dynamic_content'    => 'image',
		// 	'mobile_options'     => true,
		// 	'hover'              => 'tabs',
		// );

		// $fields['alt']        = array(
		// 	'label'           => esc_html__( 'Image Alt Text', 'et_builder' ),
		// 	'type'            => 'text',
		// 	'option_category' => 'basic_option',
		// 	'description'     => esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
		// 	'depends_show_if' => 'off',
		// 	'tab_slug'        => 'custom_css',
		// 	'toggle_slug'     => 'attributes',
		// 	'dynamic_content' => 'text',
		// );

		// $fields['icon_placement'] = array(
		// 	'label'            => esc_html__( 'Image/Icon Placement', 'et_builder' ),
		// 	'type'             => 'select',
		// 	'option_category'  => 'layout',
		// 	'options'          => $image_icon_placement,
		// 	'tab_slug'         => 'advanced',
		// 	'toggle_slug'      => 'icon_settings',
		// 	'description'      => esc_html__( 'Here you can choose where to place the icon.', 'et_builder' ),
		// 	'default_on_front' => 'top',
		// 	'mobile_options'   => true,
		// );

		// $fields['icon_alignment']      = array(
		// 	'label'           => esc_html__( 'Image/Icon Alignment', 'et_builder' ),
		// 	'description'     => esc_html__( 'Align image/icon to the left, right or center.', 'et_builder' ),
		// 	'type'            => 'align',
		// 	'option_category' => 'layout',
		// 	'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
		// 	'tab_slug'        => 'advanced',
		// 	'toggle_slug'     => 'icon_settings',
		// 	'default'         => 'center',
		// 	'mobile_options'  => true,
		// 	'sticky'          => true,
		// 	'show_if'         => array(
		// 		'icon_placement' => 'top',
		// 	),
		// );

		// $fields['image_max_width']     = array(
		// 	'label'            => esc_html__( 'Image Width', 'et_builder' ),
		// 	'description'      => esc_html__( 'Adjust the width of the image within the blurb.', 'et_builder' ),
		// 	'type'             => 'range',
		// 	'option_category'  => 'layout',
		// 	'tab_slug'         => 'advanced',
		// 	'toggle_slug'      => 'width',
		// 	'mobile_options'   => true,
		// 	'validate_unit'    => true,
		// 	'depends_show_if'  => 'off',
		// 	'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
		// 	'default'          => '100%',
		// 	'default_unit'     => '%',
		// 	'default_on_front' => '',
		// 	'allow_empty'      => true,
		// 	'range_settings'   => array(
		// 		'min'  => '0',
		// 		'max'  => '100',
		// 		'step' => '1',
		// 	),
		// 	'responsive'       => true,
		// 	'sticky'           => true,
		// );

		// $fields['use_icon_font_size']  = array(
		// 	'label'            => esc_html__( 'Use Icon Font Size', 'et_builder' ),
		// 	'description'      => esc_html__( 'If you would like to control the size of the icon, you must first enable this option.', 'et_builder' ),
		// 	'type'             => 'yes_no_button',
		// 	'option_category'  => 'font_option',
		// 	'options'          => array(
		// 		'off' => et_builder_i18n( 'No' ),
		// 		'on'  => et_builder_i18n( 'Yes' ),
		// 	),
		// 	'affects'          => array(
		// 		'icon_font_size',
		// 	),
		// 	'depends_show_if'  => 'on',
		// 	'tab_slug'         => 'advanced',
		// 	'toggle_slug'      => 'icon_settings',
		// 	'default_on_front' => 'off',
		// );

		// $fields['icon_font_size']      = array(
		// 	'label'            => esc_html__( 'Icon Font Size', 'et_builder' ),
		// 	'description'      => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'et_builder' ),
		// 	'type'             => 'range',
		// 	'option_category'  => 'font_option',
		// 	'tab_slug'         => 'advanced',
		// 	'toggle_slug'      => 'icon_settings',
		// 	'default'          => '96px',
		// 	'default_unit'     => 'px',
		// 	'default_on_front' => '',
		// 	'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
		// 	'range_settings'   => array(
		// 		'min'  => '1',
		// 		'max'  => '120',
		// 		'step' => '1',
		// 	),
		// 	'mobile_options'   => true,
		// 	'sticky'           => true,
		// 	'depends_show_if'  => 'on',
		// 	'responsive'       => true,
		// 	'hover'            => 'tabs',
		// );

		return $fields;
	}

	static function post_estimate_reading_time($args = array()) {

		$defaults = array(
			'german_lang'   => 'lang="de-DE"' === get_language_attributes() ? TRUE : FALSE,
			'show_est_time' => 'on',
			'wpm' => 250
		);

		$moduleID                      = $args['moduleID'];
		$moduleClassName               = $args['className'];
		$render_slug        		   = $args['render_slug'];
		$icon_color 				   = $args['icon_color'];

		$args['stopwatch']            = '<svg width="32" height="100%" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/">
			<path class="icon" d="M204.323,89.183L215.554,77.953C217.976,75.531 218.817,72.124 218.078,69.018C217.916,67.523 217.261,66.071 216.114,64.924C215.805,64.615 215.474,64.342 215.127,64.105C211.389,60.795 205.68,60.934 202.108,64.507L190.785,75.83C175.948,63.734 157.603,55.842 137.507,53.931L137.507,43.702L160.46,43.702C164.233,43.702 167.294,40.64 167.294,36.868L167.294,9.532C167.294,5.753 164.233,2.698 160.46,2.698L97.246,2.698C93.467,2.698 90.412,5.753 90.412,9.532L90.412,36.868C90.412,40.64 93.467,43.702 97.246,43.702L118.491,43.702L118.491,53.959C67.994,58.765 28.339,101.305 28.339,153.045C28.339,207.997 73.047,252.698 127.999,252.698C182.951,252.698 227.659,207.997 227.659,153.045C227.659,128.732 218.848,106.49 204.323,89.183ZM127.999,76.849C170.008,76.849 204.188,111.029 204.188,153.044C204.188,195.047 170.008,229.227 127.999,229.227C85.99,229.227 51.81,195.047 51.81,153.044C51.81,111.029 85.99,76.849 127.999,76.849ZM127.999,166.998C133.247,166.998 137.507,162.739 137.507,157.49L137.507,97.68C137.507,92.432 133.247,88.172 127.999,88.172C122.741,88.172 118.491,92.432 118.491,97.68L118.491,157.49C118.491,162.739 122.741,166.998 127.999,166.998ZM111.992,18.548L145.715,18.548L145.715,27.851L111.992,27.851L111.992,18.548Z" />
		</svg>';

		$args = wp_parse_args($args, $defaults);

		//var_dump($moduleClassName);

		$post_content = et_strip_shortcodes(et_delete_post_first_video(get_the_content()), true);
		$no_divi = preg_replace('/\[\/?et_pb.*?\]/', '', $post_content);
		$no_shortcodes = strip_shortcodes($no_divi);
		$no_tags = strip_tags($no_shortcodes);
		$word_count = str_word_count($no_tags);
		$time = $word_count / $args['wpm'];

		if ($args['german_lang']) {
			$est_time_text = "Lesedauer";
			$time_text = "Min.";
		} else {
			$est_time_text = esc_html__('Est. reading time', 'custom-blog-ext');
			$time_text = esc_html__('min.', 'custom-blog-ext');
		}

		$minutes = floor($time % 60);
		//$minutes = sprintf('%02d', $minutes);

		$seconds = $time - (int)$time;
		$seconds = round($seconds * 60);
		//$seconds = sprintf('%02d', $seconds);


		$icon_class = '
		<style>
			.cbr-icon .icon {
				fill: ' . $args['icon_color'] . '!important
		}
		</style>';
		//var_dump($icon_class);

		return sprintf(
			'<div%1$s class="%2$s">
				<div class="cbr-icon">%3$s</div>
				<span class="dmn_estimate_text"> %4$s %5$s</span>
			</div>
			%6$s',
			$moduleID,
			$moduleClassName,
			$args['stopwatch'],
			$minutes,
			$time_text,			
			$icon_class
		);;
	}

	public function render($attrs, $content = null, $render_slug) {

		$this->props['moduleID'] = $this->module_id();
		$this->props['className'] = $this->module_classname($render_slug);
		$this->props['render_slug'] = $this->slug;

		//var_dump($this->module_classname( $render_slug ));
		//var_dump($this->props['moduleID']);

		$time_estimate_markup = CBR_ReadEstimate::post_estimate_reading_time($this->props);

		return $time_estimate_markup;
	}
}

new CBR_ReadEstimate;
