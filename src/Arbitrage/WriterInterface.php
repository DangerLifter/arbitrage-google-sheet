<?php
namespace ArbitrageGoogleSheet\Arbitrage;

use ArbitrageGoogleSheet\Arbitrage\Row\AmazonScrapedData;
use ArbitrageGoogleSheet\Arbitrage\Row\BolComRepriceData;
use ArbitrageGoogleSheet\Arbitrage\Row\BolComScrapedData;

interface WriterInterface
{
	public function writeBolInfoRowByIndex(int $index, BolComScrapedData $row): self;

	public function writeAmazonDeInfoRowByIndex(int $index, AmazonScrapedData $row): self;

	public function writeAmazonNlInfoRowByIndex(int $index, AmazonScrapedData $row): self;

	public function writeBolComRepriceInfoByIndex(int $index, BolComRepriceData $data): self;
}