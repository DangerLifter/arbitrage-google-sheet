<?php
namespace ArbitrageGoogleSheet\Arbitrage;

use ArbitrageGoogleSheet\GSheet\Row\FactoryInterface;
use ArbitrageGoogleSheet\GSheet\Row\Helper;

class RowFactory implements FactoryInterface
{
	public function create(array $data = null, array $map = []): Row
	{
		$row = new Row();
		if ($data && $map) {
			$this->fill($row->getBolCom(), $data, $map['bolCom'] ?? []);
			unset($map['bolCom']);
			$this->fill($row->getAmazonDe(), $data, $map['amazonDe'] ?? []);
			unset($map['amazonDe']);
			$this->fill($row->getAmazonNl(), $data, $map['amazonNl'] ?? []);
			unset($map['amazonNl']);
			$this->fill($row->getAmazonDataDe(), $data, $map['amazonDataDe'] ?? []);
			unset($map['amazonDataDe']);
			$this->fill($row->getAmazonDataNl(), $data, $map['amazonDataNl'] ?? []);
			unset($map['amazonDataNl']);
			$this->fill($row, $data, $map);
		}
		return $row;
	}

	private function fill(Object $row, array $data, array $map): self
	{
		foreach ($map as $propertyName => $clmInfo) {
			if (is_array($clmInfo)) {
				list($clmName, $filter) = $clmInfo;
			} else {
				$clmName = $clmInfo;
				$filter = null;
			}


			if (!isset($clmName)) continue;
			if (is_string($clmName)) {
				$clmIndex = Helper::columnNameToIndex($clmName);
			} elseif (is_numeric($clmName)) {
				$clmIndex = (int) $clmName;
			} else {
				continue;
			}
			if (array_key_exists($clmIndex, $data)) {
				$setMethod = 'set'.ucfirst($propertyName);
				$value = is_callable($filter) ? $filter($data[$clmIndex]) : $data[$clmIndex];
				$row->{$setMethod}($value);
			}
		}
		return $this;
	}
}