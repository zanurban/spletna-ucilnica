<form
    action="{{ isset($existingData->id) ? route($submitRouteName . '.update', [$variableName => $existingData->id]) : route($submitRouteName . '.create') }}"
    method="POST">
    @csrf
    @if(isset($existingData->id))
        @method('PUT')
    @endif

    <div class="form-content">
        {{ $slot }}
    </div>

    <button type="submit" class="btn btn-primary">{{ $submitButtonName }}</button>
    <a href="{{ route($backRouteName) }}" class="btn btn-default" style="margin-left: 10px">Nazaj</a>
</form>
