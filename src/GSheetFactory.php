<?php
namespace ArbitrageGoogleSheet;

use ArbitrageGoogleSheet\GSheet\GSheetMeta;
use ArbitrageGoogleSheet\GSheet\GSheetScraped;
use ArbitrageGoogleSheet\GSheet\GSheetSource;

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

	public function createSource(NamedGSheet $namedGSheet): GSheetSource
	{
		$meta = $this->createSourceMeta($namedGSheet);
		return new GSheetSource($this->_sheetService, $this->findSheet($meta->getSheetId()), $meta);
	}

	public function createScraped(NamedGSheet $namedGSheet): GSheetScraped
	{
		$meta = $this->createScrapedMeta($namedGSheet);
		return new GSheetScraped($this->_sheetService, $this->findSheet($meta->getSheetId()), $meta);
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

	private function createSourceMeta(NamedGSheet $namedGSheet): GSheetMeta
	{
		$sheetId = $this->getSheetId($namedGSheet);
		$map = [
			'bolComLink' 			=> 'V',
			'bolComUpdatedAt' 		=> 'AL',
			'amazonDeLink' 			=> 'X',
			'amazonDeUpdatedAt' 	=> 'AU',
			'amazonNlLink' 			=> 'Y',
			'amazonNlUpdatedAt' 	=> 'AV',
		];
		return new GSheetMeta(self::SPREADSHEET_ID, $sheetId, 'AW', $map, 1);
	}

	private function createScrapedMeta(NamedGSheet $namedGSheet): GSheetMeta
	{
		$sheetId = $this->getSheetId($namedGSheet);
		$mapBol = [
			'link' 				=> 'V',
			'competitorPrice' 	=> 'AJ',
			'rebelPrice' 		=> 'AK',
			'updatedAt' 	 	=> 'AL',
		];
		$mapAmazonDe = [
			'link' 				=> 'X',
			'price' 			=> 'AM',
			'maxQty' 			=> 'AO',
			'deliveryInDays'	=> 'AQ',
			'hasGiftOption' 	=> 'AS',
			'updatedAt' 		=> 'AU',
		];
		$mapAmazonNl = [
			'link' 				=> 'Y',
			'price' 			=> 'AN',
			'maxQty' 			=> 'AP',
			'deliveryInDays'	=> 'AR',
			'hasGiftOption' 	=> 'AT',
			'updatedAt' 		=> 'AV',
		];
		$map = [
			'ean' => 'W',
			'bolCom' => $mapBol,
			'amazonDe' => $mapAmazonDe,
			'amazonNl' => $mapAmazonNl,
		];
		return new GSheetMeta(self::SPREADSHEET_ID, $sheetId, 'AW', $map, 1);
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