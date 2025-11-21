<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Landing Page</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@300;400;600&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    {{-- <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css')}}"> --}}

    @vite('resources/css/app.css')

    <style>
        /* global reset for layout consistency */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        /* big page gradient that flows from top to bottom */
        body {
            background: linear-gradient(to bottom,
                    #ebebeb 0%,
                    #f5fbff 40%,
                    #e2f4ff 70%,
                    #cfeaff 100%);
            /* background: black; */
            background-attachment: fixed;
            /* keeps gradient fixed so it "blends" across sections */
        }

        /* make sure the scroll container accounts for fixed navbar height when snapping */
        .snap-container {
            height: 100vh;
            overflow-y: auto;
            scroll-snap-type: y mandatory;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
            /* match this value with navbar height (here ~64px) */
            scroll-padding-top: 4rem;
        }

        .snap-section {
            height: 100vh;
            scroll-snap-align: start;
            background: transparent;
            /* important so body gradient shows through */
        }

        /* optional: hide default scroll bar on some browsers (nice look) */
        .snap-container::-webkit-scrollbar {
            width: 8px;
        }

        .snap-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.12);
            border-radius: 9999px;
        }

        /* DOT INDICATOR */
        .dots {
            position: fixed;
            right: 35px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 14px;
            z-index: 999;
        }

        .dots span {
            width: 12px;
            height: 12px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 50%;
            cursor: pointer;
            transition: 0.25s;
        }

        .dots span.active {
            background: #4C9FFF;
            transform: scale(1.35);
        }

        .snap-container::-webkit-scrollbar {
            display: none;
        }

        /* Hilangkan scrollbar (Firefox) */
        .snap-container {
            scrollbar-width: none;
        }

        /* Hilangkan scrollbar (IE & legacy Edge) */
        .snap-container {
            -ms-overflow-style: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

</head>

<body class="text-gray-800 font-poppins">

    <!-- NAVBAR (fixed) -->
    <nav class="bg-[#ebebeb] shadow-lg fixed w-full z-50 top-0 left-0">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">BrandKu</h1>
            <a href="#contact" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Contact
            </a>
        </div>
    </nav>
    <a href="https://wa.me/628xxxxxxxxxx" target="_blank"
        class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full shadow-xl flex items-center justify-center text-3xl z-50 animate-bounce">
        <i class="ti ti-brand-whatsapp"></i>
    </a>

    <!-- SCROLL CONTAINER (this is the element that scrolls & snaps) -->
    <div class="snap-container">

        <!-- HERO -->
        <section class="snap-section flex items-center">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 items-center w-full">

                <!-- Text -->
                <div class="p-6 md:p-20">
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 text-center md:text-left leading-tight">
                        Laundry
                        <span class="text-[#4C9FFF] block">& Dry Clean</span>
                    </h1>

                    <p class="font-inter text-gray-600 mb-10 text-center md:text-left max-w-xl">
                        Layanan laundry cepat, bersih, dan wangi untuk orang sibuk sepertimu.
                        Kami pakai produk terbaik dan antar-jemput yang nyaman.
                    </p>

                    <div class="text-center md:text-left">
                        <a href="#services"
                            class="bg-[#4C9FFF] py-2 px-7 rounded-full text-white inline-flex items-center gap-2 hover:bg-blue-500 transition">
                            Pesan Sekarang
                            <i class="ti ti-arrow-big-right-line-filled"></i>
                        </a>
                    </div>
                </div>

                <!-- Image + Blob -->
                <div class="hidden md:flex justify-center items-center relative">
                    <img src="{{ asset('landing-img/welcome-illus.svg') }}"
                        class="w-4/5 drop-shadow-xl relative z-20 -mt-10" alt="Hero Illustration">

                    <!-- smooth SVG blob behind image -->
                    <div class="absolute inset-0 opacity-40 z-0 scale-110 pointer-events-none">
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#4C9FFF"
                                d="M35.7,-52.1C48.7,-54.3,63.3,-49.6,69.8,-39.8C76.3,-30,74.7,-15,73.7,-0.6C72.7,13.8,72.2,27.6,62.6,32.1C53,36.6,34.3,31.9,22.4,34.1C10.4,36.3,5.2,45.4,-2.6,49.9C-10.4,54.3,-20.7,54.1,-32,51.5C-43.3,48.9,-55.5,44,-65.4,35C-75.4,26.1,-83,13,-83.7,-0.4C-84.4,-13.8,-78.1,-27.6,-69.7,-39.3C-61.4,-51,-51,-60.7,-39,-59.1C-27,-57.5,-13.5,-44.7,-1.1,-42.8C11.4,-41,22.7,-50,35.7,-52.1Z"
                                transform="translate(100 100)" />
                        </svg>
                    </div>
                </div>

            </div>
        </section>

        <!-- SERVICES -->
        <section id="services" class="snap-section flex items-center">
            <div class="max-w-6xl mx-auto px-6 w-full py-12">
                <h2 class="text-3xl font-bold mb-10 text-center text-[#4C9FFF]"> <span class="">Layanan
                    </span>Kami</h2>

                <div class="w-full bg-white rounded-lg shadow-xl flex items-center justify-center px-6">
                    <div class="owl-carousel w-full pt-4 ">

                        <!-- ITEM TEMPLATE -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-[430px] my-2">
                            <div class="h-56 w-full">
                                <img src="https://imgv2-2-f.scribdassets.com/img/document/741626810/original/73b7412868/1?v=1"
                                    class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Cuci Kering</h3>
                                <p class="text-gray-600 text-sm">Layanan cepat dan wangi.</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-[430px] my-2">
                            <div class="h-56 w-full">
                                <img src="https://imgv2-2-f.scribdassets.com/img/document/741626810/original/73b7412868/1?v=1"
                                    class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Cuci Kering</h3>
                                <p class="text-gray-600 text-sm">Layanan cepat dan wangi.</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-[430px] my-2">
                            <div class="h-56 w-full">
                                <img src="https://imgv2-2-f.scribdassets.com/img/document/741626810/original/73b7412868/1?v=1"
                                    class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Cuci Kering</h3>
                                <p class="text-gray-600 text-sm">Layanan cepat dan wangi.</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-[430px] my-2">
                            <div class="h-56 w-full">
                                <img src="https://imgv2-2-f.scribdassets.com/img/document/741626810/original/73b7412868/1?v=1"
                                    class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Cuci Kering</h3>
                                <p class="text-gray-600 text-sm">Layanan cepat dan wangi.</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-[430px] my-2">
                            <div class="h-56 w-full">
                                <img src="https://imgv2-2-f.scribdassets.com/img/document/741626810/original/73b7412868/1?v=1"
                                    class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Cuci Kering</h3>
                                <p class="text-gray-600 text-sm">Layanan cepat dan wangi.</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-[430px] my-2">
                            <div class="h-56 w-full">
                                <img src="https://imgv2-2-f.scribdassets.com/img/document/741626810/original/73b7412868/1?v=1"
                                    class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Cuci Kering</h3>
                                <p class="text-gray-600 text-sm">Layanan cepat dan wangi.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="snap-section flex items-center">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 items-center w-full">

                <!-- Text -->
                <div class="p-6 md:p-20">
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 text-center md:text-left leading-tight">
                        Cari
                        <span class="text-blue-600 block">Pesanan</span>
                    </h1>


                    <div class="w-full max-w-xl mx-auto mb-4">
                        <div class="flex items-stretch border border-gray-300 rounded-full overflow-hidden">

                            <input type="text"
                                class="flex-1 px-4 py-2 font-inter outline-none focus:outline-none focus:ring-0"
                                placeholder="Masukan ID Pesanan" />


                            <a href="#services"
                                class="bg-[#4C9FFF] px-6 flex items-center justify-center text-white hover:bg-blue-500 transition">
                                <i class="ti ti-search text-lg"></i>
                            </a>

                        </div>
                    </div>


                </div>

                <!-- Image + Blob -->
                <div class="hidden md:flex justify-center items-center relative">
                    <img src="{{ asset('landing-img/find-order.png') }}"
                        class="w-4/5 drop-shadow-xl relative z-20 -mt-10" alt="Hero Illustration">

                    <!-- smooth SVG blob behind image -->
                    <div class="absolute inset-0 opacity-40 z-0 scale-110 pointer-events-none">
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#4C9FFF"
                                d="M35.7,-52.1C48.7,-54.3,63.3,-49.6,69.8,-39.8C76.3,-30,74.7,-15,73.7,-0.6C72.7,13.8,72.2,27.6,62.6,32.1C53,36.6,34.3,31.9,22.4,34.1C10.4,36.3,5.2,45.4,-2.6,49.9C-10.4,54.3,-20.7,54.1,-32,51.5C-43.3,48.9,-55.5,44,-65.4,35C-75.4,26.1,-83,13,-83.7,-0.4C-84.4,-13.8,-78.1,-27.6,-69.7,-39.3C-61.4,-51,-51,-60.7,-39,-59.1C-27,-57.5,-13.5,-44.7,-1.1,-42.8C11.4,-41,22.7,-50,35.7,-52.1Z"
                                transform="translate(100 100)" />
                        </svg>
                    </div>
                </div>

            </div>
        </section>




        <!-- CONTACT -->
        <section id="contact" class="snap-section flex items-center">
            <div class="max-w-3xl mx-auto px-6 py-12 w-full">
                <h2 class="text-3xl font-bold mb-4 text-center">Hubungi Kami</h2>

                <form class="bg-white p-8 rounded-2xl shadow-lg">
                    <input type="text" placeholder="Nama" class="w-full mb-4 p-3 border rounded-lg">
                    <input type="email" placeholder="Email" class="w-full mb-4 p-3 border rounded-lg">
                    <textarea placeholder="Pesan" rows="4" class="w-full mb-4 p-3 border rounded-lg"></textarea>

                    <button class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Kirim
                    </button>
                </form>
            </div>
        </section>
       <section class="snap-section min-h-screen flex items-center bg-gray-100 pt-28 md:pt-0">

            <footer class="w-full">
                <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">

                    <!-- Kolom 1 -->
                    <div class="space-y-3">
                        <img src="{{ asset('landing-img/logo-fix.png') }}" alt="E-Laundry Garut Logo" class="w-72">

                        <h3 class="font-semibold text-xl">E-Laundry Garut</h3>

                        <p class="text-gray-600 text-sm leading-relaxed max-w-sm">
                            Laundry cepat, bersih, dan wangi.
                            Melayani Garut dan sekitarnya dengan sepenuh hati.
                        </p>

                        <div class="flex items-center gap-3 mt-4">

                            <!-- Instagram -->
                            <a href="https://instagram.com/" target="_blank"
                                class="w-10 h-10 rounded-full bg-[#4C9FFF]/10 flex items-center justify-center text-[#4C9FFF] hover:bg-[#4C9FFF] hover:text-white transition">
                                <i class="ti ti-brand-instagram text-xl"></i>
                            </a>

                            <!-- TikTok -->
                            <a href="https://tiktok.com/" target="_blank"
                                class="w-10 h-10 rounded-full bg-[#4C9FFF]/10 flex items-center justify-center text-[#4C9FFF] hover:bg-[#4C9FFF] hover:text-white transition">
                                <i class="ti ti-brand-tiktok text-xl"></i>
                            </a>

                            <!-- Facebook -->
                            <a href="https://facebook.com/" target="_blank"
                                class="w-10 h-10 rounded-full bg-[#4C9FFF]/10 flex items-center justify-center text-[#4C9FFF] hover:bg-[#4C9FFF] hover:text-white transition">
                                <i class="ti ti-brand-facebook text-xl"></i>
                            </a>

                        </div>

                    </div>

                    <!-- Kolom 2 -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4">Layanan</h3>

                        <ul class="space-y-2 text-gray-700 text-sm">

                            <li>
                                <a href="#" class="flex items-center gap-2 group">
                                    <span
                                        class="w-2 h-2 rounded-full bg-[#4C9FFF] opacity-50 group-hover:opacity-100 transition"></span>
                                    <span class="group-hover:text-[#4C9FFF] transition">Cuci Kering</span>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="flex items-center gap-2 group">
                                    <span
                                        class="w-2 h-2 rounded-full bg-[#4C9FFF] opacity-50 group-hover:opacity-100 transition"></span>
                                    <span class="group-hover:text-[#4C9FFF] transition">Cuci Lipat</span>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="flex items-center gap-2 group">
                                    <span
                                        class="w-2 h-2 rounded-full bg-[#4C9FFF] opacity-50 group-hover:opacity-100 transition"></span>
                                    <span class="group-hover:text-[#4C9FFF] transition">Dry Clean</span>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="flex items-center gap-2 group">
                                    <span
                                        class="w-2 h-2 rounded-full bg-[#4C9FFF] opacity-50 group-hover:opacity-100 transition"></span>
                                    <span class="group-hover:text-[#4C9FFF] transition">Cuci Sepatu</span>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="flex items-center gap-2 group">
                                    <span
                                        class="w-2 h-2 rounded-full bg-[#4C9FFF] opacity-50 group-hover:opacity-100 transition"></span>
                                    <span class="group-hover:text-[#4C9FFF] transition">Cuci Karpet</span>
                                </a>
                            </li>

                        </ul>
                    </div>



                    <!-- Kolom 3 (Kontak + Map) -->
                    <div>
                        <h3 class="font-semibold text-lg mb-3">Kontak</h3>
                        <ul class="space-y-2 text-gray-600 mb-4">
                            <li class="flex items-center gap-3">
                                <i class="ti ti-map-pin text-xl text-[#4C9FFF]"></i>
                                Garut, Jawa Barat
                            </li>

                            <li class="flex items-center gap-3">
                                <i class="ti ti-phone text-xl text-[#4C9FFF]"></i>
                                0812-3456-7890
                            </li>

                            <li class="flex items-center gap-3">
                                <i class="ti ti-mail text-xl text-[#4C9FFF]"></i>
                                support@elaundry.id
                            </li>
                        </ul>

                        <!-- MAP -->
                        <div class="rounded-lg overflow-hidden shadow-md w-full h-40 md:h-48">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1979.171569943113!2d107.882595!3d-7.201635!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68b13e691cc551%3A0x8c33c3b24cb1565c!2sGarut%20Laundry!5e0!3m2!1sen!2sus!4v1763739056604!5m2!1sen!2sus"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>

                        </div>
                    </div>

                </div>

                <!-- Copyright -->
                <div class="bg-[#4C9FFF] py-4 text-center text-sm text-white">
                    © 2025 E-Laundry Garut | Manage by : Gutax Gitex program
                </div>
            </footer>
        </section>



        {{-- <section id="footer" class="snap-section w-full flex"  >
            <div class="w-1/3">
                <img src="{{asset('landing-img/logo-fix.png')}}" alt="">
            </div>
        </section> --}}

    </div> <!-- /snap-container -->
    <!-- DOT NAVIGATION -->
    <div class="dots">
        <span data-index="0" class="active"></span>
        <span data-index="1"></span>
        <span data-index="2"></span>
        <span data-index="3"></span>
        <span data-index="4"></span>

    </div>









    <!-- Optional: small script to help arrow keys / wheel snap behavior on some browsers -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>

    <script>
        const container = document.querySelector('.snap-container');
        const sections = [...document.querySelectorAll('.snap-section')];

        let isScrolling = false;

        function getClosestSection(scrollTop) {
            let closest = sections[0];
            let closestDiff = Math.abs(sections[0].offsetTop - scrollTop);

            sections.forEach(sec => {
                const diff = Math.abs(sec.offsetTop - scrollTop);
                if (diff < closestDiff) {
                    closest = sec;
                    closestDiff = diff;
                }
            });

            return closest;
        }

        container.addEventListener('wheel', (e) => {
            e.preventDefault();
            if (isScrolling) return;

            isScrolling = true;

            const direction = e.deltaY > 0 ? 1 : -1;
            const current = getClosestSection(container.scrollTop);
            let nextIndex = sections.indexOf(current) + direction;

            nextIndex = Math.max(0, Math.min(nextIndex, sections.length - 1));

            gsap.to(container, {
                duration: 1.0,
                scrollTo: {
                    y: sections[nextIndex].offsetTop
                },
                ease: "power3.out",
                onComplete: () => isScrolling = false
            });
        }, {
            passive: false
        });
    </script>
    <script>
        // DOT SYSTEM
        const dots = document.querySelectorAll('.dots span');

        // update active dot
        function updateDots(index) {
            dots.forEach(d => d.classList.remove('active'));
            dots[index].classList.add('active');
        }

        // update ketika scroll snapped
        container.addEventListener('scroll', () => {
            let index = Math.round(container.scrollTop / window.innerHeight);
            updateDots(index);
        });

        // klik dot = pindah section
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const i = Number(dot.dataset.index);
                gsap.to(container, {
                    duration: 1,
                    scrollTo: {
                        y: sections[i].offsetTop
                    },
                    ease: "power3.out"
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                dots: true,
                center: true,
                smartSpeed: 600,
                autoplay: false,

                responsive: {
                    0: {
                        items: 1
                    },
                    640: {
                        items: 2
                    },
                    1024: {
                        items: 3
                    }
                }
            });
        });
    </script>


</body>

</html>
