<?php
namespace ArbitrageGoogleSheet;

use ArbitrageGoogleSheet\Arbitrage\RowFactory;
use ArbitrageGoogleSheet\Arbitrage\GSheet;
use ArbitrageGoogleSheet\GSheet\Meta;

class GSheetFactory
{
	protected const SPREADSHEET_ID = '1DaZE6giy3d1eZCm2k-kj4CcflmeKPjEnYp7VFEmKxXw';

	protected \Google_Service_Sheets $_sheetService;

	/** @var \Google_Service_Sheets_Sheet[] */
	private array $_sheets;

	public function __construct(\Google_Service_Sheets $sheetService)
	{
		$this->_sheetService = $sheetService;
	}

	public function createSheet(Meta $meta): GSheet
	{
		return new GSheet($this->_sheetService, $this->findSheet($meta->getSheetId()), $meta, new RowFactory());
	}

	public function createArbitrageMeta(string $sheetId): Meta
	{
		$mapBol = [
			'link' 				=> 'W',
			'competitorPrice' 	=> ['AK', fn($v) => $this->priceToFloat($v) ],
			'rebelPrice' 		=> ['AL', fn($v) => $this->priceToFloat($v) ],
			'updatedAt' 	 	=> ['AM', fn($v) => $this->toDate($v) ],
		];
		$mapAmazonDe = [
			'link' 				=> 'Y',
			'price' 			=> ['AN', fn($v) => $this->priceToFloat($v) ],
			'maxQty' 			=> ['AP', fn($v) => $this->toInt($v) ],
			'deliveryInDays'	=> ['AR', fn($v) => $this->toInt($v) ],
			'hasGiftOption' 	=> 'AT',
			'updatedAt' 		=> ['AV', fn($v) => $this->toDate($v) ],
		];
		$mapAmazonNl = [
			'link' 				=> 'Z',
			'price' 			=> ['AO', fn($v) => $this->priceToFloat($v) ],
			'maxQty' 			=> ['AQ', fn($v) => $this->toInt($v) ],
			'deliveryInDays'	=> ['AS', fn($v) => $this->toInt($v) ],
			'hasGiftOption' 	=> 'AU',
			'updatedAt' 		=> ['AW', fn($v) => $this->toDate($v) ],
		];
		$mapAmazonDataDe = [
			'highestPrice7DaysInclVAT' 		=> ['G', fn($v) => $this->priceToFloat($v) ],
		];
		$mapAmazonDataNl = [
			'highestPrice7DaysInclVAT' 		=> ['I', fn($v) => $this->priceToFloat($v) ],
		];
		$mapBolReprice = [
			'newPrice' 			=> ['AX', fn($v) => $this->priceToFloat($v) ],
			'updatedAt' 		=> ['AY', fn($v) => $this->toDate($v) ],
			'isApplyNewPrice' 	=> ['BA', fn($v) => $this->toBoolean($v) ],
		];
		$map = [
			'ean' => 'X',
			'bolCom' => $mapBol,
			'amazonDe' => $mapAmazonDe,
			'amazonNl' => $mapAmazonNl,
			'amazonDataDe' => $mapAmazonDataDe,
			'amazonDataNl' => $mapAmazonDataNl,
		];

		$map['bolComRepriceData'] = $mapBolReprice;
		$map['message'] = 'AZ';
		$maxColumnName = 'BB';

		return new Meta(self::SPREADSHEET_ID, $sheetId, $maxColumnName, $map, 1);
	}

	private function priceToFloat(string $v): ?float
	{
		return $v ? (float)ltrim($v, "€$") : null;
	}

	private function toFloat(string $v): ?float
	{
		return '' !== $v ? (float) $v : null;
	}

	private function toBoolean(string $v): ?float
	{
		if ('' === $v) return false;
		$v = strtolower($v);
		return in_array($v, ['on', 'yes', 'true']);
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