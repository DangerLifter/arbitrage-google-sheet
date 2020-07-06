<?php
namespace ArbitrageGoogleSheet\GSheet\Row;

interface FactoryInterface
{
	public function create(array $data = null, array $map = []): RowAbstract;
}