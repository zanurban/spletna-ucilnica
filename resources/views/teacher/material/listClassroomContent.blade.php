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

                @if(count($materials) > 0)
                    @foreach($materials as $row)
                        <tr>
                            <td><a href="{{ Storage::url($row->material_file_path) }}">{{ $row->material_title }}</a>
                            </td>
                            <td>{{ $row->material_description }}</td>
                            <td>
                                <form
                                    action="{{ route('material.delete', ['subjectId' => $subjectId, 'materialId' => $row?->id]) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('material.update', ['subjectId' => $subjectId, 'materialId' => $row?->id]) }}"
                                           class="btn btn-primary btn-sm add">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                            Uredi</a>
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Ali ste preričani, da želite izbrisati ta material?');">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"></path>
                                            </svg>
                                            Izbriši
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
            <a href="{{ route('material.create', ['subjectId' => $subjectId]) }}"
               class="btn btn-primary btn-sm add">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="16" height="16" fill="currentColor" class="bi bi-pencil-square"
                     viewBox="0 0 16 16">
                    <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd"
                          d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
                Dodaj gradivo</a>
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

                @if(count($assignments) > 0)
                    @foreach($assignments as $row)
                        <tr>
                            <td>{{ $row->assignment_title }}</td>
                            <td>{{ $row->assignment_description }}</td>
                            <td>{{ $row->completion_date }}</td>
                            <td>@if($row->material_file_path !== '')
                                    <a href="{{ Storage::url($row->material_file_path) }}">{{ $row->assignment_title }}</a>
                                @endif
                            </td>
                            <td>
                                <form
                                    action="{{ route('assignment.delete', ['subjectId' => $subjectId, 'assignmentId' => $row?->id]) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('assignment.update', ['subjectId' => $subjectId, 'assignmentId' => $row?->id]) }}"
                                           class="btn btn-primary btn-sm add">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                            Uredi</a>
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Ali ste preričani, da želite izbrisati to nalogo?');">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"></path>
                                            </svg>
                                            Izbriši
                                        </button>
                                        <a href="{{ route('assignment.downloadAll', ['subjectId' => $subjectId, 'assignmentId' => $row?->id]) }}"
                                            class="btn btn-primary btn-sm add">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                  fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                 <path
                                                     d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                 <path fill-rule="evenodd"
                                                       d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                             </svg>
                                             Naloži datoteke</a>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
            <a href="{{ route('assignment.create', ['subjectId' => $subjectId]) }}"
               class="btn btn-primary btn-sm add">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="16" height="16" fill="currentColor" class="bi bi-pencil-square"
                     viewBox="0 0 16 16">
                    <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd"
                          d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
                Dodaj nalogo</a>
        </div>
        <a href="{{ route('subject_material.list') }}" class="btn btn-outline-secondary btn-sm">Nazaj</a>
        @if (session('message'))
            <div class="alert alert-success auto-dismiss">
                {{ session('message') }}
            </div>
        @endif
    </div>
@endsection
