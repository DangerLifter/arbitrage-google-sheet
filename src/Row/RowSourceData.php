<?php
namespace ArbitrageGoogleSheet\Row;

class RowSourceData extends RowAbstract implements \JsonSerializable
{
	private ?string $_bolComLink;

	private ?string $_bolComUpdatedAt;

	private ?string $_amazonDeLink;

	private ?string $_amazonDeUpdatedAt;

	private ?string $_amazonNlLink;

	private ?string $_amazonNlUpdatedAt;

	public function getBolComLink(): ?string
	{
		return $this->_bolComLink;
	}

	public function setBolComLink(?string $bolComLink): self
	{
		$this->_bolComLink = $bolComLink;
		return $this;
	}

	public function getAmazonDeLink(): ?string
	{
		return $this->_amazonDeLink;
	}

	public function setAmazonDeLink(?string $amazonDeLink): self
	{
		$this->_amazonDeLink = $amazonDeLink;
		return $this;
	}

	public function getAmazonNlLink(): ?string
	{
		return $this->_amazonNlLink;
	}

	public function setAmazonNlLink(?string $amazonNlLink): self
	{
		$this->_amazonNlLink = $amazonNlLink;
		return $this;
	}

	public function getBolComUpdatedAt(): ?string
	{
		return $this->_bolComUpdatedAt;
	}

	public function setBolComUpdatedAt(?string $bolComUpdatedAt): self
	{
		$this->_bolComUpdatedAt = $bolComUpdatedAt;
		return $this;
	}

	public function getAmazonDeUpdatedAt(): ?string
	{
		return $this->_amazonDeUpdatedAt;
	}

	public function setAmazonDeUpdatedAt(?string $amazonDeUpdatedAt): self
	{
		$this->_amazonDeUpdatedAt = $amazonDeUpdatedAt;
		return $this;
	}

	public function getAmazonNlUpdatedAt(): ?string
	{
		return $this->_amazonNlUpdatedAt;
	}

	public function setAmazonNlUpdatedAt(?string $amazonNlUpdatedAt): self
	{
		$this->_amazonNlUpdatedAt = $amazonNlUpdatedAt;
		return $this;
	}

	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}