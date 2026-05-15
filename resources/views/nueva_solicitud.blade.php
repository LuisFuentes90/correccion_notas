<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Solicitud - UTEC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-utec-purple { background-color: #582D81; }
        .border-utec-purple { border-color: #582D81; }
    </style>
</head>
<body class="bg-gray-100 pb-10">
    <nav class="bg-utec-purple p-4 text-white mb-8">
        <div class="container mx-auto font-bold uppercase">Nueva Solicitud de Corrección</div>
    </nav>

    <div class="container mx-auto max-w-4xl">
        <form action="/estudiante/guardar-solicitud" method="POST" class="bg-white shadow-2xl rounded-xl p-8 border-t-8 border-utec-purple">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2 bg-gray-50 p-4 rounded-lg border">
                    <p class="text-sm text-gray-600 uppercase font-bold">Datos del Solicitante</p>
                    <p class="text-lg font-bold text-utec-purple">{{ Auth::user()->nombre }}</p>
                    <p class="text-sm text-gray-500">Carnet: <span class="font-mono">ID-{{ Auth::user()->id }}</span></p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Facultad</label>
                    <select name="facultad_id" class="w-full p-3 border-2 rounded-lg focus:border-utec-purple outline-none">
                        <option value="">Seleccione Facultad...</option>
                        <option value="1">Informática y Ciencias Aplicadas</option>
                        </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Carrera</label>
                    <select name="carrera_id" class="w-full p-3 border-2 rounded-lg focus:border-utec-purple outline-none">
                        <option value="">Seleccione su Carrera...</option>
                        <option value="1">Ingeniería en Sistemas y Computación</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Materia Objeto de Corrección</label>
                    <select name="materia_id" class="w-full p-3 border-2 rounded-lg focus:border-utec-purple outline-none">
                        <option value="">Seleccione la Materia...</option>
                        <option value="1">Desarrollo de Sistemas Web II</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Docente que imparte la materia</label>
                    <input type="text" placeholder="Nombre completo del docente" name="docente_nombre" class="w-full p-3 border-2 rounded-lg focus:border-utec-purple outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Nota Publicada</label>
                    <input type="number" step="0.1" name="nota_actual" class="w-full p-3 border-2 rounded-lg outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Nota que debería tener</label>
                    <input type="number" step="0.1" name="nota_nueva" class="w-full p-3 border-2 rounded-lg outline-none border-green-200 bg-green-50">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Justificación del Reclamo</label>
                    <textarea name="motivo" rows="4" class="w-full p-3 border-2 rounded-lg focus:border-utec-purple outline-none" placeholder="Explique detalladamente por qué solicita la corrección..."></textarea>
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" class="flex-1 bg-utec-purple text-white py-4 rounded-lg font-bold shadow-lg hover:bg-purple-900 transition uppercase tracking-widest">
                    Enviar Solicitud al Docente
                </button>
                <a href="/estudiante/dashboard" class="px-8 py-4 text-gray-500 font-bold hover:bg-gray-100 rounded-lg transition uppercase text-sm flex items-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>