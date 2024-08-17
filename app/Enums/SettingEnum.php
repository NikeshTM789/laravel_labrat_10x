<?php

namespace App\Enums;

enum SettingEnum: String {
	case APP = 'app_name';
	case LOGO = 'logo';

	public static function values()
	{
		return array_map(fn($item) => $item->value, self::cases());
	}
}

?>