<?php
namespace ArbitrageGoogleSheet\GSheet;


use ArbitrageGoogleSheet\GSheet\Row\FactoryInterface;
use ArbitrageGoogleSheet\GSheet\Row\Helper;
use ArbitrageGoogleSheet\GSheet\Row\RowAbstract;

class GSheet implements ReaderInterface
{
	protected $_sheetService;
	protected $_sheet;
	protected $_rowFactory;
	protected $_meta;

	private $_rowCache = [];

	public function __construct(\Google_Service_Sheets $sheetService, \Google_Service_Sheets_Sheet $sheet, Meta $meta, FactoryInterface $rowFactory)
	{
		$this->_sheetService = $sheetService;
		$this->_sheet = $sheet;
		$this->_meta = $meta;
		$this->_rowFactory = $rowFactory;
	}

	public function getMeta(): Meta
	{
		return $this->_meta;
	}

	public function getLastRowIndex(): int
	{
		return $this->_sheet->getProperties()->getGridProperties()->rowCount;
	}

	public function getStartRowIndex(): int
	{
		return $this->_meta->getHeaderSize() + 1;
	}

	public function getRowByIndex(int $index): RowAbstract
	{
		// FYI: quick trick solution for "Quota exceeded for quota group 'ReadGroup' and limit 'Read requests per user per 100 seconds' of service 'sheets.googleapis.com' for consumer 'project_number:14883411965'
		if (!isset($this->_rowCache[$index])) {
			$rows = $this->readRows($index, $index);
			$this->_rowCache[$index] = $rows[$index];
		}
		return $this->_rowCache[$index];
	}

	public function getRowsByIndexRange(int $start, int $end): array
	{
		return $this->readRows($start, $end);
	}

	protected function getSheetService(): \Google_Service_Sheets
	{
		return $this->_sheetService;
	}

	protected function getSheet(): \Google_Service_Sheets_Sheet
	{
		return $this->_sheet;
	}

	protected function getRowFactory(): FactoryInterface
	{
		return $this->_rowFactory;
	}

	/**
	 * @return RowAbstract[]
	 */
	protected function readRows(int $start, int $end): array
	{
		$meta = $this->getMeta();
		$range = Helper::getRange(
			$this->_sheet->getProperties()->getTitle(), $meta->getMaxColumnName(), $end, 'A', $start
		);
		$response = $this->_sheetService->spreadsheets_values->get($meta->getSpreadsheetId(), $range);
		$values = $response->getValues();
		$result = [];
		for ($i = $start, $k = 0; $i <= $end; $i++, $k++) {
			$result[$i] = $this->createRow($values[$k] ?? []);
		}

		return $result;
	}

	protected function createRow(array $data): RowAbstract
	{
		return $this->_rowFactory->create($data, $this->getMeta()->getColumnMap());
	}
}