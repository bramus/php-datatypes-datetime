<?php

namespace Bramus\DateTime;

/**
 * An extension to PHP's \DateTimeZone Class.
 */
class DateTimeZone extends \DateTimeZone {
	public function __construct($timezone = null) {
		// Default to UTC if no timezone is given
		if (!$timezone) {
			$timezone = 'UTC';
		}

		// Decorate \DateTimeZone instances
		if (is_a($timezone, \DateTimeZone::class)) {
			$timezone = $timezone->getName();
		}

		// Call parent constructor
		parent::__construct($timezone);
	}

	public function __toString() {
		return $this->getName();
	}
}