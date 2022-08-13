
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Monev</title>
    <link rel="shortcut icon" href="/img/monev.png" type=" image/x-icon">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @section('head')
        
    @show
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-info flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="" style="font-size: 20px;"><img src="/img/monev.png" width="25" height="25"> &nbsp;MonevTagihan {{ session()->get('tahun') }}</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            @include('layout.sidebar')
            @yield('content')
        </div>
    </div>

    <script src="/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#myFlat", {
        dateFormat: "d-m-Y",
    });
</script>
@section('foot')
        
@show

</body>

</html>