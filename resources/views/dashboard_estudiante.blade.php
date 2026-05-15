<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Estudiante - UTEC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-[#A31D1D] p-4 text-white shadow-xl">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <i class="fas fa-university text-2xl"></i>
                <h1 class="font-bold text-xl uppercase tracking-wider">UTEC - Portal Académico</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="bg-white text-[#A31D1D] px-3 py-1 rounded-full text-xs font-bold uppercase">Estudiante</span>
                <span class="font-medium">Bienvenido, {{ Auth::user()->nombre }}</span>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-gray-300"><i class="fas fa-sign-out-alt"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">Mis Solicitudes</h2>
                <p class="text-gray-500 italic">Gestión de correcciones de notas y evaluaciones.</p>
            </div>
            <a href="/estudiante/nueva-solicitud" class="bg-[#A31D1D] text-white px-6 py-3 rounded-lg font-bold shadow-lg hover:bg-red-800 transition transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> NUEVA SOLICITUD
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-bold text-gray-600 text-sm uppercase">Materia / Evaluación</th>
                        <th class="p-4 font-bold text-gray-600 text-sm uppercase text-center">Estado</th>
                        <th class="p-4 font-bold text-gray-600 text-sm uppercase">Fecha</th>
                        <th class="p-4 font-bold text-gray-600 text-sm uppercase text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4">
                            <p class="font-bold text-gray-800 italic">Desarrollo de Sistemas Web II</p>
                            <p class="text-xs text-gray-500 uppercase font-semibold tracking-tighter">Evaluación 2 - Ciclo 01-2026</p>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-orange-100 text-orange-600 border border-orange-200">
                                <i class="fas fa-clock mr-1"></i> Pendiente Docente
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-500 font-medium">15/05/2026</td>
                        <td class="p-4 text-right text-red-600">
                            <button class="hover:underline font-bold text-xs uppercase tracking-widest">Ver Detalles</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>