<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Trường Cao đẳng Y tế Đắk Lắk - Cơ sở đào tạo uy tín về y tế, điều dưỡng và các ngành khoa học sức khỏe tại Tây Nguyên. Đào tạo nguồn nhân lực y tế chất lượng cao, đáp ứng nhu cầu chăm sóc sức khỏe cộng đồng.">
<link rel="canonical" href="{{ url()->current() }}" />
<link rel="sitemap" type="application/xml" href="{{ url('sitemap.xml') }}" />
<title>@yield('title', 'Cao Đẳng Y Tế Đắk Lắk')</title>
<link href="{{ asset('css/theme.css') }}" rel="stylesheet">
<link href="{{ asset('css/navigation.css') }}" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<meta name="apple-mobile-web-app-title" content="CDYT DAKLAK" />
<link rel="manifest" href="/site.webmanifest" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<style>
    body {
        background: linear-gradient(to bottom, #38d1a4, #ffffff);
        min-height: 100vh;
    }
    
    .page-container {
        max-width: 1200px;
        margin: 10px auto;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;

        @media (max-width: 768px) {
            margin: 0;
            border-radius: 0;
        }
    }
    .content-wrap {
        background: url("{{ asset('images/clouds.png') }}") repeat-x top;
        background-size: contain;
    }
    .top-header {
        background-color: white;
        border-bottom: 1px solid #e5e7eb;
    }
    .main-menu {
        background-color: var(--primary-dark);
    }
    .main-menu a {
        width: 100%;
        color: white;
        padding: 0.75rem 0.75rem;
        display: inline-block;
        transition: all 0.3s ease;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        text-align: center;
        white-space: nowrap;
    }
    .main-menu a:hover {
        background-color: #b83234;
    }
    .menu-container {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        background-color: rgba(255, 255, 255, 0.1);
    }
    .menu-item {
        position: relative;
    }
    .menu-item:hover .submenu {
        display: block;
    }
    .submenu {
        background-color: #2a8b6c;
        position: absolute;
        min-width: 200px;
        z-index: 100;
        display: none;
        box-shadow: 0 0px 6px rgba(255, 255, 255, 0.4);
    }
    .submenu a {
        display: block;
        width: 100%;
        text-align: left;
        padding: 0.75rem 1rem;
        text-transform: uppercase;
    }
    .submenu a:hover {
        background-color: #b83234;
    }
    .has-submenu::after {
        content: '▼';
        font-size: 0.6rem;
        margin-left: 4px;
        margin-bottom: 2px;
        display: inline-block;
        vertical-align: middle;
    }
</style>
