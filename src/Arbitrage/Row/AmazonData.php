<?php
namespace ArbitrageGoogleSheet\Arbitrage\Row;

class AmazonData
{
	//amazon highest price last 7 days including VAT
	private ?float $highestPrice7DaysInclVAT = null;

	public function getHighestPrice7DaysInclVAT(): ?float
	{
		return $this->highestPrice7DaysInclVAT;
	}

	public function setHighestPrice7DaysInclVAT(?float $highestPrice7DaysInclVAT): self
	{
		$this->highestPrice7DaysInclVAT = $highestPrice7DaysInclVAT;
		return $this;
	}
}