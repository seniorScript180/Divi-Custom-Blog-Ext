<?php

class CBR_ReadEstimate extends ET_Builder_Module {

	public $slug       = 'cbr_reading_estimate';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Antonis Ntoumanis',
		'author_uri' => '',
	);

	public function init() {
		$this->name = esc_html__('Reading Estimate', 'custom-blog-ext');

		//Words by minute for calculating est reading time
		$this->wpm = 250;

		$this->custom_css_fields = array(
			'estimate_text' => array(
				'label'    => esc_html__('Time Estimate', 'custom-blog-ext'),
				'selector' => '%%order_class%% .dmn_estimate_text',
			)
		);

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

		return $fields;
	}

	static function post_estimate_reading_time($args = array()) {

		$defaults = array(
			'german_lang'   => 'lang="de-DE"' === get_language_attributes() ? TRUE : FALSE,
			'show_est_time' => 'on',
			'wpm' => 250
		);
		$args = wp_parse_args($args, $defaults);



		$content = get_the_content();
		$post_content = et_strip_shortcodes(et_delete_post_first_video(get_the_content()), true);
		$no_divi = preg_replace('/\[\/?et_pb.*?\]/', '', $post_content);
		$no_shortcodes = strip_shortcodes($no_divi);
		$no_tags = strip_tags($no_shortcodes);
		$word_count = str_word_count($no_tags);
		$time = $word_count / $args['wpm'];

		if ($args['german_lang']) {
			$est_time_text = "Lesedauer";
			$time_text = "Minuten";
		} else {
			$est_time_text = esc_html__('Est. reading time', 'custom-blog-ext');
			$time_text = esc_html__('minutes', 'custom-blog-ext');
		}

		$minutes = floor($time % 60);
		$minutes = sprintf('%02d', $minutes);

		$seconds = $time - (int)$time;
		$seconds = round($seconds * 60);
		$seconds = sprintf('%02d', $seconds);

		return sprintf(
			'<div class="est-reading-time">
			<span class="dmn_estimate_text">%1$s: %2$s:%3$s %4$s</span>
			</div><!-- End of %5$s -->',
			$est_time_text,
			$minutes,
			$seconds,
			$time_text,
			'.dmn_estimate_text'
		);;
	}

	public function render($attrs, $content = null, $render_slug) {

		$time_estimate_markup = CBR_ReadEstimate::post_estimate_reading_time();

		return $time_estimate_markup;
		
	}
}

new CBR_ReadEstimate;
