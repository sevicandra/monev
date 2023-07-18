
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Monev</title>
    <link rel="shortcut icon" href="/img/monev.png" type=" image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        #message {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
}
#inner-message {
    margin: 0 auto;
}
    </style>
    @section('head')
        
    @show
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-info flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="/session/tahun-anggaran" style="font-size: 20px;"><img src="/img/monev.png" width="25" height="25"> &nbsp;MonevTagihan {{ session()->get('tahun') }}</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-none d-md-block bg-light h-100 max-h-100">
                @include('layout.sidebar')
            </nav>
            @yield('content')
            <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                @include('layout.sidebar')    
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#myFlat", {
        dateFormat: "d-m-Y",
    });
</script>
@section('foot')
        
@show
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>