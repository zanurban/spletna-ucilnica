@extends('layout')

@section('content')
    <div class="box">
        <h1>Podatki profila</h1>
        <div class="col-md-12">
            <x-form
                submitRouteName="profile"
                backRouteName="subjectList.list"
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
            </x-form>
            @if (session('message'))
            <div class="alert alert-success auto-dismiss">
                {{ session('message') }}
            </div>
        @endif
        </div>
    </div>
@endsection
