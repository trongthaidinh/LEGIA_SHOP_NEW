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

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
