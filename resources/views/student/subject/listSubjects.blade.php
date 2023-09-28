@extends('layout')

@section('content')
    <div class="box">
        <h1>Predmeti, ki jih obiskuješ</h1>

        <ul>
            @if(count($data) > 0)
                @foreach($data as $subject)
                    <li>
                        <a href="{{ route('subjectList.listMaterial', ['subjectId' => $subject->subject_id]) }}">{{ $subject->subject_name }} - {{ $subject->teacher_first_name }} {{ $subject->teacher_last_name }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
@endsection
