@extends('layout')

@section('content')
    <div class="box">
        <h1>Predmeti, ki jih poučujete</h1>

        <ul>
            @if(count($subjects) > 0)
                @foreach($subjects as $subject)
                    <li>
                        <a href="{{ route('classroom.list', ['subjectId' => $subject->id]) }}">{{ $subject->subject_name }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
@endsection
