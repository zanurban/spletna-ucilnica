@extends('layout')

@section('content')
    <h1>Vnesite podatke o predmetu</h1>
    <div class="col-md-12" style="margin-left: 500px">
        <x-form
            submitRouteName="subject"
            backRouteName="subject.list"
            variableName="subjectId"
            :existingData="$formData"
        >

            <x-input
                name="subject_name"
                displayedName="Ime predmeta"
                type="text"
                value="{{ $formData?->subject_name }}"
            ></x-input>

            <x-input
                name="subject_description"
                displayedName="Opis predmeta"
                type="text"
                value="{{ $formData?->subject_description }}"
            ></x-input>

        </x-form>
    </div>
@endsection
