<?php
namespace ArbitrageGoogleSheet\GSheet;

use ArbitrageGoogleSheet\GSheet\Row\Helper;

trait WriterTrait
{
	abstract protected function getSheetService(): \Google_Service_Sheets;

	abstract public function getMeta(): Meta;

	abstract protected function getSheet(): \Google_Service_Sheets_Sheet;

	protected function writeDataToSheet(array $mappedData, int $rowIndex, array $map): self
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
		$result = $this->getSheetService()->spreadsheets_values->batchUpdate($this->getMeta()->getSpreadsheetId(), $request, $params);
		if (!$result->getTotalUpdatedCells()) {
			throw new \RuntimeException('Failed write to google sheet');
		}

		return $this;
	}

	protected function createGSheetWriteValueRange(string $value, string $propertyName, int $rowIndex, array $map): \Google_Service_Sheets_ValueRange
	{
		$sheetTitle = $this->getSheet()->getProperties()->getTitle();
		$clmName = $map[$propertyName];
		if (is_array($clmName)) $clmName = $clmName[0];
		return new \Google_Service_Sheets_ValueRange([
			'values' => [[$value ?? '']],
			'range' => Helper::getRangeForSingleRow($sheetTitle, $clmName, $rowIndex)
		]);
	}
}