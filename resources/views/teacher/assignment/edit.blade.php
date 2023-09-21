@extends('layout')

@section('content')
<div class="box">
    <h1>Vnesite podatke o nalogi</h1>
    <div class="col-md-12">
        <x-form
            submitRouteName="assignment"
            backRouteName="subject_material.list"
            variableName="assignmentId"
            optionalVariableName="subjectId"
            :optionalId="$subjectId"
            :existingData="$formData"
        >

            <x-input
                name="assignment_title"
                displayedName="Ime naloge"
                type="text"
                value="{{ $formData?->assignment_title }}"
            ></x-input>

            <x-input
                name="assignment_description"
                displayedName="Opis naloge"
                type="text"
                value="{{ $formData?->assignment_description }}"
            ></x-input>

            <x-input
                name="completion_date"
                displayedName="Datum oddaje"
                type="datetime-local"
                value="{{ $formData?->completion_date }}"
            ></x-input>

            <input type="file" name="file">
            @error('file')
            <div class="alert alert-danger auto-dismiss">{{ $message }}</div>
            @enderror

        </x-form>
    </div>
</div>
@endsection
