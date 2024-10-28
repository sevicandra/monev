<!doctype html>
<html lang="en" data-theme="" class="transition-colors duration-200">

<head>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Monitoring Tagihan DJKN">
    <title>Monev Audit</title>
    <script>
        try {
            document.documentElement.setAttribute("data-theme", localStorage.getItem("dataTheme"))
        } catch (e) {}
    </script>
    <link rel="shortcut icon" href="/img/monev.png" type="image/x-icon">
    @section('head')

    @show
</head>

<body class="bg-base-100 h-screen grid grid-rows-[auto_1fr] grid-cols-1 relative">
    <header class="navbar bg-neutral px-4 flex-none flex justify-between z-20">
        <div class="flex-1 order-2 lg:order-1 flex justify-center lg:justify-start gap-1">
            <a href="/"><img src="/img/monev.png" width="25" height="25" alt="logo"></a>
            <a class="normal-case text-xl text-neutral-content" href="/audit/session/tahun-anggaran">&nbsp;Monev Audit
                {{ session()->get('tahun') }}</a>
        </div>
        <div class="flex-none order-1 lg:order-2">
            <div class="dropdown lg:dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img src="{{ session()->get('gravatar') }}" alt="profile" />
                    </div>
                </label>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow shadow-base-content bg-base-100 rounded-box w-24">
                    <li>
                        <button id="toggleThemeBar">Themes</button>
                    </li>
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="order-3 lg:hidden">
        </div>
    </header>
    <div class="bg-base-100 relative overflow-hidden">
        <main class="grid grid-rows-[1fr_auto] grid-cols-1 h-full pb-6 overflow-hidden w-full gap-2">
            <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden gap-2 max-w-7xl w-full mx-auto px-4 lg:px-0 py-2">
                @yield('content')
            </div>
            <div>
                @section('pagination')

                @show
            </div>
        </main>
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
        $("#toggleSidebar").click(function() {
            if ($("#toggleSidebar").is(":checked")) {
                $("#sidebar").removeClass("-translate-x-full")
            } else {
                $("#sidebar").addClass("-translate-x-full")
            }
        });
    });
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
</script>
<script>
    $(document).ready(function() {
        $("#themeMenu").children("div").click(function() {
            localStorage.setItem('dataTheme', $(this).data("setTheme"));
            $("html").attr('data-theme', $(this).data("setTheme"))
        })
    })
</script>
@section('foot')

@show

</html>
