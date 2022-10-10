<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Monev</title>
    <link rel="shortcut icon" href="img/monev.png" type=" image/x-icon">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
</head>

<body class="text-center">


    <main class="form-signin">
        <form action="/login" method="post" autocomplete="off">
            @csrf
            <img class="mb-4" src="img/monev.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <div class="row">
                <div class="col">
                    @include('layout.flashmessage')
                </div>
            </div>
            <label for="nip" class="visually-hidden">NIP</label>
            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror " placeholder="NIP" autofocus>
            <label for="password" class="visually-hidden">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror " placeholder="Password" autofocus>
            <button class="btn btn-lg btn-info btn-block mt-4 mb-4" type="submit">Sign in</button>
        </form>
    </main>



</body>

</html>