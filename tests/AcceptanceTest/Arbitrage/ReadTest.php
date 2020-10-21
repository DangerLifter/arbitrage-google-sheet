<?php

namespace AcceptanceTest\Arbitrage;

use ArbitrageGoogleSheet\Arbitrage\GSheet;
use ArbitrageGoogleSheet\ClientConfig;
use ArbitrageGoogleSheet\ClientFactory;
use ArbitrageGoogleSheet\GSheetFactory;

class ReadTest extends \PHPUnit\Framework\TestCase
{
	private GSheet $sheet;

	protected function setUp(): void
	{
		parent::setUp();
	}

	public function testReadRow()
	{
		$sheet = $this->createGSheet('946036192');

		$row = $sheet->getRowByIndex(2);
		self::assertNotNull($row->getEan());

		self::assertNotEmpty($row->getAmazonDataNl()->getHighestPrice7DaysInclVAT());
		self::assertNotEmpty($row->getAmazonDataDe()->getHighestPrice7DaysInclVAT());

//		$this->assertNotNull($row->getBolComRepriceData()->getNewPrice());
//		$this->assertNotNull($row->getBolComRepriceData()->getUpdatedAt());
	}

	private function createGSheet(string $sheetId): GSheet
	{
		$clientConfig = new ClientConfig(__DIR__.'/../../var/token.json', __DIR__.'/../../var/credentials.json');

		$client = (new ClientFactory())->create($clientConfig);
		$factory = new GSheetFactory( new \Google_Service_Sheets($client));
		return $factory->createSheet($factory->createArbitrageMeta($sheetId));
	}
}
