<div class="form-group">
    <label for="{{ $name }}">{{ $displayedName }}</label>
    <input type="{{ $type }}"
           class="form-control {{ isset($errorMessaage) ? 'is-invalid' : '' }}"
           name="{{ $name }}"
           value="{{ old($name, $value) }}">

    @error($name)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
