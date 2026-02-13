<template>
    <div class="font-sans text-slate-600 antialiased">
        <!-- Hero Section -->
        <section class="relative bg-white overflow-hidden pt-16 pb-20 lg:pt-32 lg:pb-28">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#80ffdb] to-[#0ea5e9] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                    <div class="lg:col-span-12 text-center lg:text-left mb-12 lg:mb-0 max-w-4xl mx-auto">
                         <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold tracking-wide uppercase mb-6 border border-emerald-100 mx-auto lg:mx-0">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Official Partner Procurement
                        </div>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-slate-900 mb-6 leading-tight">
                            Solusi Pengadaan Peralatan <br class="hidden lg:block"/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Program Makan Bergizi</span>
                        </h1>
                        <p class="text-lg sm:text-xl text-slate-600 mb-10 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            Kami menyediakan peralatan pendukung logistik, distribusi makanan, dan perlengkapan operasional perusahaan dengan standar kualitas terbaik, transparan, dan akuntabel.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center sm:justify-center lg:justify-start">
                             <a href="#services" class="px-8 py-3.5 text-base font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 hover:shadow-emerald-300 transform hover:-translate-y-0.5">
                                Lihat Layanan Kami
                            </a>
                            <router-link to="/app/auth" class="px-8 py-3.5 text-base font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                                Akses Dashboard
                            </router-link>
                        </div>
                        
                        <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-8 text-sm text-slate-500">
                             <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Terverifikasi & Legal</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Standar Food Grade</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Suply Chain Efisien</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Us Section -->
        <section id="about" class="py-24 bg-slate-50 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-24 items-center">
                    <div class="relative mb-12 lg:mb-0">
                         <div class="absolute -top-4 -left-4 w-72 h-72 bg-emerald-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                         <div class="absolute -bottom-8 -right-4 w-72 h-72 bg-teal-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                         <div class="relative bg-white p-8 rounded-2xl shadow-xl border border-slate-100">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-slate-50 p-6 rounded-xl text-center">
                                    <div class="text-4xl font-bold text-emerald-600 mb-2">100%</div>
                                    <div class="text-sm font-medium text-slate-600">Transparansi Harga</div>
                                </div>
                                <div class="bg-slate-50 p-6 rounded-xl text-center">
                                    <div class="text-4xl font-bold text-emerald-600 mb-2">24/7</div>
                                    <div class="text-sm font-medium text-slate-600">Layanan Operasional</div>
                                </div>
                                <div class="bg-slate-50 p-6 rounded-xl text-center col-span-2">
                                    <div class="text-4xl font-bold text-emerald-600 mb-2">Standard</div>
                                    <div class="text-sm font-medium text-slate-600">HACCP & Food Safety Compliant Equipment</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-base font-semibold text-emerald-600 tracking-wide uppercase mb-3">Tentang Kami</h2>
                        <h3 class="text-3xl font-bold text-slate-900 mb-6">Mitra Pengadaan Terpercaya untuk Skala Nasional</h3>
                        <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                            PT EDO MANDIRI PRATAMA berfokus pada penyediaan infrastruktur fisik dan peralatan pendukung untuk program makan bergizi nasional. Kami tidak menyediakan makanan, melainkan memastikan ekosistem distribusinya berjalan dengan peralatan yang aman, higienis, dan standar tinggi.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-white rounded-lg flex items-center justify-center shadow-sm border border-slate-100 text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900">Efisiensi</h4>
                                    <p class="text-slate-600">Proses pengadaan yang cepat dan tepat sasaran untuk mendukung operasional tanpa henti.</p>
                                </div>
                            </div>
                             <div class="flex gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-white rounded-lg flex items-center justify-center shadow-sm border border-slate-100 text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900">Akuntabilitas</h4>
                                    <p class="text-slate-600">Setiap unit peralatan tercatat dan dapat dipertanggungjawabkan kualitas serta distribusinya.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-24 bg-white relative">
             <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-base font-semibold text-emerald-600 tracking-wide uppercase mb-3">Layanan Kami</h2>
                    <h3 class="text-3xl font-bold text-slate-900 mb-4">Solusi Pengadaan Terintegrasi</h3>
                    <p class="text-lg text-slate-600">Kami menyediakan peralatan berkualitas tinggi untuk memastikan program berjalan lancar.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Service 1 -->
                    <div class="group bg-white rounded-2xl border border-slate-100 p-8 hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-3">Peralatan Program Makan Bergizi</h4>
                        <p class="text-slate-600 mb-6 min-h-[80px]">Penyediaan container distribusi, box logistik, thermal bag, dan perlengkapan penyimpanan makanan skala besar yang higienis.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center text-sm text-slate-500">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span> Food Grade Container
                            </li>
                            <li class="flex items-center text-sm text-slate-500">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span> Thermal Delivery Box
                            </li>
                            <li class="flex items-center text-sm text-slate-500">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span> Logistik Distribusi
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Service 2 -->
                    <div class="group bg-white rounded-2xl border border-slate-100 p-8 hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-14 h-14 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 mb-6 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-3">Peralatan Operasional Perusahaan</h4>
                        <p class="text-slate-600 mb-6 min-h-[80px]">Pengadaan lunch box, cutlery set (sendok/garpu), tray stainless/plastik, dan packaging operasional harian.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center text-sm text-slate-500">
                                <span class="w-1.5 h-1.5 bg-teal-500 rounded-full mr-2"></span> Stainless Tray & Cutlery
                            </li>
                            <li class="flex items-center text-sm text-slate-500">
                                <span class="w-1.5 h-1.5 bg-teal-500 rounded-full mr-2"></span> Eco-friendly Packaging
                            </li>
                            <li class="flex items-center text-sm text-slate-500">
                                <span class="w-1.5 h-1.5 bg-teal-500 rounded-full mr-2"></span> Bulk Equipment
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Service 3 -->
                    <div class="group bg-white rounded-2xl border border-slate-100 p-8 opacity-75 hover:opacity-100 transition-all duration-300 border-dashed">
                        <div class="w-14 h-14 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 mb-6">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-3">Layanan Ekspansi</h4>
                        <p class="text-slate-500 mb-6 min-h-[80px]">Solusi masa depan yang disesuaikan dengan kebutuhan bisnis Anda yang terus berkembang. Hubungi kami untuk custom order.</p>
                         <div class="mt-auto">
                            <span class="inline-flex items-center text-sm font-medium text-slate-500">
                                Segera Hadir
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Value Prop -->
        <section class="py-20 bg-slate-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                 <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                    <div class="lg:col-span-4 mb-10 lg:mb-0">
                        <h2 class="text-3xl font-bold mb-6">Mengapa Memilih Kami?</h2>
                        <p class="text-slate-400 mb-8 leading-relaxed">
                            Dedikasi kami terhadap kualitas dan ketepatan waktu menjadikan kami mitra ideal untuk proyek berskala nasional.
                        </p>
                        <a href="#contact" class="inline-flex items-center text-emerald-400 hover:text-emerald-300 font-semibold transition-colors">
                            Hubungi Tim Kami <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
                                <h4 class="text-lg font-bold mb-2 text-white">Standar Kualitas Ketat</h4>
                                <p class="text-slate-400 text-sm">Semua produk melalui QC ketat untuk memastikan keamanan dan durabilitas.</p>
                            </div>
                            <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
                                <h4 class="text-lg font-bold mb-2 text-white">Delivery Tepat Waktu</h4>
                                <p class="text-slate-400 text-sm">Armada logistik terpercaya menjamin barang tiba sesuai jadwal operasional.</p>
                            </div>
                            <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
                                <h4 class="text-lg font-bold mb-2 text-white">Dokumentasi Lengkap</h4>
                                <p class="text-slate-400 text-sm">Administrasi rapi, faktur resmi, dan kelengkapan dokumen lelang/pengadaan.</p>
                            </div>
                            <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
                                <h4 class="text-lg font-bold mb-2 text-white">Layanan Responsif</h4>
                                <p class="text-slate-400 text-sm">Tim support siap membantu konsultasi kebutuhan 24/7.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-gradient-to-br from-emerald-700 to-teal-800 relative overflow-hidden">
             <!-- Abstract Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
                </svg>
            </div>
            
            <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
                <h2 class="text-3xl font-bold text-white mb-6">Siap Meningkatkan Standar Operasional Anda?</h2>
                <p class="text-emerald-100 mb-10 text-lg">Konsultasikan kebutuhan pengadaan perusahaan Anda bersama tim ahli kami.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#contact" class="px-8 py-3.5 bg-white text-emerald-800 font-bold rounded-xl hover:bg-emerald-50 transition-colors shadow-lg">
                        Hubungi Kami Sekarang
                    </a>
                    <router-link to="/app/auth" class="px-8 py-3.5 bg-transparent border-2 border-emerald-400 text-white font-bold rounded-xl hover:bg-emerald-600 hover:border-emerald-600 transition-colors">
                        Akses Portal Pengadaan
                    </router-link>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-16">
                     <h2 class="text-base font-semibold text-emerald-600 tracking-wide uppercase mb-3">Kontak & Lokasi</h2>
                    <h3 class="text-3xl font-bold text-slate-900">Hubungi Kami</h3>
                </div>
                
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="p-10 lg:p-14 bg-emerald-50/50">
                            <h4 class="text-2xl font-bold text-slate-900 mb-8">Informasi Kantor</h4>
                            
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                     <div class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center text-emerald-600 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-bold text-slate-900 uppercase mb-1">RAJA DUNIA DAPUR by PT EDO MANDIRI PRATAMA</h5>
                                        <p class="text-slate-600 leading-relaxed">
                                            Jl. HOS Cokroaminoto Blok C2, Kreo,<br>
                                            Kec. Larangan, Kota Tangerang, Banten 15156
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-4">
                                     <div class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center text-emerald-600 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-bold text-slate-900 uppercase mb-1">Telepon (WhatsApp)</h5>
                                        <div class="space-y-1">
                                            <p class="text-slate-600 font-medium text-sm">0877-8762-0888 <span class="text-slate-500 font-normal">- Annisa Nurliani (Aen/Ica)</span></p>
                                            <p class="text-slate-600 font-medium text-sm">0878-7838-1090 <span class="text-slate-500 font-normal">- Bagus</span></p>
                                        </div>
                                    </div>
                                </div>
                                
                                 <div class="flex items-start gap-4">
                                     <div class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center text-emerald-600 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-bold text-slate-900 uppercase mb-1">Jam Operasional</h5>
                                        <p class="text-slate-600">Buka 24 Jam</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="relative w-full h-full min-h-[300px] bg-slate-200">
                             <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3966.219713839943!2d106.73524189678953!3d-6.2347428!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1f0602cbd85%3A0x4943d402749ddda9!2sRAJA%20DUNIA%20DAPUR%20by%20PT%20EDO%20MANDIRI%20PRATAMA!5e0!3m2!1sid!2sid!4v1770584058457!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup lang="ts">
// No script logic needed for this static presentation page
</script>
