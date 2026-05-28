<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
    <!-- MODERN MODAL WITH SPLIT LAYOUT + GLASSMORPHISM -->
    <style>
        /* Modal Base */
        .modal-modern {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Modal Container - Split Layout */
        .modal-modern-container {
            position: relative;
            width: 90%;
            max-width: 1300px;
            height: 85vh;
            margin: 5vh auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.4s ease;
            display: flex;
            flex-direction: row;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Close Button */
        .modal-modern-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 100;
            transition: all 0.3s ease;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .modal-modern-close:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }

        /* LEFT SIDE - Image Gallery (Split 50%) */
        .modal-image-section {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        /* Carrusel Moderno */
        .modern-carousel {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .carousel-main {
            width: 100%;
            height: 100%;
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .carousel-slide {
            min-width: 100%;
            height: 100%;
            position: relative;
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            padding: 40px 20px 20px;
        }

        .carousel-counter {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            font-size: 12px;
            font-weight: 600;
        }

        /* Carrusel Navigation */
        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 10;
        }

        .carousel-btn {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .carousel-btn:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: scale(1.1);
        }

        /* Thumbnails */
        .thumbnail-container {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 10px;
            z-index: 10;
        }

        .thumbnail {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        .thumbnail.active {
            border-color: white;
            opacity: 1;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail:hover {
            opacity: 1;
            transform: scale(1.05);
        }

        /* RIGHT SIDE - Information (Split 50%) */
        .modal-info-section {
            flex: 1;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            overflow-y: auto;
            padding: 32px;
            scrollbar-width: thin;
        }

        .modal-info-section::-webkit-scrollbar {
            width: 6px;
        }

        .modal-info-section::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal-info-section::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .status-disponible {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .status-proceso {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .status-adoptado {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
        }

        /* Pet Name */
        .pet-name {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 12px;
        }

        /* Tags Container */
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 24px;
        }

        .tag {
            background: rgba(102, 126, 234, 0.1);
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 500;
            color: #4a5568;
            transition: all 0.3s ease;
        }

        .tag:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }

        /* Info Cards (Glassmorphism) */
        .info-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 16px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.8);
        }

        .info-card-title {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #667eea;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea20, #764ba220);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .info-label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-top: 2px;
        }

        /* Health Indicators */
        .health-indicators {
            display: flex;
            gap: 16px;
            margin-top: 8px;
        }

        .health-badge {
            flex: 1;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            padding: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .health-badge.positive {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .health-badge.negative {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Story Section */
        .story-text {
            background: rgba(102, 126, 234, 0.05);
            border-radius: 16px;
            padding: 18px;
            font-size: 14px;
            line-height: 1.6;
            color: #374151;
            border-left: 3px solid #667eea;
        }

        /* Adoption Button */
        .btn-adopt-modern {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-adopt-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        }

        .btn-adopt-modern:active {
            transform: translateY(0);
        }

        /* Refugio Card */
        .refugio-card {
            background: linear-gradient(135deg, #667eea10, #764ba210);
            border-radius: 16px;
            padding: 16px;
            margin-top: 20px;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        /* Loading State */
        .loading-modern {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: white;
        }

        .spinner-modern {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modal-modern-container {
                flex-direction: column;
                height: 90vh;
                width: 95%;
            }

            .pet-name {
                font-size: 1.8rem;
            }

            .modal-info-section {
                padding: 20px;
            }

            .thumbnail {
                width: 40px;
                height: 40px;
            }
        }
    </style>
    <!-- Modal Moderno -->
    <div id="mascotaModalModern" class="modal-modern">
        <div class="modal-modern-container">
            <div class="modal-modern-close">&times;</div>

            <!-- Left Side - Gallery -->
            <div class="modal-image-section" id="modalGallerySection">
                <!-- Gallery content loaded dynamically -->
            </div>

            <!-- Right Side - Information -->
            <div class="modal-info-section" id="modalInfoSection">
                <!-- Info content loaded dynamically -->
            </div>
        </div>
    </div>
    <script>
        let currentMascotaDataModern = null;
        let currentSlideIndexModern = 0;

        function openModernModal(mascotaId) {
            const modal = document.getElementById('mascotaModalModern');
            if (!modal) {
                console.error('Modal no encontrado');
                return;
            }

            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            // Show loading
            document.getElementById('modalGallerySection').innerHTML = `
            <div class="loading-modern">
                <div class="spinner-modern"></div>
                <p style="margin-top: 20px;">Cargando galería...</p>
            </div>
        `;
            document.getElementById('modalInfoSection').innerHTML = `
            <div class="loading-modern">
                <div class="spinner-modern"></div>
                <p style="margin-top: 20px;">Cargando información...</p>
            </div>
        `;

            fetch(`/api/mascota/${mascotaId}`)
                .then(response => response.json())
                .then(data => {
                    currentMascotaDataModern = data;
                    currentSlideIndexModern = 0;
                    renderModernGallery(data);
                    renderModernInfo(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('modalInfoSection').innerHTML = `
                    <div class="text-center py-12">
                        <div style="font-size: 48px; margin-bottom: 16px;">😢</div>
                        <p>Error al cargar la información</p>
                        <button onclick="closeModernModal()" class="btn-adopt-modern" style="margin-top: 20px; width: auto; padding: 10px 24px;">
                            Cerrar
                        </button>
                    </div>
                `;
                });
        }

        function renderModernGallery(mascota) {
            const container = document.getElementById('modalGallerySection');

            if (!mascota.fotos || mascota.fotos.length === 0) {
                container.innerHTML = `
                <div class="modern-carousel">
                    <div class="carousel-main">
                        <div class="carousel-slide">
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                <div style="text-align: center; color: white;">
                                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p style="margin-top: 16px;">No hay fotos disponibles</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                return;
            }

            let carouselHTML = `
            <div class="modern-carousel">
                <div class="carousel-counter">
                    📸 ${mascota.fotos.length} fotos
                </div>
                <div class="carousel-main" id="carouselMain">
                    ${mascota.fotos.map((foto, idx) => `
                        <div class="carousel-slide">
                            <img src="${foto.url}" alt="${mascota.nombre} - Foto ${idx + 1}">
                        </div>
                    `).join('')}
                </div>
                <div class="carousel-nav">
                    <div class="carousel-btn" onclick="changeModernSlide(-1)">❮</div>
                    <div class="carousel-btn" onclick="changeModernSlide(1)">❯</div>
                </div>
                <div class="thumbnail-container" id="thumbnailContainer">
                    ${mascota.fotos.map((foto, idx) => `
                        <div class="thumbnail ${idx === 0 ? 'active' : ''}" onclick="goToModernSlide(${idx})">
                            <img src="${foto.url}" alt="Miniatura ${idx + 1}">
                        </div>
                    `).join('')}
                </div>
            </div>
        `;

            container.innerHTML = carouselHTML;
        }

        function renderModernInfo(mascota) {
            const container = document.getElementById('modalInfoSection');

            let estadoClass = '';
            let estadoText = '';
            switch (mascota.estado) {
                case 'disponible':
                    estadoClass = 'status-disponible';
                    estadoText = '✓ Disponible para adopción';
                    break;
                case 'en_proceso':
                    estadoClass = 'status-proceso';
                    estadoText = '⏳ En proceso de adopción';
                    break;
                case 'adoptado':
                    estadoClass = 'status-adoptado';
                    estadoText = '❤️ Ya fue adoptado';
                    break;
            }

            let botonAdopcion = '';
            @auth
            @if(auth() -> user() -> role === 'usuario')
            if (mascota.estado === 'disponible') {
                botonAdopcion = `
                        <button onclick="window.location.href='/usuario/mascota/${mascota.id}/postular'" class="btn-adopt-modern">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            ¡Quiero Adoptar esta Mascota!
                        </button>
                    `;
            } else {
                botonAdopcion = `
                        <div style="background: rgba(107, 114, 128, 0.1); border-radius: 40px; padding: 14px; text-align: center; color: #6b7280; margin-top: 24px;">
                            ⚠️ Esta mascota ya no está disponible
                        </div>
                    `;
            }
            @elseif(auth() -> user() -> role === 'refugio')
            botonAdopcion = `
                    <div style="background: rgba(102, 126, 234, 0.1); border-radius: 40px; padding: 14px; text-align: center; color: #667eea; margin-top: 24px;">
                        👋 Eres un refugio. Gestiona esta mascota en tu panel.
                    </div>
                `;
            @endif
            @else
            botonAdopcion = `
                <button onclick="window.location.href='/login'" class="btn-adopt-modern">
                    🔑 Inicia sesión para adoptar
                </button>
            `;
            @endauth

            const html = `
            <div>
                <div class="status-badge ${estadoClass}" style="margin-bottom: 20px;">
                    ${estadoText}
                </div>
                
                <h1 class="pet-name">${mascota.nombre}</h1>
                
                <div class="tags-container">
                    <span class="tag">🐕 ${mascota.tipo}</span>
                    <span class="tag">📏 ${mascota.tamaño}</span>
                    ${mascota.raza ? `<span class="tag">🎨 ${mascota.raza}</span>` : ''}
                </div>
                
                <!-- Info Cards -->
                <div class="info-card">
                    <div class="info-card-title">
                        <span>📋</span> Información General
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">🎂</div>
                            <div>
                                <div class="info-label">Edad</div>
                                <div class="info-value">${mascota.edad}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">📏</div>
                            <div>
                                <div class="info-label">Tamaño</div>
                                <div class="info-value">${mascota.tamaño}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Health Card -->
                <div class="info-card">
                    <div class="info-card-title">
                        <span>💚</span> Salud y Cuidados
                    </div>
                    <div class="health-indicators">
                        <div class="health-badge ${mascota.esterilizado ? 'positive' : 'negative'}">
                            <div style="font-size: 24px;">${mascota.esterilizado ? '✅' : '❌'}</div>
                            <div style="font-size: 12px; margin-top: 4px;">Esterilizado</div>
                        </div>
                        <div class="health-badge ${mascota.vacunado ? 'positive' : 'negative'}">
                            <div style="font-size: 24px;">${mascota.vacunado ? '💉' : '❌'}</div>
                            <div style="font-size: 12px; margin-top: 4px;">Vacunado</div>
                        </div>
                    </div>
                </div>
                
                <!-- Story Card -->
                <div class="info-card">
                    <div class="info-card-title">
                        <span>📖</span> Historia de ${mascota.nombre}
                    </div>
                    <div class="story-text">
                        ${mascota.historia}
                    </div>
                </div>
                
                <!-- Refugio Card -->
                <div class="refugio-card">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                            🏠
                        </div>
                        <div>
                            <div style="font-size: 12px; color: #6b7280;">Refugio responsable</div>
                            <div style="font-weight: 700; color: #1f2937;">${mascota.refugio?.name || 'Refugio'}</div>
                        </div>
                    </div>
                    ${mascota.refugio?.telefono ? `
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6b7280;">
                            <span>📞</span> ${mascota.refugio.telefono}
                        </div>
                    ` : ''}
                </div>
                
                ${botonAdopcion}
            </div>
        `;

            container.innerHTML = html;
        }

        function changeModernSlide(direction) {
            if (!currentMascotaDataModern?.fotos?.length) return;

            const totalSlides = currentMascotaDataModern.fotos.length;
            currentSlideIndexModern = (currentSlideIndexModern + direction + totalSlides) % totalSlides;
            updateModernCarousel();
        }

        function goToModernSlide(index) {
            currentSlideIndexModern = index;
            updateModernCarousel();
        }

        function updateModernCarousel() {
            const carouselMain = document.getElementById('carouselMain');
            const thumbnails = document.querySelectorAll('.thumbnail');

            if (carouselMain) {
                carouselMain.style.transform = `translateX(-${currentSlideIndexModern * 100}%)`;
            }

            thumbnails.forEach((thumb, idx) => {
                if (idx === currentSlideIndexModern) {
                    thumb.classList.add('active');
                } else {
                    thumb.classList.remove('active');
                }
            });
        }

        function closeModernModal() {
            const modal = document.getElementById('mascotaModalModern');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            const closeBtn = document.querySelector('.modal-modern-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', closeModernModal);
            }

            const modal = document.getElementById('mascotaModalModern');
            if (modal) {
                window.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        closeModernModal();
                    }
                });
            }
        });
    </script>
</body>

</html>