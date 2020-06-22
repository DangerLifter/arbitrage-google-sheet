<?php
namespace ArbitrageGoogleSheet\Row;

class RowFactory
{
	public function createRowSourceData(array $data = null, array $map = null): RowSourceData
	{
		$row = new RowSourceData();
		if ($data && $map) {
			$this->fill($row, $data, $map);
		}
		return $row;
	}

	public function createRowScrapedData(array $data = null, array $map = null): RowScrapedData
	{
		$row = new RowScrapedData();
		if ($data && $map) {
			$this->fill($row->getBolCom(), $data, $map['bolCom'] ?? []);
			$this->fill($row->getAmazonDe(), $data, $map['amazonDe'] ?? []);
			$this->fill($row->getAmazonNl(), $data, $map['amazonNl'] ?? []);
		}
		return $row;
	}

	private function fill(Object $row, array $data, array $map): self
	{
		foreach ($map as $propertyName => $clmName) {
			if (!isset($clmName)) continue;
			if (is_string($clmName)) {
				$clmIndex = RowHelper::columnNameToIndex($clmName);
			} elseif (is_numeric($clmName)) {
				$clmIndex = (int) $clmName;
			} else {
				continue;
			}
			if (array_key_exists($clmIndex, $data)) {
				$setMethod = 'set'.ucfirst($propertyName);
				$row->{$setMethod}($data[$clmIndex]);
			}
		}
		return $this;
	}
}