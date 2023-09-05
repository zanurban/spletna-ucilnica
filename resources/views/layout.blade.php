<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <title>{{$title ?? 'Sola'}}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
        <style>
            /* Adjust the sidebar width and background color as needed */
            .sidebar {
              width: 250px;
              background-color: #f8f9fa;
              height: 100vh;
              position: fixed;
              top: 0;
              left: 0;
              padding-top: 60px;
            }
        
            .sidebar a {
              padding: 10px;
              text-decoration: none;
              color: #333;
              display: block;
            }
        
            .sidebar a:hover {
              background-color: #e9ecef;
            }
          </style>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <div class="container">
                <a class="navbar-brand" href="#">
                  <img src="your-logo.png" alt="Logo" width="50">
                </a>
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
                  </ul>
                </div>
              </div>
            </nav>
          </header>
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