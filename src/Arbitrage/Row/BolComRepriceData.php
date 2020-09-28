<?php
namespace ArbitrageGoogleSheet\Arbitrage\Row;

class BolComRepriceData
{
	private ?float $newPrice = null;

	private ?\DateTime $updatedAt = null;

	private bool $isApplyNewPrice = false;

	public function getNewPrice(): ?float
	{
		return $this->newPrice;
	}

	public function setNewPrice(?float $newPrice): self
	{
		$this->newPrice = $newPrice;
		return $this;
	}

	public function getUpdatedAt(): ?\DateTime
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(?\DateTime $updatedAt): self
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}

	public function isApplyNewPrice(): bool
	{
		return $this->isApplyNewPrice;
	}

	public function setIsApplyNewPrice(bool $isApplyNewPrice): self
	{
		$this->isApplyNewPrice = $isApplyNewPrice;
		return $this;
	}
}