<?php

namespace Tests\Bramus\DateTime;

use \PHPUnit\Framework\TestCase;

class DateTimeZoneTest extends TestCase
{
	protected function setUp() : void
	{
		$this->origTimeZone = date_default_timezone_get();
		date_default_timezone_set('Pacific/Apia');
	}

	protected function tearDown() : void
	{
		date_default_timezone_set($this->origTimeZone);
	}

	public function testConstructorShouldReturnAnInstance()
	{
		$tz = new \Bramus\DateTime\DateTimeZone();
		$this->assertInstanceOf(\Bramus\DateTime\DateTimeZone::class, $tz);

		$tz = new \Bramus\DateTime\DateTimeZone('Europe/Brussels');
		$this->assertInstanceOf(\Bramus\DateTime\DateTimeZone::class, $tz);

		$tz = new \Bramus\DateTime\DateTimeZone(new \DateTimeZone('Europe/Brussels'));
		$this->assertInstanceOf(\Bramus\DateTime\DateTimeZone::class, $tz);
	}

	public function testTimezoneShouldBeUTCByDefault()
	{
		$tz = new \Bramus\DateTime\DateTimeZone();
		$this->assertEquals('UTC', $tz->getName());
	}

	public function testTimezoneCanBeOverridden()
	{
		$tz = new \Bramus\DateTime\DateTimeZone('Europe/Brussels');
		$this->assertEquals('Europe/Brussels', $tz->getName());

		$tz = new \Bramus\DateTime\DateTimeZone(new \DateTimeZone('Europe/Brussels'));
		$this->assertEquals('Europe/Brussels', $tz->getName());
	}

	public function testToString()
	{
		$tz = new \Bramus\DateTime\DateTimeZone();
		$this->assertEquals('UTC', (string) $tz);

		$tz = new \Bramus\DateTime\DateTimeZone('Europe/Brussels');
		$this->assertEquals('Europe/Brussels', (string) $tz);

		$tz = new \Bramus\DateTime\DateTimeZone(new \DateTimeZone('Europe/Brussels'));
		$this->assertEquals('Europe/Brussels', (string) $tz);
	}
}
