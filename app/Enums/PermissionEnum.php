<?php

namespace App\Enums;

enum PermissionEnum: String {
	case USER_LIST = 'user_list';
	case USER_EDIT = 'user_edit';
	case USER_ADD = 'user_add';
	case USER_DELETE = 'user_delete';
	case PRODUCT_LIST = 'product_list';
	case PRODUCT_EDIT = 'product_edit';
	case PRODUCT_ADD = 'product_add';
	case PRODUCT_DELETE = 'product_delete';
	case CATEORY_LIST = 'cateory_list';
	case CATEORY_EDIT = 'cateory_edit';
	case CATEORY_ADD = 'cateory_add';
	case CATEORY_DELETE = 'cateory_delete';
	case APP_SETUP = 'setup';
	case Privilege = 'privilege';

	public static function values()
	{
		return array_map(fn($item) => $item->value, self::cases());
	}
}

?>