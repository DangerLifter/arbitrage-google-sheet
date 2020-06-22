<?php
namespace ArbitrageGoogleSheet\GSheet;

use ArbitrageGoogleSheet\Row\RowAbstract;

interface GSheetInterface
{
	public function getLastRowIndex(): int;

	public function getStartRowIndex(): int;

	public function getRowByIndex(int $index): RowAbstract;

	/**
	 * @return RowAbstract[]
	 */
	public function getRowsByIndexRange(int $start, int $end): array;

	public function getMeta(): GSheetMeta;
}