<?php
namespace ArbitrageGoogleSheet\GSheet;

use ArbitrageGoogleSheet\Row\RowSourceData;

interface GSheetSourceInterface extends GSheetInterface
{
	public function getRowByIndex(int $index): RowSourceData;
	/**
	 * @return RowSourceData[]
	 */
	public function getRowsByIndexRange(int $start, int $end): array;
}