@extends('layout')

@section('content')
    <div class="box">
        <h1>Vnesite podatke o gradivu</h1>
        <div class="col-md-12">
            <x-form
                submitRouteName="assignment_student"
                backRouteName="subjectList.listMaterial"
                variableName="assignmentId"
                optionalVariableName="subjectTeacherId"
                :optionalId="$subjectTeacherId"
                :existingData="$formData"
            >
                <x-input
                    name="assigment_title"
                    displayedName="Ime naloge"
                    type="text"
                    value="{{ $formData?->assignment_title }}"
                    readonly="true"
                ></x-input>

                <x-input
                    name="assigment_decription"
                    displayedName="Opis naloge"
                    type="text"
                    value="{{ $formData?->assignment_description }}"
                    readonly="true"
                ></x-input>

                <x-input
                    name="assignment_description"
                    displayedName="Rok oddaje naloge"
                    type="text"
                    value="{{ $formData?->completion_date }}"
                    readonly="true"
                ></x-input>

                <x-input
                    name="assignment_student_comment"
                    displayedName="Komentar pri oddaji naloge"
                    type="text"
                    value="{{ $formData?->assignment_student_comment }}"
                ></x-input>

                <input type="file" name="file">
                @error('file')
                <div class="alert alert-danger auto-dismiss">{{ $message }}</div>
                @enderror
                @if (session('error'))
                <div class="alert alert-danger auto-dismiss">
                    {{ session('error') }}
                </div>
            @endif
            </x-form>
        </div>
    </div>
@endsection
