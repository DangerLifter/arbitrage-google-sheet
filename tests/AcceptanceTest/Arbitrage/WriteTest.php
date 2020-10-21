<?php

namespace AcceptanceTest\Arbitrage;

use ArbitrageGoogleSheet\Arbitrage\GSheet;
use ArbitrageGoogleSheet\Arbitrage\Row;
use ArbitrageGoogleSheet\ClientConfig;
use ArbitrageGoogleSheet\ClientFactory;
use ArbitrageGoogleSheet\GSheetFactory;

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

		$sheet = $this->createGSheet('946036192',$mockGoogleServiceSheets);

		$googleReturnValue = new \Google_Service_Sheets_BatchUpdateValuesResponse();
		$googleReturnValue->setTotalUpdatedCells(1);
		$innerMock = $this->createMock(\Google_Service_Sheets_Resource_SpreadsheetsValues::class);
		$innerMock->expects(self::once())->method('batchUpdate')->will(self::returnValue($googleReturnValue));

		$mockGoogleServiceSheets->spreadsheets_values = $innerMock;

		$repriceData =
			(new Row\BolComRepriceData())
			->setNewPrice(50.7)
			->setUpdatedAt(new \DateTime('2020-07-20 10:10:10'));

		$sheet->writeBolComRepriceInfoByIndex(2, $repriceData);
	}

	private function createGSheet(string $sheetId, $mockGoogleServiceSheets): GSheet
	{
		$factory = new GSheetFactory($mockGoogleServiceSheets);
		return $factory->createSheet($factory->createArbitrageMeta($sheetId));
	}
}
