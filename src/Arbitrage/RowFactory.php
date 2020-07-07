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
			foreach ($map as $name => $column) {
				if (is_array($column)) {
					$method = 'get'.ucfirst($name);
					$this->fill($row->$method(), $data, $column ?? []);
					unset($map[$name]);
				}
			}
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