<!DOCTYPE html>
<html lang="en">

<head>
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
        .content{
            display: flex;
            width: 100%;
            height: 100%;
            overflow: hidden;
            padding: 10px;
        }
        .main{
            height: calc(100vh - 60px);
            width: 100%;
            display: grid;
            grid-template-columns: 15% 85%;
        }
        .frame{
            height: calc(100vh - 60px);
            width: 100%;
            display: flex;
            justify-content: center;
            background-color: aqua;
            padding: 7% 25%;
        }
        .loginForm{
            background-color: green;
            border: 15px solid black;
            border-radius: 25px;
            display: grid;
            grid-template-columns: 50% 50%;
        }
        .form{
            width: 100%;
            padding: 20px;
            display: flex;
            align-items: center;
        }
        .box{
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 20px;
        }
        .box-center{
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .box input{
            margin-left: 30px;
        }
        .box-center input{
            margin-left: 30px;
        }
    </style>
</head>

<body>
    @include("partials.header")
     <div class="main">
      @include('partials.navBar')
      <div class="content">
          @yield('content')
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
