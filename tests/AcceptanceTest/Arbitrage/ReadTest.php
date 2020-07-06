<?php

namespace AcceptanceTest\Arbitrage;

use ArbitrageGoogleSheet\Arbitrage\GSheet;
use ArbitrageGoogleSheet\Arbitrage\Row;
use ArbitrageGoogleSheet\ClientConfig;
use ArbitrageGoogleSheet\ClientFactory;
use ArbitrageGoogleSheet\GSheetFactory;
use ArbitrageGoogleSheet\NamedGSheet;

class ReadTest extends \PHPUnit\Framework\TestCase
{
	private GSheet $sheet;

	protected function setUp(): void
	{
		parent::setUp();

		$this->sheet = $this->createGSheet();
	}

	public function testReadRow()
	{
		$row = $this->sheet->getRowByIndex(7);
		$this->assertInstanceOf(Row::class, $row);
		$this->assertNotNull($row->getEan());
		$this->assertNotEmpty($row->getAmazonDataNl()->getHighestPrice7DaysInclVAT());
		$this->assertNotEmpty($row->getAmazonDataDe()->getHighestPrice7DaysInclVAT());
	}

	private function createGSheet(): GSheet
	{
		$namedGSheet = NamedGSheet::create(NamedGSheet::NEW_TOP_SELLING);

		$clientConfig = new ClientConfig(__DIR__.'/../../var/token.json', __DIR__.'/../../var/credentials.json');

		$factory = new GSheetFactory((new ClientFactory())->create($clientConfig));
		return $factory->createArbitrage($namedGSheet);
	}
}
