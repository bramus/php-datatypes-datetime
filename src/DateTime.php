<?php

namespace Bramus\DateTime;

use \Bramus\DateTime\DateTimeZone;

/**
 * An extension to PHP's \DateTime Class.
 */
class DateTime extends \DateTime implements Interfaces\Stringable {

	// Add __toString(), defaulting to ISO8601 format
	use \Bramus\DateTime\Traits\Stringable;
	static $format = \DateTime::ISO8601;

	// Add ::now() and ::nowish()
	use \Bramus\DateTime\Traits\Now;
	use \Bramus\DateTime\Traits\Nowish;


	public function __construct($time = 'now', $timezone = null) {
		// Default to UTC if no timezone is given + allow strings
		if (!$timezone) {
			$timezone = new DateTimeZone('UTC');
		} elseif (is_string($timezone) || is_a($timezone, \DateTimeZone::class)) {
			$timezone = new DateTimeZone($timezone);
		}

		// Decorate \DateTime instances
		if (is_a($time, \DateTime::class)) {
			$time = $time->setTimeZone($timezone)->format('Y-m-d H:i:s');
		}

		// Call parent constructor
		parent::__construct($time, $timezone);
	}

	public static function createFromFormat($format = null, $time, $timezone = null) {
		// Default to UTC if no timezone is given + allow strings
		if (!$timezone) {
			$timezone = new DateTimeZone('UTC');
		} elseif (is_string($timezone) || is_a($timezone, \DateTimeZone::class)) {
			$timezone = new DateTimeZone($timezone);
		}

		// Fall back to own format
		if (!$format) {
			$format = get_called_class()::$format;
		}

		$dt = parent::createFromFormat($format, $time, $timezone);

		$class = get_called_class();
		return new $class($dt, $timezone);
	}
}