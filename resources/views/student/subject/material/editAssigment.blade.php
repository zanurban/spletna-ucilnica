@extends('layout')

@section('content')
    <div class="box">
        <h1>Vnesite podatke o gradivu</h1>
        <div class="col-md-12">
            <x-form
                submitRouteName="subject"
                backRouteName="subject.listMaterial"
                variableName="materialId"
                optionalVariableName="subjectId"
                :optionalId="$subjectId"
                :existingData="$formData"
            >
            
                <x-inputRead
                    name="assigment_title"
                    displayedName="Ime naloge"
                    type="text"
                    value="{{ $formData?->assignment_title }}"
                ></x-inputRead>
                <x-inputRead
                    name="assigment_decription"
                    displayedName="Opis naloge"
                    type="text"
                    value="{{ $formData?->assignment_description }}"
                ></x-inputRead>
                <x-inputRead
                name="assigment_decription"
                displayedName="Rok oddaje naloge"
                type="text"
                value="{{ $formData?->completion_date }}"
                ></x-inputRead>
                <x-input
                    name="assigment_description"
                    displayedName="Opis naloge"
                    type="text"
                    value="{{ $formData?->assigment_description }}"
                ></x-input>

                <input type="file" name="file">
                @error('file')
                <div class="alert alert-danger auto-dismiss">{{ $message }}</div>
                @enderror
            </x-form>
        </div>
    </div>
@endsection
