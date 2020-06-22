<?php
namespace ArbitrageGoogleSheet;

class NamedGSheet
{
	public const NEW_TOP_SELLING 	= 'new-top-selling';
	public const LISTED 			= 'listed';
	public const MONITORING 		= 'monitoring';
	public const POTENTIAL 			= 'potential';

	private static $names = [self::NEW_TOP_SELLING, self::MONITORING, self::LISTED, self::POTENTIAL];

	private string $_name;

	private function __construct(string $name)
	{
		$this->_name = $name;
	}

	public static function create(string $name)
	{
		if (!in_array($name, self::getAllNames(), true)) {
			throw new \InvalidArgumentException('Wrong name');
		}
		return new self($name);
	}

	public function getName(): string
	{
		return $this->_name;
	}

	public static function getAllNames(): array
	{
		return self::$names;
	}

	public static function getAllNamesByPriority(): array
	{
		return [self::NEW_TOP_SELLING, self::LISTED, self::MONITORING, self::POTENTIAL];
	}
}