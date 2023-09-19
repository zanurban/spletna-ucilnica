    <div class="header">
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container-fluid containerr">
                {{--                 <a class="navbar-brand" href="#">
              <img src="your-logo.png" alt="Logo" width="50">
            </a> --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @if (Auth::user() && Auth::user()->role == 'adm')
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('teacher.list') }}">Učitelji</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('subject.list') }}">Predmeti</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('student.list') }}">Uporabniki</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Moj Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}">Odjava</a>
                            </li>
                        </ul>
                    </div>
                @elseif(Auth::user() && Auth::user()->role == 'tch')
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('subject_material.list') }}">Predmeti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Moj Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Odjava</a>
                        </li>
                    </ul>
                </div>
                @elseif(Auth::user() && Auth::user()->role == 'usr')
                @else
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            {{-- <li class="nav-item active" style="margin-right: 10px;">
                                <a class="nav-link" href="{{ route('login') }}">Prijava</a>
                            </li> --}}
                        </ul>
                    </div>
                @endif
            </div>
        </nav>
    </div>
