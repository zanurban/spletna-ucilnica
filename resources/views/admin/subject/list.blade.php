@extends('layout')

@section('content')
    <h1>Obstoječi predmeti</h1>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="col-md-12">
        <table>

            <thead>
            <tr>
                <th>Ime predmeta</th>
                <th>Opis predmeta</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @if(count($data) > 0)
                @foreach($data as $row)
                    <tr>
                        <td>{{ $row->subject_name }}</td>
                        <td>{{ $row->subject_description }}</td>
                        <td>
                            <form action="{{ route('subject.delete', ['subjectId' => $row?->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <a href="{{ route('subject.update', ['subjectId' => $row?->id]) }}"
                                   class="btn btn-primary btn-sm">Uredi</a>
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Ali ste preričani, da želite izbrisati ta element?');">
                                    Izbriši
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection