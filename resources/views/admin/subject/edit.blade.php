@extends('layout')

@section('content')
<div class="box">
    <h1>Vnesite podatke o predmetu</h1>
    <div class="col-md-12">
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
</div>
@endsection
