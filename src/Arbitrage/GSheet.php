<?php
namespace ArbitrageGoogleSheet\Arbitrage;

use ArbitrageGoogleSheet\Arbitrage\Row\AmazonScrapedData;
use ArbitrageGoogleSheet\Arbitrage\Row\BolComScrapedData;
use ArbitrageGoogleSheet\GSheet\WriterTrait;
use ArbitrageGoogleSheet\GSheet\GSheet as GSheetBase;

class GSheet extends GSheetBase implements ReaderInterface, WriterInterface
{
	use WriterTrait;

	public function getRowByIndex(int $index): Row
	{
		$row = parent::getRowByIndex($index);
		if (!$row instanceof Row) throw new \RuntimeException('Wrong row class '.\get_class($row));
		return $row;
	}

	public function writeBolInfoRowByIndex(int $index, BolComScrapedData $row): WriterInterface
	{
		$mappedData = [
			'competitorPrice' => $row->getCompetitorPrice() ? (float) $row->getCompetitorPrice() : '',
			'rebelPrice' => $row->getRebelPrice() ? (float) $row->getRebelPrice() : '',
			'updatedAt' => $row->getUpdatedAt(),
		];
		return $this->writeDataToSheet($mappedData, $index, $this->getMeta()->getColumnMap()['bolCom']);
	}

	public function writeAmazonDeInfoRowByIndex(int $index, AmazonScrapedData $row): WriterInterface
	{
		$mappedData = [
			'price' => $row->getPrice() ? (float) $row->getPrice() : '',
			'maxQty' => $row->getMaxQty() ? (int) $row->getMaxQty() : '',
			'deliveryInDays' => $row->getDeliveryInDays() ? (int) $row->getDeliveryInDays() : '',
			'hasGiftOption' => $row->getHasGiftOption() ? '1' : '0',
			'updatedAt' => $row->getUpdatedAt(),
		];
		return $this->writeDataToSheet($mappedData, $index, $this->getMeta()->getColumnMap()['amazonDe']);
	}

	public function writeAmazonNlInfoRowByIndex(int $index, AmazonScrapedData $row): WriterInterface
	{
		$mappedData = [
			'price' => $row->getPrice() ? (float) $row->getPrice() : '',
			'maxQty' => $row->getMaxQty() ? (int) $row->getMaxQty() : '',
			'deliveryInDays' => $row->getDeliveryInDays() ? (int) $row->getDeliveryInDays() : '',
			'hasGiftOption' => $row->getHasGiftOption() ? '1' : '0',
			'updatedAt' => $row->getUpdatedAt(),
		];
		return $this->writeDataToSheet($mappedData, $index, $this->getMeta()->getColumnMap()['amazonNl']);
	}
}