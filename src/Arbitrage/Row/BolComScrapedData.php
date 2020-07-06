<?php
namespace ArbitrageGoogleSheet\Arbitrage\Row;

class BolComScrapedData
{
	private ?string $_link = null;

	private ?float $_competitorPrice = null;

	private ?float $_rebelPrice = null;

	private ?\DateTime $_updatedAt = null;

	public function getLink(): ?string
	{
		return $this->_link;
	}

	public function setLink(?string $bolComLink): self
	{
		$this->_link = $bolComLink;
		return $this;
	}

	public function getCompetitorPrice(): ?float
	{
		return $this->_competitorPrice;
	}

	public function setCompetitorPrice(?float $bolComCompetitorPrice): self
	{
		$this->_competitorPrice = $bolComCompetitorPrice;
		return $this;
	}

	public function getRebelPrice(): ?float
	{
		return $this->_rebelPrice;
	}

	public function setRebelPrice(?float $bolComRebelPrice): self
	{
		$this->_rebelPrice = $bolComRebelPrice;
		return $this;
	}

	public function getUpdatedAt(): ?\DateTime
	{
		return $this->_updatedAt;
	}

	public function setUpdatedAt(?\DateTime $bolComUpdatedAt): self
	{
		$this->_updatedAt = $bolComUpdatedAt;
		return $this;
	}
}