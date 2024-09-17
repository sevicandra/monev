<!doctype html>
<html lang="en" data-theme="" class="transition-colors duration-200">

<head>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Monitoring Tagihan DJKN">
    <title>Monev</title>
    <script>
        try {
            document.documentElement.setAttribute("data-theme", localStorage.getItem("dataTheme"))
        } catch (e) {}
    </script>
    <link rel="shortcut icon" href="/img/monev.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="/js/trix.umd.min.js"></script>
    <script type="module">
        import {
            Application,
            Controller
        } from 'https://cdn.skypack.dev/@hotwired/stimulus'
        import Tribute from 'https://ga.jspm.io/npm:tributejs@5.1.3/dist/tribute.min.js'
        import Trix from 'https://ga.jspm.io/npm:trix@2.1.0/dist/trix.esm.min.js'
        [...document.querySelectorAll('[js-cloak]')].forEach(el => el.removeAttribute('js-cloak'))
        window.Stimulus = Application.start()
        class UploadManager {
            #attachments = []

            addAttachment(attachment) {
                this.#attachments.push(attachment)
            }

            removeAttachment(attachment) {
                this.#attachments = this.#attachments.filter(a => a !== attachment)
            }

            removeAttachments() {
                this.#attachments = []
            }

            uploadAttachments() {
                const promises = this.#attachments.map(attachment => this.#uploadAttachment(attachment))
                return Promise.all(promises)
            }

            #uploadAttachment(attachment) {
                const form = new FormData()
                form.append('attachment', attachment.file)

                const options = {
                    method: 'POST',
                    body: form,
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                    }
                }

                return fetch('/note-attachments', options)
                    .then(resp => {
                        if (!resp.ok) {
                            throw new Error(`Upload failed: ${resp.statusText}`)
                        }
                        return resp.json()
                    })
                    .then((data) => {
                        attachment.setAttributes({
                            url: data.image_url,
                            href: data.image_url,
                        })
                    })
                    .catch(error => {
                        console.error("Error during upload:", error) // Error logging
                    })
            }
        }
        Stimulus.register("rich-text-uploader", class extends Controller {
            static values = {
                acceptFiles: Boolean
            }

            #uploader

            connect() {
                this.#uploader = new UploadManager()
                const submitButton = document.getElementById('trix-submit-btn');
                const closeButton = document.getElementById('trix-close-btn');
                submitButton.addEventListener('click', () => this.handleSubmit(event));
                closeButton.addEventListener('click', () => this.removeAttachments());
            }

            addAttachment(event) {
                if (!this.acceptFilesValue || !event.attachment.file) return
                this.#uploader.addAttachment(event.attachment)
            }

            removeAttachment(event) {
                this.#uploader.removeAttachment(event.attachment)
            }

            removeAttachments() {
                this.#uploader.removeAttachments()
            }

            handleKeyboardSubmit(event) {

                if (event.key === "Enter" && (event.metaKey || event.ctrlKey)) {
                    event.preventDefault()
                    this.#uploader.uploadAttachments().then(() => {
                        if (this.element.textContent.trim().length > 0) {
                            this.element.closest("form")
                                .requestSubmit()
                        }else{
                            alert("Teks tidak boleh kosong")
                        }
                    }).catch(error => {
                        console.error('Error during file upload:', error)
                    })
                }
            }
            handleSubmit() {                                
                this.#uploader.uploadAttachments().then(() => {
                    if (this.element.textContent.trim().length > 0) {
                        this.element.closest("form")
                            .requestSubmit()
                    }else{
                        alert("Teks tidak boleh kosong")
                    }
                }).catch(error => {
                    console.error('Error during file upload:', error)
                })
            }


        })
        // Stimulus.register("composer", class extends Controller {
        //     #submitByKeyboardEnabled = true

        //     static values = {
        //         showToolbar: {
        //             type: Boolean,
        //             default: false
        //         },
        //     }

        //     static targets = ["text"]

        //     rejectFiles(event) {
        //         event.preventDefault()
        //     }

        //     disableSubmitByKeyboard() {
        //         this.#submitByKeyboardEnabled = false
        //     }

        //     enableSubmitByKeyboard() {
        //         this.#submitByKeyboardEnabled = true
        //     }

        //     toggleToolbar() {
        //         this.showToolbarValue = !this.showToolbarValue

        //         this.textTarget.focus()
        //     }

        //     submitByKeyboard(event) {
        //         if (!this.#submitByKeyboardEnabled) return;

        //         const metaEnter = event.key === "Enter" && (event.metaKey || event.ctrlKey)
        //         const plainEnter = event.keyCode == 13 && !event.shiftKey && !event.isComposing

        //         if (!this.#usingTouchDevice && (metaEnter || (plainEnter && !this.#isToolbarVisible))) {
        //             this.#submit(event)
        //         }
        //     }

        //     #submit(event) {
        //         event.preventDefault()

        //         if (this.textTarget.textContent.trim().length > 0) {
        //             this.element.closest("form").requestSubmit();
        //         }
        //     }

        //     get #isToolbarVisible() {
        //         return this.showToolbarValue
        //     }

        //     get #usingTouchDevice() {
        //         return "ontouchstart" in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints >
        //             0;
        //     }
        // })
    </script>

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
