<?php
namespace ArbitrageGoogleSheet\Row;

class BolComScrapedData
{
	private ?string $_link;

	private ?string $_competitorPrice;

	private ?string $_rebelPrice;

	private ?string $_updatedAt;

	public function getLink(): ?string
	{
		return $this->_link;
	}

	public function setLink(?string $bolComLink): self
	{
		$this->_link = $bolComLink;
		return $this;
	}

	public function getCompetitorPrice(): ?string
	{
		return $this->_competitorPrice;
	}

	public function setCompetitorPrice(?string $bolComCompetitorPrice): self
	{
		$this->_competitorPrice = $bolComCompetitorPrice;
		return $this;
	}

	public function getRebelPrice(): ?string
	{
		return $this->_rebelPrice;
	}

	public function setRebelPrice(?string $bolComRebelPrice): self
	{
		$this->_rebelPrice = $bolComRebelPrice;
		return $this;
	}

	public function getUpdatedAt(): ?string
	{
		return $this->_updatedAt;
	}

	public function setUpdatedAt(?string $bolComUpdatedAt): self
	{
		$this->_updatedAt = $bolComUpdatedAt;
		return $this;
	}
}