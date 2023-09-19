@extends('layout')

@section('content')
    <div class="box">
        <h1>Vnesite podatke o učencu</h1>
        <div class="col-md-12">
            <x-form
                submitRouteName="student"
                backRouteName="student.list"
                variableName="studentId"
                :existingData="$formData"
            >

                <x-input
                    name="first_name"
                    displayedName="Ime učenca"
                    type="text"
                    value="{{ $formData?->first_name }}"
                ></x-input>

                <x-input
                    name="last_name"
                    displayedName="Priimek učenca"
                    type="text"
                    value="{{ $formData?->last_name }}"
                ></x-input>

                <x-input
                    name="email"
                    displayedName="E-pošta učenca"
                    type="email"
                    value="{{ $formData?->email }}"
                ></x-input>

                <x-input
                    name="username"
                    displayedName="Uporabniško ime učenca"
                    type="text"
                    value="{{ $formData?->username }}"
                ></x-input>

                <div class="form-group">
                    <label for="role">Vloga</label>
                    <select class="form-control" name="role" id="role">
                        <option value="adm" {{ $formData?->role == 'adm' ? 'selected' : '' }}>Admin</option>
                        <option value="tch" {{ $formData?->role == 'tch' ? 'selected' : '' }}>Teacher</option>
                        <option value="usr" {{ $formData?->role == 'usr' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                Seznam predmetov, ki jih obiskuje učenec
                @foreach ($existingDataSubjectTeacher as $subjectTeacher)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subjectTeacher->id }}"
                        {{ in_array($subjectTeacher->id, old('subjects', $currentSubjectTeacherIds)) ? 'checked' : '' }}>

                    <label class="form-check-label">
                        {{ $subjectTeacher->subject->subject_name }} - {{ $subjectTeacher->teacher->first_name }} {{ $subjectTeacher->teacher->last_name }}
                    </label>
                </div>
            @endforeach
            </x-form>
        </div>
    </div>
@endsection
