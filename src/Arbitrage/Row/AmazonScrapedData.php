<?php
namespace ArbitrageGoogleSheet\Arbitrage\Row;

class AmazonScrapedData
{
	private ?string  $_link = null;

	private ?float  $_price = null;

	private ?string  $_shippingCost = null;

	private ?int  $_maxQty = null;

	private ?float  $_shippingInfo = null;

	private ?int  $_deliveryInDays = null;

	private ?\DateTime  $_updatedAt = null;

	private ?bool $hasGiftOption = false;

	public function getLink(): ?string
	{
		return $this->_link;
	}

	public function setLink(?string $link): self
	{
		$this->_link = $link;
		return $this;
	}

	public function getPrice(): ?float
	{
		return $this->_price;
	}

	public function setPrice(?float $price): self
	{
		$this->_price = $price;
		return $this;
	}

	public function getShippingCost(): ?float
	{
		return $this->_shippingCost;
	}

	public function setShippingCost(?float $shippingCost): self
	{
		$this->_shippingCost = $shippingCost;
		return $this;
	}

	public function getMaxQty(): ?int
	{
		return $this->_maxQty;
	}

	public function setMaxQty(?int $maxQty): self
	{
		$this->_maxQty = $maxQty;
		return $this;
	}

	public function getShippingInfo(): ?string
	{
		return $this->_shippingInfo;
	}

	public function setShippingInfo(?string $shippingInfo): self
	{
		$this->_shippingInfo = $shippingInfo;
		return $this;
	}

	public function getDeliveryInDays(): ?int
	{
		return $this->_deliveryInDays;
	}

	public function setDeliveryInDays(?int $liveryInDays): self
	{
		$this->_deliveryInDays = $liveryInDays;
		return $this;
	}

	public function getUpdatedAt(): ?\DateTime
	{
		return $this->_updatedAt;
	}

	public function setUpdatedAt(?\DateTime $updatedAt): self
	{
		$this->_updatedAt = $updatedAt;
		return $this;
	}

	public function getHasGiftOption(): ?bool
	{
		return $this->hasGiftOption;
	}

	public function setHasGiftOption(?bool $hasGiftOption): self
	{
		$this->hasGiftOption = $hasGiftOption;
		return $this;
	}
}