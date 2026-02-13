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
        color: var(--primary-color);
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
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
        background: linear-gradient(to right, #4f46e5, #9333ea);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-secondary);
        margin-bottom: 2.5rem;
        max-width: 600px;
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
    }

    .btn-hero-primary {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .btn-hero-primary:hover {
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
        border-color: var(--primary-color);
        box-shadow: var(--card-shadow);
        transform: translateY(-4px);
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
    }
</style>

<div class="hero-wrapper">
    <div class="hero-content">
        <span class="badge-new">✨ New v2.0 Released</span>
        <h1 class="hero-title">
            Invoicing Made <br>
            <span>Simple & Professional</span>
        </h1>
        <p class="hero-subtitle">
            Stop wasting time on spreadsheets. Create, track, and manage your business invoices in one beautiful dashboard.
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center;">
            @guest
                <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">
                    Get Started Free
                    <svg style="width:1.25rem;height:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <a href="{{ route('login') }}" class="btn-hero" style="background: var(--white); color: var(--text-color); border: 1px solid var(--border-color);">
                    Sign In
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn-hero btn-hero-primary">
                    Go to Dashboard
                </a>
            @endguest
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

<div class="features-section">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.25rem; font-weight: 700; color: var(--text-color); margin-bottom: 1rem;">Everything you need.</h2>
            <p style="color: var(--text-secondary); font-size: 1.1rem;">Powerful features to help you get paid faster.</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <!-- Feature 1 -->
            <div class="feature-card">
                <div style="width: 3rem; height: 3rem; background: rgba(79, 70, 229, 0.1); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: var(--primary-color); margin-bottom: 1.5rem;">
                    <svg style="width:1.5rem;height:1.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-color);">Lightning Fast</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Create and send invoices in under 60 seconds. Pre-save your products and clients for instant auto-fill.</p>
            </div>
            
            <!-- Feature 2 -->
             <div class="feature-card">
                <div style="width: 3rem; height: 3rem; background: rgba(16, 185, 129, 0.1); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #10b981; margin-bottom: 1.5rem;">
                    <svg style="width:1.5rem;height:1.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-color);">Get Paid Sooner</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Professional invoices look better and get paid faster. Track status in real-time.</p>
            </div>
            
            <!-- Feature 3 -->
             <div class="feature-card">
                <div style="width: 3rem; height: 3rem; background: rgba(245, 158, 11, 0.1); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #d97706; margin-bottom: 1.5rem;">
                     <svg style="width:1.5rem;height:1.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-color);">Financial Insights</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Visualize your revenue, tax liabilities, and best clients with beautiful charts.</p>
            </div>
        </div>
    </div>
</div>
@endsection
