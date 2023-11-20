<!doctype html>
<html lang="en" data-theme="" class="transition-colors duration-200">

<head>
    @vite('resources/css/app.css')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Monitoring Tagihan DJKN">
    <title>Monev</title>
    <script>
        try {
            document.documentElement.setAttribute("data-theme", localStorage.getItem("dataTheme"))
        } catch (e) {}
    </script>
    <link rel="shortcut icon" href="/img/monev.png" type=" image/x-icon">
    <style>
        /* Hide vertical scrollbar
        ::-webkit-scrollbar {
            width: 0;
        } */

        /* Hide horizontal scrollbar */
        ::-webkit-scrollbar-thumb {
            background: transparent;
        }
    </style>
    @section('head')

    @show
</head>

<body class="bg-base-100 h-screen flex flex-col relative">
    <header class="navbar bg-neutral px-4 flex-none flex justify-between z-20">
        <div class="flex-1 order-2 lg:order-1 flex justify-center lg:justify-start gap-1">
            <a href="/"><img src="/img/monev.png" width="25" height="25" alt="logo"></a>
            <a class="normal-case text-xl text-neutral-content" href="/session/tahun-anggaran">&nbsp;MonevTagihan
                {{ session()->get('tahun') }}</a>
        </div>
        <div class="flex-none order-1 lg:order-2">
            <div class="dropdown lg:dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img src="{{ session()->get('gravatar') }}" alt="profile"/>
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
            <label class="swap swap-rotate">
                <!-- this hidden checkbox controls the state -->
                <input id="toggleSidebar" type="checkbox" />
                <!-- hamburger icon -->
                <svg class="swap-off fill-neutral-content" xmlns="http://www.w3.org/2000/svg" width="32"
                    height="32" viewBox="0 0 512 512">
                    <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
                </svg>
                <!-- close icon -->
                <svg class="swap-on fill-neutral-content" xmlns="http://www.w3.org/2000/svg" width="32"
                    height="32" viewBox="0 0 512 512">
                    <polygon
                        points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49" />
                </svg>
            </label>
        </div>
    </header>
    <div class="flex bg-base-100 flex-1 relative overflow-hidden">
        <nav
            class="overflow-y-auto basis-64 z-10 shrink-0 hidden shadow shadow-base-content lg:block bg-base-100 h-full max-h-full flex flex-col justify-between">
            @include('layout.sidebar')
        </nav>
        <main class="flex flex-col grow pb-6 overflow-x-hidden gap-2 justify-between">
            <div class="flex flex-col grow overflow-x-hidden gap-2">
                @yield('content')
            </div>
            <div>
                @section('pagination')

                @show
            </div>
        </main>
        <div id="sidebar"
            class="overflow-y-auto w-64 z-10 shadow shadow-base-content lg:hidden bg-base-100 h-full max-h-full justify-between absolute left-0 -translate-x-full duration-200">
            @include('layout.sidebar')
        </div>
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
{{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#myFlat", {
        dateFormat: "d-m-Y",
    });
</script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> --}}
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
