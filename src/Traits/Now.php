<?php

namespace Bramus\DateTime\Traits;

trait Now {
	public static function now() {
		$class = get_called_class();
		return new $class('now');
	}
}