@extends('layouts.user')
@section('title','aboutus')
@section ('content')
    <!-- Hero Section -->
    <section class="bg-white py-8 sm:py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="text-gray-800 order-2 lg:order-1">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 sm:mb-6">Tentang Cucicar</h1>
                    <p class="text-base sm:text-lg mb-4 sm:mb-6">
                        Cucicar adalah jasa Cuci Mobil di Rumah berlangganan yang menawarkan berbagai layanan cuci mobil Elit dengan harga yang kompetitif untuk kendaraan pribadi.
                    </p>
                    <p class="text-sm sm:text-base mb-3 sm:mb-4">
                        Pengalaman lebih dari 5 tahun yang kami telah melayani, berkomitmen untuk memberikan kepuasan kepada pelanggan, detail mobil, fogging mobil hingga cuci interior mobil Elit. Anda tak perlu repot lagi mencari salon mobil terbaik di Jakarta ataupun poles mobil terbaik.
                    </p>
                    <p class="text-sm sm:text-base">
                        Cucicar memberikan pelayanan cuci mobil berlangganan terbaik agar Anda merasa memiliki mobil car wash professional pribadi di rumah.
                    </p>
                </div>
                <div class="relative flex justify-center lg:justify-end order-1 lg:order-2">
                    <div class="bg-white">
                        <div class="w-48 h-48 sm:w-64 sm:h-64 md:w-80 md:h-80 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/images/ttgcucicar.png') }}" alt="Tentang Cucicar" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Section -->
    <section class="py-8 sm:py-12 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">Sejarah cucicar</h2>
                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex items-start space-x-4 ml-0 sm:ml-12">
                            <p class="text-sm sm:text-base text-gray-700">
                                CuciCar mulai beroperasi sejak September 2018, berawal dari keluhanmk pemilik yang ingin mobilnya selalu bersih tanpa harus repot membawa ke car wash.
                            </p>
                        </div>
                        
                        <div class="ml-0 sm:ml-12 space-y-3 sm:space-y-4 text-sm sm:text-base text-gray-700">
                            <p>Nama CuciCar berasal dari gabungan dua kata:</p>
                            <ul class="list-disc list-inside space-y-2 ml-2 sm:ml-4">
                                <li>Cuci, yang artinya layanan utama berupa pembersihan kendaraan secara menyeluruh</li>
                                <li>Car, berarti mobil, fokus utama dari layanan ini</li>
                            </ul>
                            
                            <p>
                                CuciCar hadir sebagai jasa cuci mobil panggilan dan berlangganan yang fleksibel, praktis, dan berkualitas tinggi. Tidak hanya sekedar mencuci, CuciCar juga menawarkan layanan salon mobil professional langsung di rumah Anda—mulai dari cuci, detailing, hingga poles—semua dilakukan dengan standar kebersihan dan kualitas maksimal.
                            </p>
                            
                            <p>
                                Dengan komitmen pada kualitas, kenyamanan, dan kepercayaan pelanggan, CuciCar siap menjadi solusi perawatan mobil terbaik untuk masyarakat modern.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="rounded-lg p-4 sm:p-8">
                    <div class="w-full h-48 sm:h-56 md:h-64 bg-white rounded-lg flex items-center justify-center overflow-hidden shadow">
                        <img src="{{  asset('storage/images/sejarah.png')}}" alt="Timeline Sejarah Cucicar" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Goals Section -->
    <section class="py-8 sm:py-12 md:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="flex items-center justify-center order-2 lg:order-1">
                    <div class="w-full flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('/storage/images/tujuan.png') }}" alt="Car Service" class="w-full h-auto object-cover rounded-lg">
                    </div>
                </div>
                
                <div class="order-1 lg:order-2">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">Tujuan cucicar</h2>
                    <p class="text-sm sm:text-base text-gray-700 mb-4 sm:mb-6">
                        Tujuan utama Cucicar adalah menyediakan layanan cuci mobil berlangganan yang lebih nyaman kepada pelanggan. Cucicar berfokus pada customer yang aware terhadap kondisi kendaraannya dan ingin mendapatkan perawatan terbaik.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700">
                        Selain menyediakan berbagai layanan cuci mobil di rumah pelanggan, jasa cuci mobil panggilan berlangganan, Cucicar juga ingin berkontribusi secara aktif kepada para orang yang memiliki keahlian di bidang jasa cuci mobil, detailing mobil dan urusan perawatan kendaraan. Dengan begitu mereka bisa fokus melayani kepada mereka yang memiliki keahlian tersebut.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Area Section -->
    <section class="py-8 sm:py-12 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">Wilayah kerja cucicar</h2>
                    <p class="text-sm sm:text-base text-gray-700 mb-4 sm:mb-6">
                        Hingga saat ini, CuciCar telah beroperasi di berbagai wilayah strategis di Bali, seperti Denpasar, Badung, Gianyar, dan sekitarnya. Didukung oleh tim profesional yang terlatih, CuciCar siap melayani jasa cuci mobil panggilan dengan standar kualitas terbaik di seluruh pelanggan di sebuah area layanan tersebut.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 mb-4 sm:mb-6">
                        Untuk menjamin efisiensi waktu, setiap area operasi CuciCar dibedaki dengan Standard Operational Procedure (SOP) yang konsisten dan ketat di semua wilayah kerja.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700">
                        Sebelum beroperasi, para operator menjalani proses seleksi dan pelatihan khusus, sehingga hanya mereka yang memiliki pengalaman dan keahlian di bidang cuci mobil yang dapat bergabung dan melayani kendaraan pelanggan.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 mt-3 sm:mt-4">
                        Dengan demikian, pelanggan dapat menikmati layanan CuciCar dengan standar profesional yang sama di seluruh Bali.
                    </p>
                </div>
                
                <div class="rounded-lg p-4 sm:p-8">
                    <div class="w-full h-48 sm:h-56 md:h-64 bg-white rounded-lg flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('storage/images/lokasioprasional.png') }}" alt="Peta Bali" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comparison Section -->
    <section class="py-8 sm:py-12 md:py-16 bg-teal-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg order-2 lg:order-1">
                    <div class="w-full h-48 sm:h-56 md:h-64 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('storage/images/keunggulan.png') }}" alt="Perbandingan Cuci Mobil" class="w-full h-full object-cover">
                    </div>
                </div>
                
                <div class="order-1 lg:order-2">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">Perbedaan Cucicar dengan Jasa Cuci Mobil Panggilan Lain?</h2>
                    <p class="text-sm sm:text-base text-gray-700 mb-4 sm:mb-6">
                        Perbedaan Cucicar adalah kualitas, kami menjamin bahwa pelayanan yang kami lakukan berdasarkan SOP yang telah ditetapkan, peralatan yang kami gunakan lebih optimal. Kami selalu menggunakan cairan pembersih premium dan produk-produk terbaik seperti Optimum no rinse, Chemical guys, dan lain-lain yang tidak akan menggunakan cairan glosolan atau sampo cuci mobil curah yang berpengaruh pada kualitas hasil cuci mobil yang kami kerjakan.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700">
                        Selain menggunakan cairan pembersih premium, kami mengutamakan layanan cuci mobil berlangganan. Opsi berlangganan ini kami tawarkan untuk mengubah mindset customer dari membayar jasa cuci mobil yang hanya dilakukan sekali ketika mobil benar-benar kotor. Konsep cuci mobil berlangganan ini pun disedakan lewat berbagai paket yang bisa dipilih dan diatur sesuai keinginan customer.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection