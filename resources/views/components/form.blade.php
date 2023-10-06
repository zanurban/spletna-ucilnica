<form class="form"
    action="{{ isset($existingData->id)
        ? (isset($optionalVariableName)
            ? route($submitRouteName . '.update', [
                $variableName => $existingData->id,
                $optionalVariableName => $optionalId,
            ])
            : route($submitRouteName . '.update', [$variableName => $existingData->id]))
        : (isset($optionalVariableName)
            ? route($submitRouteName . '.create', [$optionalVariableName => $optionalId])
            : route($submitRouteName . '.create')) }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($existingData->id))
        @method('PUT')
    @endif

    <div class="form-content">
        {{ $slot }}
    </div>

    <button type="submit" class="btn btn-primary">{{ $submitButtonName ?? 'Shrani' }}</button>
    <a href="{{ 
        isset($optionalVariableName) 
        ? route($backRouteName, [$optionalVariableName => $optionalId]) 
        : route($backRouteName) 
    }}" class="btn btn-default" style="margin-left: 10px">Nazaj</a>
    
</form>
