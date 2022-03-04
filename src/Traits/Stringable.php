<?php

namespace Bramus\DateTime\Traits;

trait Stringable {
	public function __toString() {
		if (!get_called_class()::$format) throw new \Exception('A format is missing in class ' . get_called_class());
		return $this->format(get_called_class()::$format);
	}

	public function setFormat($format) {
		get_called_class()::$format = $format;
	}

	public function getFormat() {
		return get_called_class()::$format;
	}
}