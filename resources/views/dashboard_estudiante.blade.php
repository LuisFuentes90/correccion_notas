<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Estudiante - UTEC</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-[#A31D1D] p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl uppercase">UTEC - Portal de Notas</h1>
            <span>Bienvenido, {{ Auth::user()->nombre }}</span>
        </div>
    </nav>

    <div class="container mx-auto mt-10 p-6">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Mis Solicitudes de Corrección</h2>
            <p class="text-gray-600 mb-6">Desde aquí podrás ver el estado de tus trámites académicos.</p>
            
            <div class="border-4 border-dashed border-gray-200 rounded-lg h-32 flex items-center justify-center">
                <span class="text-gray-400 font-medium italic">Próximamente: Lista de tus notas actuales...</span>
            </div>
        </div>
    </div>
</body>
</html>