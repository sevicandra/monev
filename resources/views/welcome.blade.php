<!doctype html>
<html lang="en" data-theme="" class="transition-colors duration-200">

<head>
    @vite('resources/css/app.css')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Monev</title>
    <script>
        try {
            document.documentElement.setAttribute("data-theme", localStorage.getItem("dataTheme"))
        } catch (e) {}
    </script>
    <link rel="shortcut icon" href="/img/monev.png" type=" image/x-icon">
</head>

<body class="bg-base-100 h-screen flex flex-col relative overflow-hidden relative">
    <main class="absolute inset-0 flex justify-center items-center">
        <div class="w-full max-w-xl text-center flex flex-col gap-4 items-center">
            <h1 class="text-3xl font-bold text-base-content">Hai!, Selamat Datang di Monev Tagihan.</h1>
            <p class="text-md text-base-content">Dengan alat bantu monev perbendaharaan, kami hadirkan kemudahan dalam
                mengakses informasi pelaksanaan anggaran di layar Anda.</p>
            @include('layout.flashmessage')
            <a class="btn btn-outline btn-base-content max-w-xs" href="/sso">Login Menggunakan Kemenkeu ID</a>
        </div>
    </main>
    <div class="absolute z-10 top-4 right-4">
        <button id="toggleThemeBar">
            <!-- hamburger icon -->
            <svg class="swap-off fill-base-content" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                viewBox="0 0 512 512">
                <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
            </svg>
        </button>
        </label>
    </div>
    <div class="absolute inset-0 z-50 hidden" id="themebar">
        <div class="absolute inset-0" id="themebarDialog">

        </div>
        <div id="themeSidebar"
            class="overflow-y-auto w-64 z-10 shadow shadow-base-content bg-base-100 h-full max-h-full justify-between absolute right-0 translate-x-full duration-200">
            @include('layout.theme')
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $("#toggleThemeBar").click(function() {
            $("#themebar").toggleClass("hidden").delay(200);
            setTimeout(function() {
                $('#themeSidebar').toggleClass('translate-x-full');
            }, 200)
        })
    })
    $(document).ready(function() {
        $("#themebarDialog").click(function() {
            $('#themeSidebar').toggleClass('translate-x-full');
            setTimeout(function() {
                $("#themebar").toggleClass("hidden");
            }, 200)
        })
    })
    $(document).ready(function() {
        $("#themeMenu").children("div").click(function() {
            localStorage.setItem('dataTheme', $(this).data("setTheme"));
            $("html").attr('data-theme', $(this).data("setTheme"))
        })
    })
</script>

</html>
