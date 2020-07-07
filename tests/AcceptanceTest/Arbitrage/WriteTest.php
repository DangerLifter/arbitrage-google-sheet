<?php

namespace AcceptanceTest\Arbitrage;

use ArbitrageGoogleSheet\Arbitrage\GSheet;
use ArbitrageGoogleSheet\Arbitrage\Row;
use ArbitrageGoogleSheet\ClientConfig;
use ArbitrageGoogleSheet\ClientFactory;
use ArbitrageGoogleSheet\GSheetFactory;
use ArbitrageGoogleSheet\NamedGSheet;

class WriteTest extends \PHPUnit\Framework\TestCase
{
	private GSheet $sheet;

	protected function setUp(): void
	{
		parent::setUp();
	}

	public function testWriteBolComRepriceInfoByIndex()
	{
		$clientConfig = new ClientConfig(__DIR__.'/../../var/token.json', __DIR__.'/../../var/credentials.json');
		$client = (new ClientFactory())->create($clientConfig);

		$mockGoogleServiceSheets =
			$this->getMockBuilder(\Google_Service_Sheets::class)
				->setConstructorArgs([$client])
				->setMethods(['batchUpdate'])
				->getMock();

		$sheet = $this->createGSheet(NamedGSheet::create(NamedGSheet::NEW_TOP_SELLING), $mockGoogleServiceSheets);

		$googleReturnValue = new \Google_Service_Sheets_BatchUpdateValuesResponse();
		$googleReturnValue->setTotalUpdatedCells(1);
		$innerMock = $this->createMock(\Google_Service_Sheets_Resource_SpreadsheetsValues::class);
		$innerMock->expects($this->once())->method('batchUpdate')->will($this->returnValue($googleReturnValue));

		$mockGoogleServiceSheets->spreadsheets_values = $innerMock;

		$repriceData =
			(new Row\BolComRepriceData())
			->setNewPrice(50.7)
			->setUpdatedAt(new \DateTime('2020-07-20 10:10:10'));

		$sheet->writeBolComRepriceInfoByIndex(2, $repriceData);
	}

	private function createGSheet(NamedGSheet $namedGSheet, $mockGoogleServiceSheets): GSheet
	{
		$factory = new GSheetFactory($mockGoogleServiceSheets);
		return $factory->createArbitrage($namedGSheet);
	}
}
