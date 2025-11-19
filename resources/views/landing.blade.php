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
                    #ffffff 0%,
                    #f5fbff 40%,
                    #e2f4ff 70%,
                    #cfeaff 100%);
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
    <nav class="bg-white shadow-lg fixed w-full z-50 top-0 left-0">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">BrandKu</h1>
            <a href="#contact" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Contact
            </a>
        </div>
    </nav>

    <!-- SCROLL CONTAINER (this is the element that scrolls & snaps) -->
    <div class="snap-container">

        <!-- HERO -->
        <section class="snap-section flex items-center">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 items-center w-full">

                <!-- Text -->
                <div class="p-6 md:p-20">
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 text-center md:text-left leading-tight">
                        Laundry
                        <span class="text-blue-600 block">& Dry Clean</span>
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
                <h2 class="text-3xl font-bold mb-10 text-center">Layanan Kami</h2>

                <div class="w-full h-[520px] bg-white rounded-r-md shadow-xl flex items-center justify-center px-6">
                    <div class="owl-carousel w-full">

                        <!-- ITEM TEMPLATE -->
                        <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col h-[420px]">
                            <div class="h-56 w-full">
                                <img src="/landing-img/cuci-kering.jpg" class="w-full h-full object-cover"
                                    alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Cuci Kering</h3>
                                <p class="text-gray-600 text-sm">Layanan cepat dan wangi.</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col h-[430px]">
                            <div class="h-56 w-full">
                                <img src="/landing-img/cuci-lipat.jpg" class="w-full h-full object-cover"
                                    alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Cuci Lipat</h3>
                                <p class="text-gray-600 text-sm">Hasil rapi siap pakai.</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col h-[430px]">
                            <div class="h-56 w-full">
                                <img src="/landing-img/dry-clean.jpg" class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Dry Clean</h3>
                                <p class="text-gray-600 text-sm">Aman untuk bahan sensitif.</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col h-[430px]">
                            <div class="h-56 w-full">
                                <img src="/landing-img/sepatu.jpg" class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Sepatu</h3>
                                <p class="text-gray-600 text-sm">Cuci sepatu premium.</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col h-[430px]">
                            <div class="h-56 w-full">
                                <img src="/landing-img/karpet.jpg" class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-start">
                                <h3 class="font-semibold text-xl mb-2">Karpet</h3>
                                <p class="text-gray-600 text-sm">Karpet bersih total.</p>
                            </div>
                        </div>

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

    </div> <!-- /snap-container -->
    <!-- DOT NAVIGATION -->
    <div class="dots">
        <span data-index="0" class="active"></span>
        <span data-index="1"></span>
        <span data-index="2"></span>
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
