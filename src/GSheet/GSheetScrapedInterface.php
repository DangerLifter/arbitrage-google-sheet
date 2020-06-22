<?php
namespace ArbitrageGoogleSheet\GSheet;

use ArbitrageGoogleSheet\Row\AmazonScrapedData;
use ArbitrageGoogleSheet\Row\BolComScrapedData;
use ArbitrageGoogleSheet\Row\RowScrapedData;

interface GSheetScrapedInterface extends GSheetInterface
{
	public function getRowByIndex(int $index): RowScrapedData;

	public function writeBolInfoRowByIndex(int $index, BolComScrapedData $row): self;

	public function writeAmazonDeInfoRowByIndex(int $index, AmazonScrapedData $row): self;

	public function writeAmazonNlInfoRowByIndex(int $index, AmazonScrapedData $row): self;
}