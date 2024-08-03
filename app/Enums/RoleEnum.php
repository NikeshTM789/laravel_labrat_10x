<?php

namespace App\Enums;

enum RoleEnum:String{
  case ADMIN = 'admin';
  case SELLER = 'seller';
  case CLIENT = 'client';
}

?>