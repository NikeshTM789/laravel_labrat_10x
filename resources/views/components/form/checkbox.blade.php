<div class="custom-control custom-checkbox">
    <input class="custom-control-input" id="customCheckbox1" type="checkbox" name="{{ $name }}" value="{{ $value }}" @checked($checked) />
        <label class="custom-control-label" for="customCheckbox1">
            {{ $label }}
        </label>
    </input>
</div>