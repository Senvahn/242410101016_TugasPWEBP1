<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="{{ asset('style.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <style>
            body {
                background: linear-gradient(135deg, #fbfbfb 0%, #f9f6f0 100%);
            }

            .auth-container {
                min-height: 100vh;
                display: grid;
                grid-template-columns: 1fr minmax(450px, 650px);
                gap: 0;
                align-items: stretch;
                width: 100vw;
                max-width: none;
                margin: 0;
            }

            .auth-panel {
                background: linear-gradient(135deg, var(--cream), var(--cream-dark));
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: flex-end;
                padding: 40px;
                position: relative;
                overflow: hidden;
            }

            .auth-panel::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle at 20% 50%, rgba(201,137,74,0.08), transparent 50%);
                animation: drift 20s ease-in-out infinite;
            }

            .auth-panel-logo {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 280px;
                height: 280px;
                transform: translate(-35%, -50%);
                background-image: url('{{ asset('logohunny.webp') }}');
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                opacity: 0.08;
                pointer-events: none;
            }

            @keyframes drift {
                0%, 100% { transform: translate(0, 0); }
                50% { transform: translate(30px, 20px); }
            }

            .auth-panel-content {
                position: relative;
                z-index: 10;
                max-width: 380px;
                text-align: right;
            }

            .auth-panel-content h2 {
                font-family: 'Playfair Display', serif;
                font-size: 2.2rem;
                color: var(--primary);
                margin-bottom: 18px;
                line-height: 1.1;
            }

            .auth-panel-content p {
                color: var(--text-muted);
                font-size: 0.95rem;
                line-height: 1.7;
                margin-bottom: 28px;
            }

            .auth-form-container {
                background: var(--white);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 48px;
                border-left: 1px solid rgba(26,43,60,0.08);
            }

            .auth-logo {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 28px;
                justify-content: center;
            }

            .auth-logo img {
                width: 40px;
                height: 40px;
                border-radius: 12px;
            }

            .auth-logo span {
                font-family: 'Playfair Display', serif;
                color: var(--primary);
                font-weight: 700;
            }

            .auth-form {
                width: 100%;
                max-width: 460px;
            }

            .auth-form h1 {
                font-size: 1.5rem;
                color: var(--primary);
                margin-bottom: 8px;
                text-align: center;
            }

            .dark .auth-form h1,
            .dark .auth-form label,
            .dark .auth-logo span,
            .dark .auth-panel-content h2 {
                color: var(--text);
            }

            .dark .auth-panel-content p {
                color: var(--text-muted);
            }

            .dark .auth-panel::before {
                opacity: 0.14;
            }

            .auth-form > .text-center {
                color: var(--text-muted);
                font-size: 0.9rem;
                margin-bottom: 24px;
                text-align: center;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-group label {
                display: block;
                font-weight: 600;
                font-size: 0.85rem;
                color: var(--primary);
                margin-bottom: 8px;
            }

            .form-control {
                width: 100%;
                padding: 12px 14px;
                border: 1.5px solid rgba(26,43,60,0.12);
                border-radius: 10px;
                font-size: 0.95rem;
                font-family: 'DM Sans', sans-serif;
                transition: var(--transition);
                background: var(--cream);
            }

            .form-control:focus {
                outline: none;
                border-color: var(--accent);
                background: var(--white);
                box-shadow: 0 0 0 3px rgba(201,137,74,0.12);
            }

            .form-error {
                color: var(--danger);
                font-size: 0.8rem;
                margin-top: 5px;
            }

            .checkbox-group {
                display: flex;
                align-items: center;
                gap: 8px;
                margin: 18px 0;
            }

            .checkbox-group input {
                width: 16px;
                height: 16px;
                cursor: pointer;
            }

            .checkbox-group label {
                margin: 0;
                cursor: pointer;
                font-weight: 500;
            }

            .form-actions {
                display: flex;
                flex-direction: column;
                gap: 12px;
                margin-top: 24px;
            }

            .btn-submit {
                padding: 12px 20px;
                border-radius: 999px;
                border: none;
                font-weight: 700;
                cursor: pointer;
                transition: var(--transition);
                background: linear-gradient(135deg, var(--accent), var(--accent-light));
                color: var(--white);
            }

            .btn-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 24px rgba(201,137,74,0.25);
            }

            .auth-footer {
                text-align: center;
                font-size: 0.9rem;
                color: var(--text-muted);
                margin-top: 18px;
            }

            .auth-footer a {
                color: var(--accent);
                text-decoration: none;
                font-weight: 600;
            }

            .auth-footer a:hover {
                text-decoration: underline;
            }

            .theme-switch-btn {
                position: fixed;
                top: 16px;
                right: 16px;
                z-index: 50;
                border: none;
                cursor: pointer;
                padding: 10px 18px;
                border-radius: 999px;
                font-weight: 700;
                font-size: 0.95rem;
                background: rgba(255,255,255,0.95);
                color: #1a2b3c;
                box-shadow: 0 12px 30px rgba(0,0,0,0.12);
                transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
            }

            .theme-switch-btn:hover {
                transform: translateY(-1px);
            }

            .dark .theme-switch-btn {
                background: rgba(28,28,28,0.92);
                color: #f8f8f8;
            }

            @media (max-width: 960px) {
                .auth-container {
                    grid-template-columns: 1fr;
                }

                .auth-panel {
                    display: none;
                }

                .auth-form-container {
                    border-left: none;
                }
            }
        </style>
    </head>
    <body>
        <button id="themeToggleBtn" class="theme-switch-btn" type="button">🌙 Gelap</button>
        <div class="auth-container">
            <div class="auth-panel">
                <div class="auth-panel-logo"></div>
                <div class="auth-panel-content">
                    <h2>Hunny Pet Care</h2>
                    <p>Platform layanan hewan peliharaan terpercaya dengan fitur lengkap untuk grooming dan penjualan produk.</p>
                </div>
            </div>

            <div class="auth-form-container">
                <div class="auth-form">
                    <div class="auth-logo">
                        <img src="{{ asset('logohunny.webp') }}" alt="Hunny Logo">
                        <span>Hunny</span>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script src="{{ asset('app.js') }}"></script>
    </body>
</html>
