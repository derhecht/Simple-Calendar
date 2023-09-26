<?php
/**
 * Shortcodes
 *
 * @package SimpleCalendar
 */
namespace SimpleCalendar;

use SimpleCalendar\Abstracts\Calendar;

if (!defined('ABSPATH')) {
	exit();
}

/**
 * Shortcodes.
 *
 * Register and handle custom shortcodes.
 *
 * @since 3.0.0
 */
class Shortcodes
{
	/**
	 * Hook in tabs.
	 *
	 * @since 3.0.0
	 */
	public function __construct()
	{
		// Add shortcodes.
		add_action('init', [$this, 'register']);
	}

	/**
	 * Register shortcodes.
	 *
	 * @since 3.0.0
	 */
	public function register()
	{
		// `calendar` shortcode is conflict with other plugin so added new one.
		add_shortcode('simple_calendar', [$this, 'print_calendar']);
		add_shortcode('calendar', [$this, 'print_calendar']);
		// @deprecated legacy shortcode
		add_shortcode('gcal', [$this, 'print_calendar']);

		do_action('simcal_add_shortcodes');
	}

	/**
	 * Print a calendar.
	 *
	 * @since  3.0.0
	 *
	 * @param  array $attributes
	 *
	 * @return string
	 */
	public function print_calendar($attributes)
	{ //echo "faff";
		$args = shortcode_atts(
			[
				'id' => null,
			],
			$attributes
		);

		$id = absint($args['id']);

		if ($id > 0) {
			$calendar = simcal_get_calendar($id);
//print_r($calendar);
			if ($calendar instanceof Calendar) {
				ob_start();
				$calendar->html();
				return ob_get_clean();
			}
		}

		return '';
	}
}
