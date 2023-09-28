@extends('layout')

@section('content')
    <div class="box">
        <h1>Prijava v uporabniški profil</h1>
        <div class="col-md-12">
            <x-form
                submitRouteName="login"
                backRouteName="login"
                submitButtonName="Prijavi se"
                :existingData="$formData"
            >

                <x-input
                    name="username"
                    displayedName="Uporabniško ime"
                    type="text"
                ></x-input>

                <x-input
                    name="password"
                    displayedName="Geslo"
                    type="password"
                ></x-input>

            </x-form>
        </div>
    </div>
@endsection
