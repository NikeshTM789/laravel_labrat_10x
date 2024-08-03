@csrf

@php
$role = isset($role) ? $role : null;
$selected = isset($role) ? $role->permissions->pluck('id')->all() : null;
@endphp

<div class="row">
	<x-form.input :label="'role name'" :name="'name'" :value="$role" />
</div>
<div class="col">
	<x-form.select2 :label="'permissions'" :name="'permissions[]'" :options="$permissions" :selected="$selected" />
</div>
<x-form.button :class="['float-right','btn-outline-success']"/>