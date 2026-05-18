<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Solicitud - UTEC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-utec-purple { background-color: #582D81; }
        .border-utec-purple { border-color: #582D81; }
        .text-utec-purple { color: #582D81; }
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
                <div class="col-span-2 bg-gray-50 p-4 rounded-lg border grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600 uppercase font-bold">Datos del Solicitante</p>
                        <p class="text-lg font-bold text-utec-purple">{{ Auth::user()->nombre }}</p>
                        <p class="text-sm text-gray-500">Carnet: <span class="font-mono font-bold text-gray-800">{{ Auth::user()->carnet ?? 'Sin Carnet' }}</span></p>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Facultad</label>
                        <input type="text" value="{{ $datosEstudiante->facultad_nombre ?? 'No asignada' }}" class="w-full p-2.5 border rounded-lg bg-gray-100 text-gray-600 outline-none text-sm font-medium" readonly>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Carrera</label>
                        <input type="text" value="{{ $datosEstudiante->carrera_nombre ?? 'No asignada' }}" class="w-full p-2.5 border rounded-lg bg-gray-100 text-gray-600 outline-none text-sm font-medium" readonly>
                    </div>
                    
                    <div class="col-span-2 mt-2">
    <label class="block text-xs font-bold text-purple-700 uppercase mb-1 tracking-wider">Periodo de Evaluación Activo</label>
    
    <input type="text" value="{{ $periodoActivo->evaluacion ?? 'Evaluación Activa' }}" class="w-full p-3 border-2 border-purple-200 rounded-lg bg-purple-50 text-purple-900 outline-none text-sm font-bold shadow-sm" readonly>
    
    @if(isset($periodoActivo->id))
        <input type="hidden" name="periodo_id" value="{{ $periodoActivo->id }}">
    @endif
</div>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Materia Objeto de Corrección</label>
                    <select name="materia_id" id="select_materia" class="w-full p-3 border-2 rounded-lg focus:border-utec-purple outline-none" required>
                        <option value="" data-docente="" data-docente-id="" data-seccion="">Seleccione la Materia...</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->materia_id }}" 
                                    data-docente="{{ $materia->docente_nombre }}" 
                                    data-docente-id="{{ $materia->docente_id }}"
                                    data-seccion="{{ $materia->estudiante_seccion }}">
                                {{ $materia->materia_nombre }} — {{ ucfirst($materia->estudiante_modalidad) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Sección</label>
                    <input type="text" id="input_seccion_visible" placeholder="Se asignará automáticamente..." class="w-full p-3 border-2 rounded-lg bg-gray-100 outline-none font-bold text-gray-700" readonly>
                    <input type="hidden" name="seccion" id="input_seccion_hidden">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Docente que imparte la materia</label>
                    <input type="text" id="input_docente_nombre" placeholder="Se asignará automáticamente..." class="w-full p-3 border-2 rounded-lg bg-gray-100 outline-none" readonly>
                    <input type="hidden" name="docente_id" id="input_docente_id">
                </div>
                
                <div id="contenedor_nota" class="col-span-2 p-4 rounded-lg border bg-gray-50 border-gray-200 transition-colors duration-300">
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Nota Publicada (0.0 a 9.9)</label>
                    <input type="number" step="0.1" min="0.0" max="9.9" name="nota_actual" id="input_nota" class="w-full p-3 border-2 rounded-lg outline-none focus:border-utec-purple bg-white" placeholder="Ej: 7.5" required>
                    <p id="error_nota" class="text-red-600 text-sm font-bold mt-2 hidden">⚠️ La nota no puede ser mayor a 9.9 ni menor a 0.0. Revise el valor ingresado.</p>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase mb-1">Justificación del Reclamo</label>
                    <textarea name="motivo" rows="4" class="w-full p-3 border-2 rounded-lg focus:border-utec-purple outline-none" placeholder="Explique detalladamente por qué solicita la corrección..." required></textarea>
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" id="btn_enviar" class="flex-1 bg-utec-purple text-white py-4 rounded-lg font-bold shadow-lg hover:bg-purple-900 transition uppercase tracking-widest">
                    Enviar Solicitud al Docente
                </button>
                <a href="/estudiante/dashboard" class="px-8 py-4 text-gray-500 font-bold hover:bg-gray-100 rounded-lg transition uppercase text-sm flex items-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        // 1. Manejo del Autocompletado Automático
        document.getElementById('select_materia').addEventListener('change', function() {
            var opcion = this.options[this.selectedIndex];
            
            var docenteNombre = opcion.getAttribute('data-docente');
            var docenteId = opcion.getAttribute('data-docente-id');
            var seccion = opcion.getAttribute('data-seccion');
            
            // Inyectamos la sección en su casilla específica
            document.getElementById('input_seccion_visible').value = seccion || '';
            document.getElementById('input_seccion_hidden').value = seccion || '';
            
            // Inyectamos el docente en su casilla específica
            document.getElementById('input_docente_nombre').value = docenteNombre || '';
            document.getElementById('input_docente_id').value = docenteId || '';
        });

        // 2. Validación de la Nota en tiempo real (Cambia a rojo SOLO si hay error)
        document.getElementById('input_nota').addEventListener('input', function() {
            let valor = parseFloat(this.value);
            let btnSubmit = document.getElementById('btn_enviar');
            let errorMsg = document.getElementById('error_nota');
            let contenedor = document.getElementById('contenedor_nota');

            if (valor > 9.9 || valor < 0 || isNaN(valor)) {
                // Si la nota es inválida, se activa el modo de error visual en rojo
                errorMsg.classList.remove('hidden');
                btnSubmit.disabled = true;
                btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
                contenedor.classList.remove('bg-gray-50', 'border-gray-200');
                contenedor.classList.add('bg-red-50', 'border-red-300');
                this.classList.add('border-red-500', 'bg-red-50');
            } else {
                // Si la nota es correcta, vuelve a la normalidad gris/morada
                errorMsg.classList.add('hidden');
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                contenedor.classList.remove('bg-red-50', 'border-red-300');
                contenedor.classList.add('bg-gray-50', 'border-gray-200');
                this.classList.remove('border-red-500', 'bg-red-50');
            }
        });
    </script>
</body>
</html>