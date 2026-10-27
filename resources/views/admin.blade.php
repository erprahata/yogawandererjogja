<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen - Yoga Wanderer</title>
    <link rel="icon" type="image/x-icon" href="/favicon1.ico">
    <link rel="apple-touch-icon" href="/favicon1.ico">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div id="app">
        <!-- Router View akan otomatis me-render AuthView (jika di /login) 
             atau AdminLayout (jika di /admin) -->
        <router-view></router-view>
    </div>
</body>
</html>