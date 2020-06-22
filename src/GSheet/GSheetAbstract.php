<?php
namespace ArbitrageGoogleSheet\GSheet;

use ArbitrageGoogleSheet\Row\RowAbstract;
use ArbitrageGoogleSheet\Row\RowFactory;

abstract class GSheetAbstract implements GSheetInterface
{
	protected $_sheetService;
	protected $_sheet;
	protected $_rowFactory;
	protected $_meta;

	private $_rowCache = [];

	abstract protected function createRow(array $data): RowAbstract;

	public function __construct(\Google_Service_Sheets $sheetService, \Google_Service_Sheets_Sheet $sheet, GSheetMeta $meta)
	{
		$this->_sheetService = $sheetService;
		$this->_sheet = $sheet;
		$this->_meta = $meta;
		$this->_rowFactory = new RowFactory();
	}

	public function getMeta(): GSheetMeta
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

	/**
	 * @return RowAbstract[]
	 */
	protected function readRows(int $start, int $end): array
	{
		// TODO: extract row factory interface. and put factory to meta. or constructor of sheet.
		$meta = $this->getMeta();
		$range = sprintf("'%s'!A%d:%s%d", $this->_sheet->getProperties()->getTitle(),$start, $meta->getMaxColumnName(), $end);
		$response = $this->_sheetService->spreadsheets_values->get($meta->getSpreadsheetId(), $range);
		$values = $response->getValues();
		$result = [];
		for ($i = $start, $k = 0; $i <= $end; $i++, $k++) {
			$result[$i] = $this->createRow($values[$k] ?? []);
		}

		return $result;
	}
}