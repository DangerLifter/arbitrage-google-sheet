<?php
namespace ArbitrageGoogleSheet\Row;

class RowScrapedData extends RowAbstract
{
	private BolComScrapedData $_bolCom;

	private AmazonScrapedData $_amazonDe;

	private AmazonScrapedData $_amazonNl;

	private ?string $_ean = null;

	public function __construct()
	{
		$this->_bolCom = new BolComScrapedData();
		$this->_amazonDe = new AmazonScrapedData();
		$this->_amazonNl = new AmazonScrapedData();
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
}