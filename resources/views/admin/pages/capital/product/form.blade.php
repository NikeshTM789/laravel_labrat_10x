@csrf

<?php
$product = isset($product) ? $product : null;
$selected = $product ? $product->categories->pluck('id')->all() : null;
?>

<div class="row">
	<x-form.input :label="'product name'" :name="'name'" :value="$product" :class="'col'"/>
</div>
<div class="row">
	<x-form.input :label="'quantity'" :value="$product" :class="'col-4'" />
	<x-form.input :label="'price'" :value="$product" :class="'col-4'" />
	<x-form.input :label="'discount'" :value="$product" :class="'col-4'" />
</div>
<div class="col">
	<x-form.select2 :label="'category'" :name="'category[]'" :options="$categories" :selected="$selected" />
</div>
<div class="col">
	<x-form.editor :label="'details'" :name="'details'" :value="$product"/>
</div>
<x-form.checkbox :label="'featured'" :name="'featured'" :checked="($product) ? $product->featured:false" />
<x-form.button :class="['float-right','btn-outline-success']"/>

