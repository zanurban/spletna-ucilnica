@extends('layout')

@section('content')
    <div class="box">
        <h1>Obstoječi učenci</h1>

        <div class="col-md-12 table">
            <table>
                <tr>
                    <th>Ime učenca</th>
                    <th>Priimek učenca</th>
                    <th>E-mail učenca</th>
                    <th>Predmeti učenca</th>
                    <th></th>
                </tr>

                @if (count($data) > 0)
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row['first_name'] }}</td>
                            <td>{{ $row['last_name'] }}</td>
                            <td>{{ $row['email'] }}</td>
                            <td>{{ implode(', ', $row['subjects']) }}</td>
                            <td>
                                <form action="{{ route('student.delete', ['studentId' => $row['id']]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('student.update', ['studentId' => $row['id']]) }}"
                                           class="btn btn-primary btn-sm add">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 width="16" height="16" fill="currentColor" class="bi bi-pencil-square"
                                                 viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                            Uredi</a>
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Ali ste preričani, da želite izbrisati učenca?');">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1H13.494a.58.58 0 0 0-.01 0H11ZM4.115 15 3.31 4.5H12.69l-.805 10.5H4.115Zm5.384-9H6.5v1h2.999v-1ZM6.5 7h2.999v1H6.5V7ZM6.5 9h2.999v1H6.5V9Z"/>
                                            </svg>
                                            Izbriši
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No Data Found</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection
