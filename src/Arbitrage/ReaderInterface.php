<?php
namespace ArbitrageGoogleSheet\Arbitrage;

use ArbitrageGoogleSheet\Arbitrage\Row;
use ArbitrageGoogleSheet\GSheet\ReaderInterface as BaseReaderInterface;

interface ReaderInterface extends BaseReaderInterface
{
	public function getRowByIndex(int $index): Row;
}