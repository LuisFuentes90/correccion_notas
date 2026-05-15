<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Notas UTEC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Definimos el Morado UTEC personalizado */
        .bg-utec-purple { background-color: #582D81; }
        .text-utec-purple { color: #582D81; }
        .border-utec-purple { border-color: #582D81; }
        .focus-ring-utec:focus { --tw-ring-color: #582D81; }
    </style>
</head>
<body class="bg-gray-200 h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-xl shadow-2xl w-full max-w-md border-t-8 border-utec-purple">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 uppercase tracking-tight">
                Universidad <span class="text-utec-purple">Tecnológica</span>
            </h1>
            <p class="text-gray-500 font-medium mt-2 italic">Sistema de Corrección de Notas</p>
        </div>
        
        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1 uppercase">Correo Institucional</label>
                <input type="email" name="correo" 
                    placeholder="ejemplo@utec.edu.sv"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-utec-purple focus:ring-2 focus-ring-utec transition duration-200" 
                    required>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1 uppercase">Contraseña</label>
                <input type="password" name="password" 
                    placeholder="••••••••"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-utec-purple focus:ring-2 focus-ring-utec transition duration-200" 
                    required>
            </div>
            
            <button type="submit" 
                class="w-full bg-utec-purple text-white py-3 rounded-lg font-bold uppercase tracking-widest hover:bg-[#432262] transform hover:scale-[1.02] transition-all shadow-lg active:scale-95">
                Iniciar Sesión
            </button>
        </form>

        @if ($errors->any())
            <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-3">
                <p class="text-red-700 text-sm font-medium">
                    {{ $errors->first() }}
                </p>
            </div>
        @endif

        <div class="mt-8 text-center border-t pt-6">
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Facultad de Informática y Ciencias Aplicadas</p>
        </div>
    </div>
</body>
</html>