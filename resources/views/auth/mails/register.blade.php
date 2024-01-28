@inject('user','App\Models\User')

Welcome {{ ucwords($name) }}! you can verify this email by visiting this <a href="{{ $url }}" title="">link</a>
@if($role == $user::ADMIN)
 with password <em><u>{{ $password }}</u></em>
@endif