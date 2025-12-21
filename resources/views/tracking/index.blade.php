<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tracking Pesanan</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom,
                #ebebeb 0%,
                #f5fbff 40%,
                #e2f4ff 100%);
        }
    </style>
</head>

<body class="min-h-screen text-gray-800">

    <!-- NAVBAR -->
    <nav class="fixed top-0 left-0 w-full bg-white/70 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="ti ti-wash text-blue-500 text-2xl"></i>
                <span class="font-bold text-xl text-blue-600">E-Laundry</span>
            </div>

            <a href="/"
                class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                ← Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="pt-32 px-4 flex justify-center">
        <div
            class="w-full max-w-xl bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-8">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">
                    Tracking Pesanan
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Masukkan ID pesanan kamu untuk melihat status
                </p>
            </div>

            <!-- FORM -->
            <form action="{{ route('tracking') }}" method="GET">
                <div
                    class="flex items-stretch border border-gray-300 rounded-full overflow-hidden focus-within:ring-2 focus-within:ring-blue-400 transition">

                    <span
                        class="px-4 flex items-center bg-gray-100 text-gray-600 text-sm select-none">
                        INV-
                    </span>

                    <input
                        type="number"
                        name="invoice"
                        value="{{ request('invoice') }}"
                        class="flex-1 px-4 py-3 outline-none bg-transparent"
                        placeholder="Contoh: 10234"
                        required>

                    <button
                        type="submit"
                        class="bg-blue-500 px-6 flex items-center justify-center text-white hover:bg-blue-600 transition">
                        <i class="ti ti-search text-lg"></i>
                    </button>
                </div>
            </form>

            <!-- ERROR -->
            @isset($error)
                <div class="mt-5 text-center text-sm text-red-500">
                    {{ $error }}
                </div>
            @endisset

            <!-- RESULT -->
            @isset($order)
                <div class="mt-8 border-t pt-6 space-y-4 text-sm">

                    <div class="flex justify-between">
                        <span class="text-gray-500">Invoice</span>
                        <span class="font-medium">{{ $order->ord_invoice }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Customer</span>
                        <span class="font-medium">{{ $order->ord_customer_name }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal</span>
                        <span class="font-medium">
                            {{ $order->ord_created_at?->format('d M Y') ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Status</span>

                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1
                            @if($order->ord_status === 'selesai')
                                bg-green-100 text-green-700
                            @elseif($order->ord_status === 'dibatalkan')
                                bg-red-100 text-red-700
                            @else
                                bg-yellow-100 text-yellow-700
                            @endif
                        ">
                            <i class="ti ti-circle-filled text-[8px]"></i>
                            {{ ucfirst($order->ord_status) }}
                        </span>
                    </div>
                    <!-- ORDER ITEMS -->
<div class="mt-8">
    <h3 class="text-base font-semibold text-gray-700 mb-3">
        Daftar Paket Pesanan
    </h3>

    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Paket</th>
                    <th class="px-4 py-3 text-right font-medium">Harga</th>
                    <th class="px-4 py-3 text-center font-medium">Qty</th>
                    <th class="px-4 py-3 text-right font-medium">Subtotal</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($order->details as $detail)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            {{ $detail->package->ldp_name }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            Rp {{ number_format($detail->package->ldp_price, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $detail->odt_quantity }}
                        </td>

                        <td class="px-4 py-3 text-right font-medium">
                            Rp {{ number_format(
                                $detail->odt_quantity * $detail->package->ldp_price,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <!-- TOTAL -->
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-semibold">
                        Total
                    </td>
                    <td class="px-4 py-3 text-right font-bold text-blue-600">
                        Rp {{ number_format($order->ord_total, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

                </div>
            @endisset

        </div>
    </div>

</body>
</html>
