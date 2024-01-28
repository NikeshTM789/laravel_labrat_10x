@csrf

<?php
$user = isset($user) ? $user : null;
?>

<div class="row">
	<x-form.input :label="'username'" :name="'name'" :value="$user" :class="'col-6'" />
	<x-form.input :label="'email'" :value="$user" :class="'col-6'" />
</div>
<x-form.button :class="['float-right','btn-outline-success']"/>