@extends('layout')

@section('content')
    <div class="box">
    <h1>Registracija uporabnika</h1>
    <div class="col-md-12">
        <x-form
            submitRouteName="register"
            backRouteName="home"
            submitButtonName="Registriraj"
            :existingData="$formData"
        >
            <x-input
                name="first_name"
                displayedName="Ime"
                type="text"
            ></x-input>

            <x-input
                name="last_name"
                displayedName="Priimek"
                type="text"
            ></x-input>

            <x-input
                name="username"
                displayedName="Uporabniško ime"
                type="text"
            ></x-input>

            <x-input
                name="email"
                displayedName="E-pošta"
                type="email"
            ></x-input>

            <x-input
                name="password"
                displayedName="Geslo"
                type="password"
            ></x-input>

            <x-input
            name="password2"
            displayedName="Potrdi geslo"
            type="password"
        ></x-input>

        </x-form>
    </div>
    </div>
@endsection
