<?php
namespace ArbitrageGoogleSheet\GSheet\Row;

class Helper
{
	// A, B, C, D, E, F, G, H, I, J, K,  L,  M,  N,  O,  P,  Q,  R,  S,  T,  U,  V,  W,  X,  Y,  Z
	// 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25,
	// A{X} = 25 + 1 + {X}

	public static function columnNameToIndex(string $name): int
	{
		$base = 26;
		$startIndex = ord('A') - 1;
		$chars = array_reverse(str_split($name, 1));
		$index = 0;

		foreach ($chars as $i => $char) {
			$curIndex = ord($char) - $startIndex;
			$index += $base ** $i * $curIndex;
		}

		$index--;

		return $index;
	}

	public static function getRangeForSingleRow(string $sheetTitle, string $clmName, int $rowIndex): string
	{
		return self::getRange($sheetTitle, $clmName, $rowIndex, $clmName, $rowIndex);
	}

	public static function getRange(string $sheetTitle, string $endClmName, int $endRowIndex, string $startClmName = 'A', int $startRowIndex = 1): string
	{
		return "'${sheetTitle}'!${startClmName}${startRowIndex}:${endClmName}${endRowIndex}";
	}
}
