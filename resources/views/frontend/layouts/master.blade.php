<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <link rel="icon" href="/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="canonical" href="https://yensaolegia.com" />
  <meta name="theme-color" content="#000000" />
  <meta name="description"
    content="Yến Sào LeGia Nest chuyên phân phối tổ yến tươi, yến sào, yến chưng nguyên chất 100%, cam kết CHẤT LƯỢNG – KHÔNG PHA TRỘN để đảm bảo giữ nguyên vị thuần túy 100% từ tổ Yến tự nhiên." />
  <meta name="keywords" content="yến, yến tươi, yến sào, yến chưng, LegiaNest" />
  <meta name="author" content="Yến Sào LeGia'Nest" />

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://yensaolegia.com/">
  <meta property="og:title" content="Yến Sào LeGia'Nest - Thương hiệu yến sào uy tín">
  <meta property="og:description" content="Yến Sào LeGia Nest chuyên phân phối tổ yến tươi, yến sào, yến chưng nguyên chất 100%, cam kết CHẤT LƯỢNG – KHÔNG PHA TRỘN.">
  <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="https://yensaolegia.com/">
  <meta property="twitter:title" content="Yến Sào LeGia'Nest - Thương hiệu yến sào uy tín">
  <meta property="twitter:description" content="Yến Sào LeGia Nest chuyên phân phối tổ yến tươi, yến sào, yến chưng nguyên chất 100%, cam kết CHẤT LƯỢNG – KHÔNG PHA TRỘN.">
  <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

  <!-- Favicons -->
  <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <title>@yield('title', config('app.name', 'Yến Sào LeGia\'Nest'))</title>
  
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700,800&display=swap" rel="stylesheet" />
    
  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Additional Styles -->
  @stack('styles')

  <!-- Schema.org markup -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Yến Sào LeGia'Nest",
      "url": "https://yensaolegia.com",
      "logo": "https://yensaolegia.com/images/logo.png",
      "description": "Yến Sào LeGia Nest chuyên phân phối tổ yến tươi, yến sào, yến chưng nguyên chất 100%, cam kết CHẤT LƯỢNG – KHÔNG PHA TRỘN để đảm bảo giữ nguyên vị thuần túy 100% từ tổ Yến tự nhiên.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "60-62 Nguyễn Hữu Thọ",
        "addressLocality": "Buôn Ma Thuột",
        "addressRegion": "Đắk Lắk",
        "postalCode": "630000",
        "addressCountry": "VN"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+84-772-332-255",
        "contactType": "customer service"
      },
      "sameAs": [
        "https://facebook.com/yensaolegia",
        "https://instagram.com/yensaolegia",
        "https://youtube.com/yensaolegia"
      ]
    }
  </script>

  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "url": "https://yensaolegia.com",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://yensaolegia.com/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
  </script>

  <style>
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .toast-enter {
        animation: slideIn 0.3s ease-out forwards;
    }

    .toast-exit {
        animation: slideOut 0.3s ease-out forwards;
    }
  </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    @include('frontend.layouts.header')
    
    <!-- Flash Messages -->
    @if (session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-4"></div>

    <!-- Scripts -->
    @stack('scripts')
    <script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        
        // Base classes for toast
        let classes = 'toast-enter flex items-center p-4 rounded-lg shadow-lg max-w-md ';
        let icon = '';
        
        // Style based on type
        switch(type) {
            case 'success':
                classes += 'bg-green-50 text-green-800 border border-green-200';
                icon = `<svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                </svg>`;
                break;
            case 'error':
                classes += 'bg-red-50 text-red-800 border border-red-200';
                icon = `<svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                </svg>`;
                break;
            case 'warning':
                classes += 'bg-yellow-50 text-yellow-800 border border-yellow-200';
                icon = `<svg class="w-5 h-5 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                </svg>`;
                break;
            case 'info':
                classes += 'bg-blue-50 text-blue-800 border border-blue-200';
                icon = `<svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                </svg>`;
                break;
        }
        
        toast.className = classes;
        toast.innerHTML = `
            ${icon}
            <div class="flex-1">${message}</div>
            <button class="ml-4 text-gray-400 hover:text-gray-600" onclick="closeToast(this.parentElement)">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                </svg>
            </button>
        `;
        
        container.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => closeToast(toast), 5000);
    }

    function closeToast(toast) {
        toast.classList.add('toast-exit');
        setTimeout(() => toast.remove(), 300);
    }

    // Confirm dialog
    function showConfirm(message, onConfirm) {
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        
        const dialog = document.createElement('div');
        dialog.className = 'bg-white rounded-lg p-6 max-w-md w-full mx-4 transform transition-all scale-95 duration-200';
        dialog.innerHTML = `
            <div class="text-lg font-medium mb-4">${message}</div>
            <div class="flex justify-end gap-4">
                <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                        onclick="this.closest('.fixed').remove()">
                    {{ __('Cancel') }}
                </button>
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                        id="confirm-button">
                    {{ __('Confirm') }}
                </button>
            </div>
        `;
        
        overlay.appendChild(dialog);
        document.body.appendChild(overlay);
        
        // Add scale animation
        setTimeout(() => dialog.classList.remove('scale-95'), 10);
        
        // Handle confirm action
        document.getElementById('confirm-button').onclick = () => {
            onConfirm();
            overlay.remove();
        };
    }

    // Tạo custom event
    const cartUpdateEvent = new Event('cartUpdated');

    // Hàm cập nhật giỏ hàng và emit event
    function updateCart(carts) {
        localStorage.setItem('carts', JSON.stringify(carts));
        document.dispatchEvent(cartUpdateEvent);
    }
    </script>
    <!-- Google Analytics -->
    @if(config('app.env') === 'production')
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('services.google.analytics_id') }}');
    </script>
    @endif
</body>
</html>
