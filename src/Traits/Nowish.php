<?php

namespace Bramus\DateTime\Traits;

use \Bramus\DateTime\Constants;
use \Bramus\DateTime\DateTime;

trait Nowish {
	public static function nowish(int $numberOfSeconds = 5, string $direction = Constants::NOWISH_ROUND_DOWN) {
		if (!method_exists(get_called_class(), 'now')) {
			throw new \Exception('The trait \Bramus\DateTime\Traits\Nowish requires that the \Bramus\DateTime\Traits\Now trait is also included. This is not the case for ' . get_called_class());
		}

		return static::roundDateTime(self::now(), $numberOfSeconds, $direction);
	}

	public static function roundDateTime(DateTime $datetime, int $numberOfSeconds, string $direction = Constants::NOWISH_ROUND_DOWN) {
		$datetime->setTimestamp(static::roundTimestamp($datetime->format('U'), $numberOfSeconds, $direction));
		return $datetime;
	}

	public static function roundTimestamp(int $timestamp, int $numberOfSeconds, string $direction = Constants::NOWISH_ROUND_DOWN) {
		switch ($direction) {
			case Constants::NOWISH_ROUND_DOWN:
				$roundedTimestamp = floor($timestamp / $numberOfSeconds) * $numberOfSeconds;
				break;
			case Constants::NOWISH_ROUND_UP:
				$roundedTimestamp = ceil($timestamp / $numberOfSeconds) * $numberOfSeconds;
				break;
			case Constants::NOWISH_ROUND_AUTO:
				$roundedTimestamp = round($timestamp / $numberOfSeconds) * $numberOfSeconds;
				break;
			default:
				throw new \Exception('Invalid roundTo value given for nowish()');
		}

		return $roundedTimestamp;
	}
}