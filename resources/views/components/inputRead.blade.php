<div class="form-group">
    <label for="{{ $name }}">{{ $displayedName }}</label>
    <input type="{{ $type }}"
           class="form-control {{ isset($errorMessaage) ? 'is-invalid' : '' }}"
           name="{{ $name }}"
           value="{{ old($name, $value) }}"
           readonly>
    @error($name)
        <div class="alert alert-danger auto-dismiss">{{ $message }}</div>
    @enderror
</div>
