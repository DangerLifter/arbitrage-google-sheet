<?php
namespace ArbitrageGoogleSheet;

use ArbitrageGoogleSheet\Arbitrage\RowFactory;
use ArbitrageGoogleSheet\Arbitrage\GSheet;
use ArbitrageGoogleSheet\GSheet\Meta;

class GSheetFactory
{
	private const SPREADSHEET_ID = '1DaZE6giy3d1eZCm2k-kj4CcflmeKPjEnYp7VFEmKxXw';

	private \Google_Service_Sheets $_sheetService;

	/** @var \Google_Service_Sheets_Sheet[] */
	private array $_sheets;

	public function __construct(\Google_Client $client)
	{
		$this->_sheetService = new \Google_Service_Sheets($client);
	}

	public function createArbitrage(NamedGSheet $namedGSheet): GSheet
	{
		$meta = $this->createMeta($namedGSheet);
		return new GSheet($this->_sheetService, $this->findSheet($meta->getSheetId()), $meta, new RowFactory());
	}

	private function getSheetId(NamedGSheet $namedGSheet): int
	{
		switch ($namedGSheet->getName()) {
			case NamedGSheet::NEW_TOP_SELLING: 	return 946036192;
			case NamedGSheet::LISTED: 			return 2001628456;
			case NamedGSheet::MONITORING: 		return 728531664;
			case NamedGSheet::POTENTIAL: 		return 752781793;
		}
		throw new \InvalidArgumentException('Unknown named google sheet');
	}

	private function createMeta(NamedGSheet $namedGSheet): Meta
	{
		$sheetId = $this->getSheetId($namedGSheet);
		$mapBol = [
			'link' 				=> 'V',
			'competitorPrice' 	=> ['AJ', fn($v) => $this->priceToFloat($v) ],
			'rebelPrice' 		=> ['AK', fn($v) => $this->priceToFloat($v) ],
			'updatedAt' 	 	=> ['AL', fn($v) => $this->toDate($v) ],
		];
		$mapAmazonDe = [
			'link' 				=> 'X',
			'price' 			=> ['AM', fn($v) => $this->priceToFloat($v) ],
			'maxQty' 			=> ['AO', fn($v) => $this->toInt($v) ],
			'deliveryInDays'	=> 'AQ',
			'hasGiftOption' 	=> 'AS',
			'updatedAt' 		=> ['AU', fn($v) => $this->toDate($v) ],
		];
		$mapAmazonNl = [
			'link' 				=> 'Y',
			'price' 			=> ['AN', fn($v) => $this->priceToFloat($v) ],
			'maxQty' 			=> ['AP', fn($v) => $this->toInt($v) ],
			'deliveryInDays'	=> 'AR',
			'hasGiftOption' 	=> 'AT',
			'updatedAt' 		=> ['AV', fn($v) => $this->toDate($v) ],
		];
		$mapAmazonDataDe = [
			'highestPrice7DaysInclVAT' 		=> ['G', fn($v) => $this->priceToFloat($v) ],
		];
		$mapAmazonDataNl = [
			'highestPrice7DaysInclVAT' 		=> ['I', fn($v) => $this->priceToFloat($v) ],
		];
		$map = [
			'ean' => 'W',
			'bolCom' => $mapBol,
			'amazonDe' => $mapAmazonDe,
			'amazonNl' => $mapAmazonNl,
			'amazonDataDe' => $mapAmazonDataDe,
			'amazonDataNl' => $mapAmazonDataNl,
		];
		return new Meta(self::SPREADSHEET_ID, $sheetId, 'AW', $map, 1);
	}

	private function priceToFloat(string $v): ?float
	{
		return $v ? (float)ltrim($v, "€$") : null;
	}

	private function toFloat(string $v): ?float
	{
		return '' !== $v ? (float) $v : null;
	}

	private function toInt(string $v): ?float
	{
		return '' !== $v ? (int) $v : null;
	}

	private function toDate(string $v): ?\DateTime
	{
		return '' !== $v ? \DateTime::createFromFormat('d-m-Y H:i', $v) : null;
	}

	private function findSheet(int $sheetId): \Google_Service_Sheets_Sheet
	{
		/** @var \Google_Service_Sheets_Sheet $sheet */
		foreach ($this->getAllSheets() as $sheet) {
			if ($sheet->getProperties()->getSheetId() === $sheetId) {
				return $sheet;
			}
		}
		throw new \RuntimeException('Google sheet with id "'.$sheetId.'" not found');
	}

	private function getAllSheets(): array
	{
		if (!isset($this->_sheets)) {
			$this->_sheets = $this->_sheetService->spreadsheets->get(self::SPREADSHEET_ID)->getSheets();
		}
		return $this->_sheets;
	}
}