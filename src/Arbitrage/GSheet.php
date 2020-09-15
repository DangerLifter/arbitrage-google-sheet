<?php
namespace ArbitrageGoogleSheet\Arbitrage;

use ArbitrageGoogleSheet\Arbitrage\Row\AmazonScrapedData;
use ArbitrageGoogleSheet\Arbitrage\Row\BolComRepriceData;
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
			'competitorPrice' => $this->priceToString($row->getCompetitorPrice()),
			'rebelPrice' => $this->priceToString($row->getRebelPrice()),
			'updatedAt' =>  $this->dateToString($row->getUpdatedAt())
		];
		return $this->writeDataToSheet($mappedData, $index, $this->getMeta()->getColumnMap()['bolCom']);
	}

	public function writeAmazonDeInfoRowByIndex(int $index, AmazonScrapedData $row): WriterInterface
	{
		$mappedData = [
			'price' => $this->priceToString($row->getPrice()),
			'maxQty' => $row->getMaxQty() ?? '',
			'deliveryInDays' => $row->getDeliveryInDays() ?? '',
			'hasGiftOption' => $row->getHasGiftOption() ? '1' : '0',
			'updatedAt' =>  $this->dateToString($row->getUpdatedAt())
		];
		return $this->writeDataToSheet($mappedData, $index, $this->getMeta()->getColumnMap()['amazonDe']);
	}

	public function writeAmazonNlInfoRowByIndex(int $index, AmazonScrapedData $row): WriterInterface
	{
		$mappedData = [
			'price' => $this->priceToString($row->getPrice()),
			'maxQty' => $row->getMaxQty() ?? '',
			'deliveryInDays' => $row->getDeliveryInDays() ?? '',
			'hasGiftOption' => $row->getHasGiftOption() ? '1' : '0',
			'updatedAt' => $this->dateToString($row->getUpdatedAt())
		];
		return $this->writeDataToSheet($mappedData, $index, $this->getMeta()->getColumnMap()['amazonNl']);
	}

	public function writeBolComRepriceInfoByIndex(int $index, BolComRepriceData $data): self
	{
		$mappedData = [
			'newPrice' => $this->priceToString($data->getNewPrice()),
			'updatedAt' => $this->dateToString($data->getUpdatedAt()),
		];
		return $this->writeDataToSheet($mappedData, $index, $this->getMeta()->getColumnMap()['bolComRepriceData']);
	}

	public function writeMessage(int $index, string $message = ''): self
	{
		$mappedData = [
			'message' => $message,
		];
		return $this->writeDataToSheet($mappedData, $index, $this->getMeta()->getColumnMap());
	}

	// TODO: extract transformer class + transformers in map from string to value
	private function priceToString(?float $price): string
	{
		return $price ? sprintf('%0.2f', round($price, 2)) : '';
	}

	private function dateToString(?\DateTime $dateTime): string
	{
		return $dateTime ? $dateTime->format('d-m-Y H:i') : '';
	}
}