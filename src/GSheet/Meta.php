<?php
namespace ArbitrageGoogleSheet\GSheet;

class Meta
{
	private string $_spreadsheetId;

	private int $_sheetId;

	private string $_maxColumnName;

	private int $_headerSize;

	private array $_columnMap = [];

	public function __construct(string $_spreadsheetId, int $_sheetId, string $_maxColumnName, array $columnMap, int $_headerSize = 1)
	{
		$this->_spreadsheetId = $_spreadsheetId;
		$this->_sheetId = $_sheetId;
		$this->_maxColumnName = $_maxColumnName;
		$this->_headerSize = $_headerSize;
		$this->_columnMap = $columnMap;
	}

	// TODO: map must be object also
	public function getColumnMap(): array
	{
		return $this->_columnMap;
	}

	public function addToColumnMap(string $key, $value): self
	{
		$this->_columnMap[$key] = $value;
		return $this;
	}

	public function getSpreadsheetId(): string
	{
		return $this->_spreadsheetId;
	}

	public function getSheetId(): int
	{
		return $this->_sheetId;
	}

	public function getMaxColumnName(): string
	{
		return $this->_maxColumnName;
	}

	public function getHeaderSize(): int
	{
		return $this->_headerSize;
	}
}