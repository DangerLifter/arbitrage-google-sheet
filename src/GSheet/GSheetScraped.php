<?php
namespace ArbitrageGoogleSheet\GSheet;

use ArbitrageGoogleSheet\Row\AmazonScrapedData;
use ArbitrageGoogleSheet\Row\BolComScrapedData;
use ArbitrageGoogleSheet\Row\RowAbstract;
use ArbitrageGoogleSheet\Row\RowHelper;
use ArbitrageGoogleSheet\Row\RowScrapedData;

class GSheetScraped extends GSheetAbstract implements GSheetScrapedInterface
{
	public function getRowByIndex(int $index): RowScrapedData
	{
		$row = parent::getRowByIndex($index);
		if (!$row instanceof RowScrapedData) throw new \RuntimeException('Wrong row class '.\get_class($row));
		return $row;
	}

	public function writeBolInfoRowByIndex(int $index, BolComScrapedData $row): GSheetScrapedInterface
	{
		$mappedData = [
			'competitorPrice' => $row->getCompetitorPrice() ? (float) $row->getCompetitorPrice() : '',
			'rebelPrice' => $row->getRebelPrice() ? (float) $row->getRebelPrice() : '',
			'updatedAt' => $row->getUpdatedAt(),
		];
		return $this->writeDataToSheet($mappedData, $index, $this->getMeta()->getColumnMap()['bolCom']);
	}

	public function writeAmazonDeInfoRowByIndex(int $index, AmazonScrapedData $row): GSheetScrapedInterface
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

	public function writeAmazonNlInfoRowByIndex(int $index, AmazonScrapedData $row): GSheetScrapedInterface
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

	protected function createRow(array $data): RowAbstract
	{
		return $this->_rowFactory->createRowScrapedData($data, $this->getMeta()->getColumnMap());
	}

	private function writeDataToSheet(array $mappedData, int $rowIndex, array $map): self
	{
		$data = [];
		foreach ($mappedData as $propertyName => $value) {
			$data[] = $this->createGSheetWriteValueRange($value, $propertyName, $rowIndex, $map);
		}
		$request = new \Google_Service_Sheets_BatchUpdateValuesRequest([
			'valueInputOption' => 'USER_ENTERED',
			'data' => $data
		]);
		//https://developers.google.com/sheets/api/reference/rest/v4/ValueInputOption
		$params = [];
		$result = $this->_sheetService->spreadsheets_values->batchUpdate($this->getMeta()->getSpreadsheetId(), $request, $params);
		if (!$result->getTotalUpdatedCells()) {
			throw new \RuntimeException('Failed write to google sheet');
		}

		return $this;
	}

	private function createGSheetWriteValueRange(string $value, string $propertyName, int $rowIndex, array $map): \Google_Service_Sheets_ValueRange
	{
		$sheetTitle = $this->_sheet->getProperties()->getTitle();
		$clmName = $map[$propertyName];
		return new \Google_Service_Sheets_ValueRange([
			'values' => [[$value ?? '']],
			'range' => RowHelper::getRangeForSingleRow($sheetTitle, $clmName, $rowIndex)
		]);
	}
}