@extends('layout')

@section('content')
    <div class="box">
        <h1>Vnesite podatke o predmetu</h1>
        <div class="col-md-12">
            <x-form submitRouteName="teacher" backRouteName="teacher.list" variableName="teacherId" :existingData="$formData"
                >

                <x-input name="first_name" displayedName="Ime učitelja" type="text"
                    value="{{ $formData?->first_name }}"></x-input>

                <x-input name="last_name" displayedName="Priimek učitelja" type="text"
                    value="{{ $formData?->last_name }}"></x-input>
                <x-input name="email" displayedName="E-pošta učitelja" type="email"
                    value="{{ $formData?->email }}"></x-input>
                <x-input name="username" displayedName="Uporabniško ime učitelja" type="text"
                value="{{ $formData?->username }}" readonly></x-input>
                <div class="form-group">
                    <label for="role">Vloga</label>
                    <select class="form-control" name="role" id="role">
                        <option value="adm" {{ $formData?->role == 'adm' ? 'selected' : '' }}>Admin</option>
                        <option value="tch" {{ $formData?->role == 'tch' ? 'selected' : '' }}>Teacher</option>
                        <option value="usr" {{ $formData?->role == 'usr' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                    
                    Seznam predmetov, ki jih poučuje učitelj
                    @foreach ($existingDataSubject as $subject)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->id }}"
    {{ in_array($subject->id, old('subjects', $currentSubjects)) ? 'checked' : '' }}>

                            <label class="form-check-label">{{ $subject->subject_name }}</label>
                        </div>
                    @endforeach

            </x-form>
        </div>
    </div>
@endsection
