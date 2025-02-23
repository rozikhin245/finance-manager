<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    
    <script>
        // Redirect ke halaman login setelah 3 detik
        setTimeout(function() {
            window.location.href = "{{ route('login') }}";
        }, 7000);

        // Loader muncul setelah 0.5 detik
        setTimeout(function() {
            document.querySelector('.loader').style.display = 'block';
        }, 2500);
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #ffffff;
            color: #333;
            text-align: center;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            animation: fadeIn 1.5s ease-in-out forwards;
        }
        h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 20px;
        }
        
        /* Loader */
        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #ccc;
            border-top-color: #333;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none; /* Loader awalnya tidak terlihat */
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang</h1>
        <p>Aplikasi Manajemen Keuangan</p>
        <div class="loader"></div> <!-- Loader Animasi -->
    </div>
</body>
</html>
