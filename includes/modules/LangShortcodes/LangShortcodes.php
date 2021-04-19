<?php

class CBR_LangShortcodes extends ET_Builder_Module {

	public $slug       = 'cbr_lang_shortcodes';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Antonis Ntoumanis',
		'author_uri' => '',
	);

	public function init() {
		$this->name 			= esc_html__('Language Shortcodes', 'custom-blog-ext');
		$this->vb_support 		= 'on';
		$this->slug 			= 'cbr_lang_shortcodes';
		$this->main_css_element = '%%order_class%%.cbr_lang_shortcodes';
		$this->languages        = pll_languages_list(array(
			'hide_empty' => 0,
			'fields' => 'slug'
		));
		$this->lang_fields = [];

	}

	public function get_advanced_fields_config() {

		$fields = [];

		return $fields;
	}

	public function get_fields() {

		$fields = array(
			'shortcode_de'		   => array(
				'label'            => esc_html__('Shortcode for German', 'et_builder'),
				'type'             => 'codemirror',
				'mode'             => 'html',
				'option_category'  => 'configuration',
				'default_on_front' => '',
				'depends_show_if'  => 'on',
				'toggle_slug'      => 'elements',
				'description'      => esc_html__('Here you can define the Date Format in Post Meta. Default is \'M j, Y\'', 'et_builder'),
			),
			'shortcode_en'		   => array(
				'label'            => esc_html__('Shortcode for English', 'et_builder'),
				'type'             => 'codemirror',
				'mode'             => 'html',
				'option_category'  => 'configuration',
				'default_on_front' => '',
				'depends_show_if'  => 'on',
				'toggle_slug'      => 'elements',
				'description'      => esc_html__('Here you can define the Date Format in Post Meta. Default is \'M j, Y\'', 'et_builder'),
			),
		);

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
		$shortcode_de                  = $args['shortcode_de'];
		$shortcode_en                  = $args['shortcode_en'];

		$args = wp_parse_args($args, $defaults);

		var_dump($args['shortcode_de'], $args['shortcode_en']);
		
		$output = [];

		return $output;

	}

	public function render($attrs, $content = null, $render_slug) {

		//$time_estimate_markup = CBR_LangShortcodes::post_estimate_reading_time($this->props);
		$german = $this->props['shortcode_de'];
		$english = $this->props['shortcode_en'];

		ob_start();

		echo do_shortcode( $german );
		
		echo do_shortcode( $english );

		$output = ob_get_contents();

		ob_end_clean();


		return $output;
	}
}

new CBR_LangShortcodes;

// if (class_exists('Polylang')) {
// 	new CBR_LangShortcodes;
// }