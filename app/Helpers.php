<?php

use App\Models\User;

if (!function_exists('isUser')) {
	function isUser(){
        return auth()->user()->hasRole(User::USER);
	}
}

if (!function_exists('isSeller')) {
	function isSeller(){
	    return auth()->user()->hasAnyRole(User::SELLER);
	}
}

if (!function_exists('isAdmin')) {
	function isAdmin(){
	    return auth()->user()->hasAnyRole(User::ADMIN, User::SUPREME);
	}
}



?>