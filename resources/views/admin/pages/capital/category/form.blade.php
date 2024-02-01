@csrf

@php
$category = isset($category) ? $category : null;
@endphp

<div class="row">
	<x-form.input :label="'category'" :name="'name'" :value="$category" :class="'col-6 offset-3'" />
</div>
<x-form.button :type="'button'" :class="['float-right','btn-outline-success']"/>