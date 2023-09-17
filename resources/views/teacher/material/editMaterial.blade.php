@extends('layout')

@section('content')
    <div class="box">
        <h1>Vnesite podatke o gradivu</h1>
        <div class="col-md-12">
            <x-form
                submitRouteName="material"
                backRouteName="subject_material.list"
                variableName="materialId"
                optionalVariableName="subjectId"
                :optionalId="$subjectId"
                :existingData="$formData"
            >

                <x-input
                    name="material_title"
                    displayedName="Ime gradiva"
                    type="text"
                    value="{{ $formData?->material_title }}"
                ></x-input>

                <x-input
                    name="material_description"
                    displayedName="Opis gradiva"
                    type="text"
                    value="{{ $formData?->material_description }}"
                ></x-input>

                <input type="file" name="file">
                @error('file')
                <div class="alert alert-danger auto-dismiss">{{ $message }}</div>
                @enderror

            </x-form>
        </div>
    </div>
@endsection
