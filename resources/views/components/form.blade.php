<form class="form"
    action="{{ isset($existingData->id)
        ? route(
            $submitRouteName . '.update',
            array_filter([
                $variableName ?? 'default_variable_name' => $existingData->id ?? null,
                $optionalVariableName ?? null => $optionalId ?? null,
            ]),
        )
        : route(
            $submitRouteName . '.create',
            array_filter([
                $optionalVariableName ?? null => $optionalId ?? null,
            ]),
        ) }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($existingData->id))
        @method('PUT')
    @endif

    <div class="form-content">
        {{ $slot }}
    </div>

    <button type="submit" class="btn btn-primary">{{ $submitButtonName ?? 'Shrani' }}</button>
    <a href="{{ isset($optionalVariableName)
        ? route($backRouteName, [$optionalVariableName => $optionalId])
        : route($backRouteName) }}"
        class="btn btn-default" style="margin-left: 10px">Nazaj</a>

</form>
