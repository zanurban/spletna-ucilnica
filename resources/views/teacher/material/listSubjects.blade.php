@extends('layout')

@section('content')
    <div class="box">
        <h1>Predmeti, ki jih poučujete</h1>

        <ul>
        @foreach($subjects as $subject)
                <li><a href="{{ route('material.list', ['subjectId' => $subject->id]) }}">{{ $subject->subject_name }}</a></li>
        @endforeach
        </ul>
    </div>
@endsection
