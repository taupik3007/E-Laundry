<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-800 font-poppins">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">BrandKu</h1>
            <a href="#contact" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Contact
            </a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="h-screen pt-24 flex items-center">
        <div class="w-5/6:% mx-auto px-6 w-full grid md:grid-cols-2">

            <div class="m-auto p-20 ">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6 text-center md:text-left">
                    Laundry
                    <span class="text-blue-600 block">& Dry Clean</span>
                </h1>
                <p class="font-inter text-gray-600 mb-10">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos incidunt atque excepturi at
                    omnis, unde, nulla, accusamus dolor est maxime laudantium laboriosam nobis harum sit! Quam quisquam
                    earum commodi.
                </p>
                <a href="" class="bg-[#4C9FFF] p-2 rounded-full text-white px-7">Pesan Sekarang <i class="ti ti-arrow-big-right-line-filled"></i> </a>
            </div>

            <div class="hidden md:flex justify-center items-center relative">
                <img src="{{ asset('landing-img/welcome-illus.svg') }}"
                    class="w-4/5 drop-shadow-xl relative z-20 -mt-10" alt="">
                <div class="absolute right-0 top-0 w-full opacity-40 z-0">
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
    <section id="services" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-10">Layanan Kami</h2>
            <div class="grid md:grid-cols-3 gap-10">

                <div class="bg-gray-100 p-8 rounded-2xl shadow-md">
                    <h3 class="text-xl font-semibold mb-3">Website</h3>
                    <p class="text-gray-600">Landing page, company profile, dan toko online.</p>
                </div>

                <div class="bg-gray-100 p-8 rounded-2xl shadow-md">
                    <h3 class="text-xl font-semibold mb-3">Branding</h3>
                    <p class="text-gray-600">Logo, identitas visual, dan kemasan produk.</p>
                </div>

                <div class="bg-gray-100 p-8 rounded-2xl shadow-md">
                    <h3 class="text-xl font-semibold mb-3">Social Media</h3>
                    <p class="text-gray-600">Konten kreatif untuk Instagram & TikTok.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-6">
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

</body>

</html>
