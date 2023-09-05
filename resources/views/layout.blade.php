<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{$title ?? 'Sola'}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
        /* Adjust the sidebar width and background color as needed */
        .sidebar {
            width: 15%;
            background-color: #f8f9fa;
            height: calc(100vh - 60px); /* Calculate the height */
            position: fixed; /* Changed to fixed */
            top: 60px; /* Align below the header */
            left: 0;
            display: flex; /* Flex container */
            flex-direction: column; /* Column layout */
            align-items: stretch; /* Stretch children */
        }


        .sidebar a {
            flex-grow: 1; /* Take up available space */
            padding: 10px;
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center; /* Center content */
            justify-content: center; /* Center content */
            text-transform: uppercase; /* Text in caps lock */
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }
        .header{
            position: relative;
            height: auto;
            z-index: 1;
            width: 100%;
        }
        .navbar-nav{
            width: 100%;
            padding-left: 15%;
            display: grid;
            grid-column-gap: 0px;
            grid-template-columns:auto auto auto auto auto;

        }
        .nav-item:hover{
            background-color: #e9ecef;
            border: 10px solid #e9ecef;
        }
        .nav-item{
            text-align: center;
            border: 10px solid #f8f9fa;
        }
        .navbar{
            padding: 0px;
        }
        .containerr{
            padding: 0px;
            margin: 0px;
        }
        body, html {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
<div class="header">
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-fluid containerr">
            {{--                 <a class="navbar-brand" href="#">
                              <img src="your-logo.png" alt="Logo" width="50">
                            </a> --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bedak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="sidebar">
    <a href="#" class="active">Button 1</a>
    <a href="#">Button 2</a>
    <a href="#">Button 3</a>
    <a href="#">Button 4</a>
    <a href="#">Button 5</a>
</div>
@yield('partials.navBar')
<div class="">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
