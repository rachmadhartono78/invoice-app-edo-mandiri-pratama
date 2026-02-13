@extends('layouts.guest')

@section('content')
<style>
    /* Premium Hero Section */
    .hero-wrapper {
        position: relative;
        overflow: hidden;
        padding: 6rem 1rem 4rem;
        background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.1) 0%, transparent 40%),
                    radial-gradient(circle at bottom left, rgba(236, 72, 153, 0.1) 0%, transparent 40%);
    }

    .hero-content {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 10;
    }

    .badge-new {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5; /* Indigo 600 */
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(79, 70, 229, 0.2);
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        color: var(--text-color);
        letter-spacing: -0.025em;
    }

    .hero-title span {
        background: linear-gradient(to right, #4f46e5, #9333ea); /* Indigo to Purple */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-secondary);
        margin-bottom: 2.5rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .btn-hero {
        padding: 0.875rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 0.5rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-hero-primary {
        background: #4f46e5; /* Indigo 600 */
        color: white;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .btn-hero-primary:hover {
        background: #4338ca; /* Indigo 700 */
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
    }

    /* Dashboard Preview Mockup */
    .dashboard-preview {
        margin-top: 4rem;
        border-radius: 1rem;
        box-shadow: var(--card-shadow);
        border: 1px solid var(--border-color);
        overflow: hidden;
        background: var(--card-bg);
        position: relative;
    }
    
    .browser-bar {
        background: var(--bg-color);
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        gap: 0.5rem;
    }
    
    .dot { width: 0.75rem; height: 0.75rem; border-radius: 50%; }
    .dot-red { background: #ef4444; opacity: 0.5; }
    .dot-yellow { background: #f59e0b; opacity: 0.5; }
    .dot-green { background: #10b981; opacity: 0.5; }

    /* Features Grid */
    .features-section {
        padding: 5rem 1rem;
        background: var(--bg-color);
    }

    .feature-card {
        padding: 2rem;
        border-radius: 1rem;
        background: var(--white);
        transition: all 0.2s;
        border: 1px solid var(--border-color);
    }

    .feature-card:hover {
        border-color: #4f46e5;
        box-shadow: var(--card-shadow);
        transform: translateY(-4px);
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
    }
</style>

<div class="hero-wrapper">
    <div class="hero-content">
        <span class="badge-new">✨ Official Partner Procurement</span>
        <h1 class="hero-title">
            Solusi Pengadaan <br>
            <span>Program Makan Bergizi</span>
        </h1>
        <p class="hero-subtitle">
            Kami menyediakan peralatan pendukung logistik, distribusi makanan, dan perlengkapan operasional perusahaan dengan standar kualitas terbaik, transparan, dan akuntabel.
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="#services" class="btn-hero btn-hero-primary">
                Lihat Layanan
            </a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-hero" style="background: var(--white); color: var(--text-color); border: 1px solid var(--border-color);">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-hero" style="background: var(--white); color: var(--text-color); border: 1px solid var(--border-color);">
                        Login Portal
                    </a>
                @endauth
            @endif
        </div>

        <!-- Abstract Dashboard Preview -->
        <div class="dashboard-preview">
            <div class="browser-bar">
                <div class="dot dot-red"></div>
                <div class="dot dot-yellow"></div>
                <div class="dot dot-green"></div>
                <div style="margin-left: 1rem; background: var(--border-color); height: 0.75rem; width: 200px; border-radius: 4px; opacity: 0.5;"></div>
            </div>
            <div style="padding: 2rem; background: var(--bg-color); min-height: 300px; display: grid; grid-template-columns: 200px 1fr; gap: 2rem;">
                <!-- Fake Sidebar -->
                <div style="gap: 1rem; display: flex; flex-direction: column;">
                     <div style="height: 2rem; background: var(--border-color); border-radius: 0.25rem; width: 80%; opacity: 0.5;"></div>
                     <div style="height: 1rem; background: var(--border-color); border-radius: 0.25rem; width: 100%; opacity: 0.3"></div>
                     <div style="height: 1rem; background: var(--border-color); border-radius: 0.25rem; width: 100%; opacity: 0.3"></div>
                     <div style="height: 1rem; background: var(--border-color); border-radius: 0.25rem; width: 100%; opacity: 0.3"></div>
                </div>
                <!-- Fake Content -->
                <div style="display: grid; gap: 1.5rem;">
                     <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                         <div style="height: 80px; background: var(--white); border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"></div>
                         <div style="height: 80px; background: var(--white); border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"></div>
                         <div style="height: 80px; background: var(--white); border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"></div>
                     </div>
                     <div style="height: 200px; background: var(--white); border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"></div>
                </div>
            </div>
            <!-- Overlay Gradient -->
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 150px; background: linear-gradient(to bottom, transparent, var(--card-bg));"></div>
        </div>
    </div>
</div>

<div class="features-section" id="services">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.25rem; font-weight: 700; color: var(--text-color); margin-bottom: 1rem;">Layanan Kami</h2>
            <p style="color: var(--text-secondary); font-size: 1.1rem;">Solusi Pengadaan Terintegrasi untuk program makan bergizi.</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <!-- Feature 1 -->
            <div class="feature-card">
                <div style="width: 3rem; height: 3rem; background: rgba(79, 70, 229, 0.1); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #4f46e5; margin-bottom: 1.5rem;">
                    <svg style="width:1.5rem;height:1.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-color);">Peralatan Program Makan Bergizi</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Penyediaan container distribusi, box logistik, thermal bag, dan perlengkapan penyimpanan makanan skala besar yang higienis.</p>
                 <ul style="margin-top: 1rem; padding-left: 0; list-style: none; color: var(--text-secondary); font-size: 0.9rem;">
                    <li style="margin-bottom: 0.5rem;">• Food Grade Container</li>
                    <li style="margin-bottom: 0.5rem;">• Thermal Delivery Box</li>
                    <li>• Logistik Distribusi</li>
                </ul>
            </div>
            
            <!-- Feature 2 -->
             <div class="feature-card">
                <div style="width: 3rem; height: 3rem; background: rgba(147, 51, 234, 0.1); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #9333ea; margin-bottom: 1.5rem;">
                    <svg style="width:1.5rem;height:1.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-color);">Peralatan Operasional</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Pengadaan lunch box, cutlery set (sendok/garpu), tray stainless/plastik, dan packaging operasional harian.</p>
                 <ul style="margin-top: 1rem; padding-left: 0; list-style: none; color: var(--text-secondary); font-size: 0.9rem;">
                    <li style="margin-bottom: 0.5rem;">• Stainless Tray & Cutlery</li>
                    <li style="margin-bottom: 0.5rem;">• Eco-friendly Packaging</li>
                    <li>• Bulk Equipment</li>
                </ul>
            </div>
            
            <!-- Feature 3 -->
             <div class="feature-card">
                <div style="width: 3rem; height: 3rem; background: rgba(236, 72, 153, 0.1); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #ec4899; margin-bottom: 1.5rem;">
                     <svg style="width:1.5rem;height:1.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-color);">Layanan Ekspansi</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Solusi masa depan yang disesuaikan dengan kebutuhan bisnis Anda yang terus berkembang.</p>
                <div style="margin-top: 1rem;">
                    <span style="font-size: 0.8rem; background: rgba(236, 72, 153, 0.1); color: var(--text-secondary); padding: 0.25rem 0.5rem; border-radius: 4px;">Segera Hadir</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="background: var(--white); border-top: 1px solid var(--border-color); padding: 4rem 1rem;" id="contact">
    <div style="max-width: 1200px; margin: 0 auto;">
         <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-size: 1.8rem; font-weight: 700; color: var(--text-color);">Hubungi Kami</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; text-align: left;">
            <div>
                <h3 style="font-weight: 700; margin-bottom: 1rem; color: var(--text-color);">Kantor Pusat</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">
                    <strong>RAJA DUNIA DAPUR</strong><br>
                    by PT EDO MANDIRI PRATAMA<br><br>
                    Jl. HOS Cokroaminoto Blok C2, Kreo,<br>
                    Kec. Larangan, Kota Tangerang, Banten 15156
                </p>
            </div>
            <div>
                 <h3 style="font-weight: 700; margin-bottom: 1rem; color: var(--text-color);">Kontak WhatsApp</h3>
                 <p style="color: var(--text-secondary); line-height: 1.6;">
                    <strong>Annisa Nurliani (Aen/Ica):</strong><br>
                     0877-8762-0888<br><br>
                    <strong>Bagus:</strong><br>
                    0878-7838-1090
                 </p>
            </div>
             <div>
                 <h3 style="font-weight: 700; margin-bottom: 1rem; color: var(--text-color);">Layanan</h3>
                 <p style="color: var(--text-secondary); line-height: 1.6;">
                    Jam Operasional: Buka 24 Jam<br>
                    Layanan Support: 24/7
                 </p>
            </div>
        </div>
    </div>
</div>
@endsection
