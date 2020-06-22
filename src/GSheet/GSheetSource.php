<?php
namespace ArbitrageGoogleSheet\GSheet;

use ArbitrageGoogleSheet\Row\RowAbstract;
use ArbitrageGoogleSheet\Row\RowSourceData;

class GSheetSource extends GSheetAbstract implements GSheetSourceInterface
{
	protected function createRow(array $data): RowAbstract
	{
		return $this->_rowFactory->createRowSourceData($data, $this->getMeta()->getColumnMap());
	}

	public function getRowByIndex(int $index): RowSourceData
	{
		$row = parent::getRowByIndex($index);
		if (!$row instanceof RowSourceData) throw new \RuntimeException('Wrong row class');
		return $row;
	}

	public function getRowsByIndexRange(int $start, int $end): array
	{
		return parent::getRowsByIndexRange($start, $end);
	}
}