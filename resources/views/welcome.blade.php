<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Una Vida Para Disfrutar</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: #1A4FBA;
            --color-primary-light: #3B6DD7;
            --color-primary-dark: #1E40AF;
            --color-secondary: #1E1E1E;
            --color-light: #F8FAFC;
            --color-gray: #E2E8F0;
            --color-dark: #1A202C;
            --color-text: #2D3748;
            --color-text-light: #718096;
            
            --radius-lg: 12px;
            --shadow-md: 0 4px 8px rgba(26, 79, 186, 0.3);
            --shadow-lg: 0 8px 20px rgba(26, 79, 186, 0.4);
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--color-light);
            color: var(--color-text);
            line-height: 1.65;
            margin: 0;
        }
        
        .dark body {
            background-color: var(--color-dark);
            color: white;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.75rem;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 1.125rem;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: var(--shadow-md);
            cursor: pointer;
            user-select: none;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
        }
        
        .btn-primary:hover,
        .btn-primary:focus {
            background-color: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            outline: none;
        }
        
        .btn-outline {
            border: 2px solid var(--color-gray);
            color: var(--color-text);
            background-color: white;
        }
        
        .dark .btn-outline {
            border-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .btn-outline:hover,
        .btn-outline:focus {
            border-color: var(--color-primary);
            color: var(--color-primary);
            outline: none;
        }
        
        .dark .btn-outline:hover,
        .dark .btn-outline:focus {
            border-color: var(--color-primary);
            color: var(--color-primary-light);
        }
        
        .hero-section {
        background-color: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        border-radius: var(--radius-lg);
        padding: 4rem 3rem 3rem;
        box-shadow: var(--shadow-lg);
        color: var(--color-text); /* asegura texto oscuro */

        }
        
        .dark .hero-section {
            background: linear-gradient(135deg, rgba(30, 30, 30, 0.9) 0%, rgba(37, 99, 235, 0) 60%);
        }
        
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--color-gray);
        }
        
        .feature-item:last-child {
            border-bottom: none;
        }
        
        .feature-icon {
            flex-shrink: 0;
            width: 3.25rem;
            height: 3.25rem;
            min-width: 3.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(37, 99, 235, 0.15);
            border-radius: 50%;
            color: var(--color-primary);
            box-shadow: 0 2px 6px rgba(26, 79, 186, 0.2);
            transition: background-color 0.3s ease;
        }
        
        .feature-icon svg {
            width: 1.75rem;
            height: 1.75rem;
        }
        
        .dark .feature-icon {
            background-color: rgba(37, 99, 235, 0.25);
        }
        
        .feature-item:hover .feature-icon {
            background-color: var(--color-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(26, 79, 186, 0.5);
        }
        
        .feature-item:hover h4 {
            color: var(--color-primary);
        }
        
        .feature-item h4 {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-bottom: 0.25rem;
            transition: color 0.3s ease;
        }
        
        .feature-item p {
            font-size: 1.125rem;
            opacity: 0.9;
            font-family: 'Figtree', sans-serif;
            margin: 0;
        }
        
        .logo-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        /* Logo text */
        .logo-text-container {
            text-align: center;
            margin: 3rem 0 1rem;
        }

        .logo-text {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 800;
            font-size: 5.5rem;
            color: #213AC4; 
            text-shadow: 2px 3px 6px rgba(0,0,0,0.25);
            letter-spacing: 3px;
            user-select: none;
            transition: color 0.4s ease;
        }

        .logo-text:hover {
            color: #f66e3b;
            cursor: pointer;
            text-shadow: 2px 3px 12px rgba(246, 110, 59, 0.8);
        }

        /* Títulos */
        h1, h2, h3 {
            font-family: 'Merriweather', serif;
            color: var(--color-primary-dark);
            margin: 0 0 1rem 0;
        }
        
        h1 {
            font-weight: 900;
            font-size: 3.5rem;
        }
        
        h2 {
            font-weight: 700;
            font-size: 2.75rem;
        }
        
        h3 {
            font-weight: 600;
            font-size: 2rem;
            border-bottom: 3px solid var(--color-primary-light);
            padding-bottom: 0.5rem;
            width: fit-content;
        }

        /* Texto */
        p {
            font-size: 1.125rem;
            line-height: 1.7;
            color: var(--color-text);
        }

        /* CTA */
        .cta-btn {
            display: inline-block;
            background: var(--color-primary);
            color: #fff;
            font-weight: 700;
            padding: 1.2rem 2.5rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            user-select: none;
        }

        .cta-btn:hover,
        .cta-btn:focus {
            background: var(--color-primary-dark);
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
            outline: none;
        }

        .cta-note {
            margin-top: 0.75rem;
            font-weight: 600;
            color: var(--color-primary-light);
            font-size: 1rem;
            user-select: none;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-cover bg-center bg-no-repeat" 
      style="background-image: url('{{ asset('downloads/img_intro.webp') }}');">
    <header class="w-full max-w-7xl mx-auto px-6 py-6">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-5">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Iniciar sesión</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>
    
    <main class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <section class="hero-section bg-blue-900 text-white p-12 rounded-xl shadow-lg">
                <div class="max-w-5xl mx-auto">
                    <!-- Encabezado principal -->
                    <div class="mb-12 text-center">
                        <h1 class="text-5xl lg:text-6xl font-bold mb-6 font-serif tracking-tight leading-tight">
                            Bienvenido a <span class="text-yellow-300">Una Vida Para Disfrutar</span>
                        </h1>
                        <p class="text-xl lg:text-2xl font-light max-w-3xl mx-auto leading-relaxed opacity-90">
                            Descubre nuestra exclusiva flota de autocaravanas premium y vive escapadas inolvidables en plena naturaleza.
                        </p>
                    </div>

                    <!-- Contenido destacado -->
                    <div class="p-10 max-w-4xl mx-auto rounded-xl bg-blue-800 border border-blue-700 shadow-xl">
                        <!-- Título principal -->
                        <h2 class="text-4xl lg:text-5xl font-bold mb-8 leading-tight font-serif tracking-tight text-center">
                            Vive la libertad y la aventura sin límites
                        </h2>

                        <!-- Lista de características -->
                        <div class="space-y-6">
                            <div class="feature-item">
                                <div class="feature-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 20v-6m-6 6v-6m12 6v-6M9 10l3-3 3 3m-6 0l3 3 3-3" />
                                    </svg>
                                </div>
                                <div>
                                    <h4>Flota Premium</h4>
                                    <p>Autocaravanas modernas, totalmente equipadas para que tu viaje sea cómodo y seguro.</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M8 12l2 2 4-4" />
                                    </svg>
                                </div>
                                <div>
                                    <h4>Reserva Fácil</h4>
                                    <p>Proceso de reserva online rápido y sencillo, para que solo te preocupes de disfrutar.</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M6 12v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-7" />
                                        <path d="M9 12V9a3 3 0 0 1 6 0v3" />
                                    </svg>
                                </div>
                                <div>
                                    <h4>Atención Personalizada</h4>
                                    <p> Estamos para ayudarte a planificar la mejor aventura, con soporte 24/7.</p>
                                    <p>     - Asistencia Telefónica: +66 666 666 666 </p>
                                    <p>     - E-mail de Reservas: servicio@reservas.org</p>
                                    <p>     - Contactanos por whatsApp: +66 666 666 666</p>
                                </div>
                            </div>
                        </div>

                        <!-- Botón CTA -->
                        <div class="mt-12 text-center">
                            <a href="{{ asset('downloads/app.apk') }}" 
                                class="cta-btn" 
                                role="button" 
                                aria-label="Descargar la app móvil APK" 
                                download>
                                Descarga ya nuestra App Android!
                            </a>
                            <p class="cta-note">¡Tu aventura comienza aquí!</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="logo-text-container" aria-label="Logo de Una Vida Para Disfrutar">
                <h1 class="logo-text logo-animation" aria-hidden="true">Una Vida Para Disfrutar</h1>
            </section>
        </div>
    </main>

    <footer class="w-full text-center py-6 text-gray-500 text-sm select-none">
        &copy; 2025 Una Vida Para Disfrutar. Todos los derechos reservados.
    </footer>
</body>
</html>
