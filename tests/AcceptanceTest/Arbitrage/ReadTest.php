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
	}

	public function testReadRow()
	{
		$sheet = $this->createGSheet(NamedGSheet::create(NamedGSheet::NEW_TOP_SELLING));

		$row = $sheet->getRowByIndex(2);
		$this->assertInstanceOf(Row::class, $row);
		$this->assertNotNull($row->getEan());

		$this->assertNotEmpty($row->getAmazonDataNl()->getHighestPrice7DaysInclVAT());
		$this->assertNotEmpty($row->getAmazonDataDe()->getHighestPrice7DaysInclVAT());

//		$this->assertNotNull($row->getBolComRepriceData()->getNewPrice());
//		$this->assertNotNull($row->getBolComRepriceData()->getUpdatedAt());
	}

	private function createGSheet(NamedGSheet $namedGSheet): GSheet
	{
		$clientConfig = new ClientConfig(__DIR__.'/../../var/token.json', __DIR__.'/../../var/credentials.json');

		$client = (new ClientFactory())->create($clientConfig);
		$factory = new GSheetFactory( new \Google_Service_Sheets($client));
		return $factory->createArbitrage($namedGSheet);
	}
}
