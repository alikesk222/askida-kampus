<?php
/**
 * Ortak <head> içeriği — tüm düzenler ve bağımsız sayfalar bunu include eder.
 *
 * Kullanılan (opsiyonel) değişkenler:
 *   $headTitle  : <title> için öncelikli başlık (ör. t('auth.login_btn'))
 *   $pageTitle  : yoksa bu kullanılır
 *   $metaDesc   : meta description (yoksa t('footer.brand_desc'))
 *
 * Kullanım:  <head><?php include ROOT . '/views/layout/partials/head.php'; ?></head>
 */
$__headTitle = $headTitle ?? ($pageTitle ?? null);
$__cssPath   = ROOT . '/public/assets/css/app.css';
$__cssVer    = is_file($__cssPath) ? filemtime($__cssPath) : '1';
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($__headTitle && str_contains($__headTitle, 'Askıda Kampüs')) ? e($__headTitle) : (($__headTitle ? e($__headTitle) . ' — ' : '') . 'Askıda Kampüs') ?></title>
    <meta name="description" content="<?= e($metaDesc ?? t('footer.brand_desc')) ?>">
    <meta name="theme-color" content="#002D72">
    <link rel="icon" type="image/png" href="<?= asset('aybu.png') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Libre+Baskerville:wght@700&display=swap">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50:  '#F3F6FB',
                            100: '#E4EBF6',
                            200: '#C9D6EC',
                            400: '#8AA3CC',
                            600: '#3A5FA3',
                            700: '#1B4389',
                            800: '#002D72',
                            900: '#001F52',
                            950: '#021433',
                            DEFAULT: '#002D72'
                        },
                        gold: {
                            50:  '#FBF7EC',
                            100: '#F5ECD3',
                            300: '#DFC68A',
                            400: '#D4B266',
                            500: '#C9A24A',
                            600: '#A9852F',
                            700: '#8A6A1F',
                            DEFAULT: '#C9A24A'
                        },
                        page: '#F5F7FB'
                    },
                    fontFamily: {
                        sans:  ['Poppins', 'system-ui', '-apple-system', 'Segoe UI', 'sans-serif'],
                        brand: ['"Libre Baskerville"', 'Georgia', 'serif']
                    },
                    boxShadow: {
                        soft:  '0 1px 2px rgba(2,20,51,.06)',
                        lift:  '0 16px 40px rgba(2,20,51,.10)',
                        focus: '0 0 0 4px rgba(0,45,114,.14)'
                    },
                    borderRadius: {
                        arch: '210px 210px 24px 24px'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>?v=<?= $__cssVer ?>">
