<?php

namespace Tests\Bramus\DateTime;

use \Bramus\DateTime\Constants;

use \Bramus\DateTime\DateTime;
use \Bramus\DateTime\DateTimeZone;

use \Bramus\DateTime\ISO8601Formatted;
use \Bramus\DateTime\AtomFormatted;

use \PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
	const BRAMUS_BIRTH_AS_TIMESTAMP = 441283500;

	const BRAMUS_BIRTH_AS_YMDHIS_TZ_UTC = '1983-12-26 10:45:00';
	const BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS = '1983-12-26 11:45:00';
	const BRAMUS_BIRTH_AS_YMDHIS_TZ_PACIFICAPIA = '1983-12-25 23:45:00';

	const BRAMUS_BIRTH_AS_ISO8601_TZ_UTC = '1983-12-26T10:45:00+0000';
	const BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS = '1983-12-26T11:45:00+0100';
	const BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA = '1983-12-25T23:45:00-1100';

	const BRAMUS_BIRTH_AS_ATOM_TZ_UTC = '1983-12-26T10:45:00+00:00';
	const BRAMUS_BIRTH_AS_ATOM_TZ_EUROPEBRUSSELS = '1983-12-26T11:45:00+01:00';
	const BRAMUS_BIRTH_AS_ATOM_TZ_PACIFICAPIA = '1983-12-25T23:45:00-11:00';

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
		$dt = new DateTime();
		$this->assertInstanceOf(DateTime::class, $dt);

		$dt = new DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_UTC);
		$this->assertInstanceOf(DateTime::class, $dt);

		$dt = new DateTime(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_PACIFICAPIA));
		$this->assertInstanceOf(DateTime::class, $dt);

		$dt = new DateTime(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_PACIFICAPIA), 'Pacific/Apia');
		$this->assertInstanceOf(DateTime::class, $dt);

		$dt = new DateTime(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_PACIFICAPIA), new DateTimeZone('Pacific/Apia'));
		$this->assertInstanceOf(DateTime::class, $dt);

		$dt = new DateTime(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_PACIFICAPIA), new \DateTimeZone('Pacific/Apia'));
		$this->assertInstanceOf(DateTime::class, $dt);
	}

	public function testCreateFromFormatShouldReturnAnInstance()
	{
		$dt = DateTime::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS);
		$this->assertInstanceOf(DateTime::class, $dt);

		$dt = DateTime::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS);
		$this->assertInstanceOf(DateTime::class, $dt);
	}

	public function testCreateFromFormatWithNoFormatGiven()
	{
		$dt = DateTime::createFromFormat(null, self::BRAMUS_BIRTH_AS_ISO8601_TZ_UTC);
		$this->assertInstanceOf(DateTime::class, $dt);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_UTC, (string) $dt);

		$dt = DateTime::createFromFormat(null, self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, new \DateTimeZone('Pacific/Apia'));
		$this->assertInstanceOf(DateTime::class, $dt);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, (string) $dt);

		$dt = DateTime::createFromFormat(null, self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, new DateTimeZone('Pacific/Apia'));
		$this->assertInstanceOf(DateTime::class, $dt);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, (string) $dt);

		$dt = ISO8601Formatted::createFromFormat(null, self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, new \DateTimeZone('Pacific/Apia'));
		$this->assertInstanceOf(ISO8601Formatted::class, $dt);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, (string) $dt);

		$dt = ISO8601Formatted::createFromFormat(null, self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, new DateTimeZone('Pacific/Apia'));
		$this->assertInstanceOf(ISO8601Formatted::class, $dt);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, (string) $dt);

		$dt = AtomFormatted::createFromFormat(null, self::BRAMUS_BIRTH_AS_ATOM_TZ_UTC);
		$this->assertInstanceOf(AtomFormatted::class, $dt);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_UTC, (string) $dt);

		$dt = AtomFormatted::createFromFormat(null, self::BRAMUS_BIRTH_AS_ATOM_TZ_PACIFICAPIA, new \DateTimeZone('Pacific/Apia'));
		$this->assertInstanceOf(AtomFormatted::class, $dt);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_PACIFICAPIA, (string) $dt);

		$dt = AtomFormatted::createFromFormat(null, self::BRAMUS_BIRTH_AS_ATOM_TZ_PACIFICAPIA, new DateTimeZone('Pacific/Apia'));
		$this->assertInstanceOf(AtomFormatted::class, $dt);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_PACIFICAPIA, (string) $dt);
	}

	public function testTimezoneShouldBeUTCByDefault()
	{
		$dt = new DateTime();
		$this->assertEquals('UTC', $dt->getTimeZone()->getName());

		$dt = new DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_UTC);
		$this->assertEquals('UTC', $dt->getTimeZone()->getName());
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));

		$dt = new DateTime(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_PACIFICAPIA));
		$this->assertEquals('UTC', $dt->getTimeZone()->getName());
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));

		$dt = DateTime::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS);
		$this->assertEquals('UTC', $dt->getTimeZone()->getName());
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));
	}

	public function testTimezoneCanBeOverridden()
	{
		$dt = new DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new \DateTimeZone('Europe/Brussels'));
		$this->assertEquals($dt->getTimeZone()->getName(), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));
		$dt = new DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new DateTimeZone('Europe/Brussels'));
		$this->assertEquals($dt->getTimeZone()->getName(), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));
		$dt = new DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, 'Europe/Brussels');
		$this->assertEquals($dt->getTimeZone()->getName(), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));

		$dt = DateTime::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, new \DateTimeZone('Europe/Brussels'));
		$this->assertEquals('Europe/Brussels', $dt->getTimeZone()->getName());
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));
		$dt = DateTime::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, new DateTimeZone('Europe/Brussels'));
		$this->assertEquals('Europe/Brussels', $dt->getTimeZone()->getName());
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));
		$dt = DateTime::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, 'Europe/Brussels');
		$this->assertEquals('Europe/Brussels', $dt->getTimeZone()->getName());
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));
	}

	public function testTimezoneCanBeOverriddenAsString()
	{
		$dt = new DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, 'Europe/Brussels');
		$this->assertEquals($dt->getTimeZone()->getName(), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));

		$dt = DateTime::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, 'Europe/Brussels');
		$this->assertEquals('Europe/Brussels', $dt->getTimeZone()->getName());
		$this->assertEquals(self::BRAMUS_BIRTH_AS_TIMESTAMP, $dt->format('U'));
	}

	public function testToString()
	{
		$dt = new DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_UTC);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_UTC, (string) $dt);

		$dt = new DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new DateTime(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new DateTimeZone('Europe/Brussels')), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new DateTime(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new \DateTimeZone('Europe/Brussels')), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new DateTime(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new DateTimeZone('Europe/Brussels')), new DateTimeZone('Europe/Brussels'));
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new DateTime(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new \DateTimeZone('Europe/Brussels')), new \DateTimeZone('Europe/Brussels'));
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = DateTime::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_UTC, (string) $dt);

		$dt = DateTime::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, 'Pacific/Apia');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, (string) $dt);
	}

	public function testToStringForISO5601Formatted()
	{
		$dt = new ISO8601Formatted(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_UTC);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_UTC, (string) $dt);

		$dt = new ISO8601Formatted(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new ISO8601Formatted(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new DateTimeZone('Europe/Brussels')), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new ISO8601Formatted(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new \DateTimeZone('Europe/Brussels')), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new ISO8601Formatted(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new DateTimeZone('Europe/Brussels')), new DateTimeZone('Europe/Brussels'));
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new ISO8601Formatted(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new \DateTimeZone('Europe/Brussels')), new \DateTimeZone('Europe/Brussels'));
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = ISO8601Formatted::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_EUROPEBRUSSELS);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_UTC, (string) $dt);

		$dt = ISO8601Formatted::createFromFormat(\DateTime::ISO8601, self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, 'Pacific/Apia');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ISO8601_TZ_PACIFICAPIA, (string) $dt);
	}

	public function testToStringForAtomFormatted()
	{
		$dt = new AtomFormatted(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_UTC);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_UTC, (string) $dt);

		$dt = new AtomFormatted(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new AtomFormatted(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new DateTimeZone('Europe/Brussels')), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new AtomFormatted(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new \DateTimeZone('Europe/Brussels')), 'Europe/Brussels');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new AtomFormatted(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new DateTimeZone('Europe/Brussels')), new DateTimeZone('Europe/Brussels'));
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = new AtomFormatted(new \DateTime(self::BRAMUS_BIRTH_AS_YMDHIS_TZ_EUROPEBRUSSELS, new \DateTimeZone('Europe/Brussels')), new \DateTimeZone('Europe/Brussels'));
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_EUROPEBRUSSELS, (string) $dt);

		$dt = AtomFormatted::createFromFormat(\DateTime::ATOM, self::BRAMUS_BIRTH_AS_ATOM_TZ_EUROPEBRUSSELS);
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_UTC, (string) $dt);

		$dt = AtomFormatted::createFromFormat(\DateTime::ATOM, self::BRAMUS_BIRTH_AS_ATOM_TZ_PACIFICAPIA, 'Pacific/Apia');
		$this->assertEquals(self::BRAMUS_BIRTH_AS_ATOM_TZ_PACIFICAPIA, (string) $dt);
	}

	public function testNow()
	{
		$nowThroughConstructor = new DateTime();
		$nowThroughShorthand = DateTime::now();

		$this->assertEquals($nowThroughConstructor->format('U'), $nowThroughShorthand->format('U'));
	}

	public function testNowIsh()
	{
		$now = DateTime::now();
		$nowIsh = DateTime::nowish();

		// Nowish should be less than or equal now
		$this->assertLessThanOrEqual($now->format('U'), $nowIsh->format('U'));

		// The default rounding is 5
		$this->assertLessThanOrEqual(5, $now->format('U') - $nowIsh->format('U'));
		$this->assertgreaterThanOrEQual(0, $now->format('U') - $nowIsh->format('U'));
		$this->assertEquals(0, $nowIsh->format('s') % 5);
	}

	public function testNowIshPrecision()
	{
		// As we round to the minute, the number of seconds should always be 0
		$nowIsh = DateTime::nowish(60);
		$this->assertEquals(0, $nowIsh->format('s'));
	}

	public function testNowIshRoundDirection()
	{
		$now = DateTime::now();
		$nowIshDown = DateTime::nowish(5, Constants::NOWISH_ROUND_DOWN);
		$nowIshAuto = DateTime::nowish(5, Constants::NOWISH_ROUND_AUTO);
		$nowIshUp = DateTime::nowish(5, Constants::NOWISH_ROUND_UP);

		// nowIshDown should be less than or equal now
		$this->assertLessThanOrEqual($now->format('U'), $nowIshDown->format('U'));

		// nowIshUp should be geater than or equal now
		$this->assertGreaterThanOrEqual($now->format('U'), $nowIshUp->format('U'));

		// nowIshAuto should either equal nowIshDown or nowIshUp
		$this->logicalOr(
			$this->assertLessThanOrEqual($nowIshAuto->format('U'), $nowIshDown->format('U')),
			$this->assertGreaterThanOrEqual($nowIshAuto->format('U'), $nowIshUp->format('U'))
		);
	}
}
