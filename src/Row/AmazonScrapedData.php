<?php
namespace ArbitrageGoogleSheet\Row;

class AmazonScrapedData
{
	private ?string  $_link;

	private ?string  $_price;

	private ?string  $_shippingCost;

	private ?string  $_maxQty;

	private ?string  $_shippingInfo;

	private ?string  $_deliveryInDays;

	private ?string  $_updatedAt;

	private ?bool $hasGiftOption;

	public function getLink(): ?string
	{
		return $this->_link;
	}

	public function setLink(?string $link): self
	{
		$this->_link = $link;
		return $this;
	}

	public function getPrice(): ?string
	{
		return $this->_price;
	}

	public function setPrice(?string $price): self
	{
		$this->_price = $price;
		return $this;
	}

	public function getShippingCost(): ?string
	{
		return $this->_shippingCost;
	}

	public function setShippingCost(?string $shippingCost): self
	{
		$this->_shippingCost = $shippingCost;
		return $this;
	}

	public function getMaxQty(): ?string
	{
		return $this->_maxQty;
	}

	public function setMaxQty(?string $maxQty): self
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

	public function getDeliveryInDays(): ?string
	{
		return $this->_deliveryInDays;
	}

	public function setDeliveryInDays(?string $liveryInDays): self
	{
		$this->_deliveryInDays = $liveryInDays;
		return $this;
	}

	public function getUpdatedAt(): ?string
	{
		return $this->_updatedAt;
	}

	public function setUpdatedAt(?string $updatedAt): self
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