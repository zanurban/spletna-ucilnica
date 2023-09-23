@extends('layout')

@section('content')
    <div class="box">
        <h1>Spletna učilnica {{ strtolower($title) }}</h1>

        <h2>Gradiva</h2>
        <div class="col-md-12 table">
            <table>
                <tr>
                    <th>Datoteka gradiva</th>
                    <th>Opis gradiva</th>
                    <th></th>
                </tr>

                @if (count($materials) > 0)
                    @foreach ($materials as $row)
                        <tr>
                            <td><a href="{{ Storage::url($row->material_file_path) }}">{{ $row->material_title }}</a>
                            </td>
                            <td>{{ $row->material_description }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>

        <h2>Naloge</h2>
        <div class="col-md-12 table">
            <table>
                <tr>
                    <th>Ime naloge</th>
                    <th>Opis naloge</th>
                    <th>Rok oddaje naloge</th>
                    <th>Gradivo naloge</th>
                    <th></th>
                </tr>

                @if (count($assignments) > 0)
                    @foreach ($assignments as $row)
                        <tr>
                            <td>{{ $row?->assignment_title }}</td>
                            <td>{{ $row?->assignment_description }}</td>
                            <td>{{ $row?->completion_date }}</td>
                            <td>
                                @if ($row?->material_file_path !== '')
                                    <a href="{{ Storage::url($row?->material_file_path) }}">{{ $row?->assignment_title }}</a>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('assignment.show', ['subjectId' => $subjectId, 'assignmentId' => $row?->id]) }}"
                                       class="btn btn-primary btn-sm add">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                        Oddaj nalogo</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>

        @if (session('message'))
            <div class="alert alert-success auto-dismiss">
                {{ session('message') }}
            </div>
        @endif
    </div>
@endsection
