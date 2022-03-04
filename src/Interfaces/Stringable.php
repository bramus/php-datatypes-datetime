<?php

namespace Bramus\DateTime\Interfaces;

interface Stringable {
	public function __toString();
	public function setFormat($format);
	public function getFormat();
}