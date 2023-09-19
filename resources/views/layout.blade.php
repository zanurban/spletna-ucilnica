<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.auto-dismiss');

            alerts.forEach(alert => {
                setTimeout(function() {
                    alert.style.opacity = "0";
                    setTimeout(function() {
                        alert.remove();
                    }, 500); // This waits for the fade out to complete before removing the element
                }, 3000); // This will hide the alert after 3 seconds
            });
        });
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Sola' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
        /* Adjust the sidebar width and background color as needed */
        .sidebar {
            width: 100%;
            background-color: #f8f9fa;
            height: 100%;
            display: flex;
            /* Flex container */
            flex-direction: column;
            /* Column layout */
            align-items: stretch;
            justify-content: center;
            /* Stretch children */
            padding-top: auto;
            padding-bottom: auto;
        }
        #navbarNav{
            height:60px;
        }

        .sidebar a {

            /* Take up available space */
            padding: 10px;
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            /* Center content */
            justify-content: center;
            /* Center content */
            text-transform: uppercase;
            /* Text in caps lock */
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }

        .header {
            position: relative;
            height: auto;
            z-index: 1;
            width: 100%;
        }

        .navbar-nav {
            width: 100%;
            padding-left: 15%;
            display: grid;
            grid-column-gap: 0px;
            grid-template-columns: auto auto auto auto auto;

        }

        .nav-item:hover {
            background-color: #e9ecef;
            border: 10px solid #e9ecef;
        }

        .nav-item {
            text-align: center;
            border: 10px solid #f8f9fa;
        }

        .navbar {
            padding: 0px;
        }

        .containerr {
            padding: 0px;
            margin: 0px;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .content {
            display: flex;
            width: 100%;
            height: 100%;
            overflow: hidden;
            padding: 10px;
        }

        .main {
            height: calc(100vh - 60px);
            width: 100%;
            display: grid;
            grid-template-columns: 15% 85%;
        }

        .frame {
            height: calc(100vh - 60px);
            width: 100%;
            display: flex;
            justify-content: center;
            background-color: aqua;
            padding: 7% 25%;
        }

        .loginForm {
            background-color: green;
            border: 15px solid black;
            border-radius: 25px;
            display: grid;
            grid-template-columns: 50% 50%;
        }

        .form {
            width: 80%;
            padding: 20px;
            border: 3px solid #d6d8da;
            border-radius: 20px;
            background-color: #f0f0f5;
        }

        .form-content {
            width: 100%;
            margin-bottom: 20px;
        }

        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }

        .form-group label {
            margin-bottom: 5px;
        }

        .btn-primary {
            background-color: transparent;
            color: #2b2c2c;
            border-color: rgb(71, 68, 68);
        }

        .btn-primary:hover {
            background-color: none;
            border-color: none;
        }

        .form-control:focus {
            border-color: rgb(31, 30, 30);
            box-shadow: 0 0 0 0.25rem rgba(31, 30, 30, .25)
        }

        .box {
            width: 100%;
            height: 100%;
            padding: 20px;
            overflow: scroll;
            overflow-x: hidden;
        }

        h1 {
            margin-bottom: 20px;
        }

        .table {
            border: 3px solid #d6d8da;
            border-radius: 20px;
            background-color: #f0f0f5;
        }

        .table table tr {
            background-color: #e9ecef;
        }

        .table table tr td {
            padding-left: 7px;
        }

        .table table tr:nth-child(even) {
            background-color: #ccced1;
        }

        .table table tr:hover {
            background-color: #c2c9c9;
            color: #2b2c2c;
        }

        .table table th {
            background-color: #3e3e3e;
            color: antiquewhite;
        }

        .table table {
            width: 100%;
            margin-bottom: 20px;
        }

        .table {
            padding: 20px;
        }

        .auto-dismiss {
            transition: opacity 0.3s;
            margin-top: 10px;
        }

        .btn-outline-danger,
        .add {
            display: flex;
            margin-left: 3px;
            justify-content: center;
            align-items: center;
        }

        .btn-outline-danger svg,
        .add svg {
            margin-right: 3px;
        }

        .add:hover svg {
            fill: white;
        
        }
    </style>
</head>

<body>
    @include('partials.header')
    <div class="main">
        @include('partials.navBar')
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
