<?php
namespace ArbitrageGoogleSheet\Arbitrage;

use ArbitrageGoogleSheet\Arbitrage\Row\AmazonData;
use ArbitrageGoogleSheet\Arbitrage\Row\AmazonScrapedData;
use ArbitrageGoogleSheet\Arbitrage\Row\BolComRepriceData;
use ArbitrageGoogleSheet\Arbitrage\Row\BolComScrapedData;
use ArbitrageGoogleSheet\GSheet\Row\RowAbstract;

class Row extends RowAbstract implements \JsonSerializable
{
	private BolComScrapedData $_bolCom;

	private AmazonScrapedData $_amazonDe;

	private AmazonData $_amazonDataDe;

	private AmazonScrapedData $_amazonNl;

	private AmazonData $_amazonDataNl;

	private BolComRepriceData $_bolComRepriceData;

	private ?string $_ean = null;

	public function __construct()
	{
		$this->_bolCom = new BolComScrapedData();
		$this->_amazonDe = new AmazonScrapedData();
		$this->_amazonNl = new AmazonScrapedData();
		$this->_amazonDataDe = new AmazonData();
		$this->_amazonDataNl = new AmazonData();
		$this->_bolComRepriceData = new BolComRepriceData();
	}

	public function getBolComRepriceData(): BolComRepriceData
	{
		return $this->_bolComRepriceData;
	}

	public function getAmazonDataDe(): AmazonData
	{
		return $this->_amazonDataDe;
	}

	public function getAmazonDataNl(): AmazonData
	{
		return $this->_amazonDataNl;
	}

	public function getBolCom(): BolComScrapedData
	{
		return $this->_bolCom;
	}

	public function getAmazonDe(): AmazonScrapedData
	{
		return $this->_amazonDe;
	}

	public function getAmazonNl(): AmazonScrapedData
	{
		return $this->_amazonNl;
	}

	public function setEan(?string $ean): self
	{
		$this->_ean = $ean;
		return $this;
	}

	public function getEan(): ?string
	{
		return $this->_ean;
	}

	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}