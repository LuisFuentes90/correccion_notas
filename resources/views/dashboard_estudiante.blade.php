<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Estudiante - UTEC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-utec-purple  { background-color: #582D81; }
        .text-utec-purple { color: #582D81; }
        .hover-utec:hover { background-color: #432262; }

        /* Animación fade-out para alertas */
        .fade-out {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- NAVBAR      --}}

    <nav class="bg-[#582D81] p-4 text-white shadow-xl">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <i class="fas fa-university text-2xl"></i>
                <h1 class="font-bold text-xl uppercase tracking-wider">UTEC — Portal Académico</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="bg-white text-[#582D81] px-3 py-1 rounded-full text-xs font-bold uppercase">
                    Estudiante
                </span>
                <span class="font-medium text-sm">
                    Bienvenido, {{ Auth::user()->nombre }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="hover:text-red-300 transition-colors duration-200"
                        title="Cerrar Sesión">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ALERTAS (auto-desaparecen en 3s)               --}}

    <div class="container mx-auto mt-6 px-4">

        @if(session('error'))
            <div id="alerta-error"
                class="bg-red-50 border-l-4 border-red-600 text-red-700 p-4 mb-4 rounded-r-lg shadow-md font-medium text-sm flex items-center space-x-2 transition-all duration-500">
                <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div id="alerta-exito"
                class="bg-green-50 border-l-4 border-green-600 text-green-700 p-4 mb-4 rounded-r-lg shadow-md font-medium text-sm flex items-center space-x-2 transition-all duration-500">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

    </div>

    {{-- CONTENIDO PRINCIPAL                            --}}
    <div class="container mx-auto mt-4 p-4">

        {{-- Header de sección --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">Mis Solicitudes</h2>
                <p class="text-gray-500 italic text-sm mt-1">
                    Seguimiento de tus correcciones de notas enviadas.
                </p>
            </div>
            <a href="/estudiante/nueva-solicitud"
                class="bg-[#582D81] text-white px-6 py-3 rounded-lg font-bold shadow-lg hover:bg-[#432262] transition transform hover:scale-105 flex items-center text-sm uppercase tracking-wide whitespace-nowrap">
                <i class="fas fa-plus mr-2"></i> Nueva Solicitud
            </a>
        </div>

        {{-- TABLA DE SOLICITUDES                           --}}

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">
                            Materia / Evaluación
                        </th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-center">
                            Estado
                        </th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">
                            Fecha de Solicitud
                        </th>
                        <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-right">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                        <tr class="border-b hover:bg-gray-50 transition">

                            {{-- COLUMNA: Materia / Evaluación --}}
                            <td class="p-4">
                                <p class="font-bold text-gray-800">
                                    {{ $solicitud->materiaRelacion->nombre ?? 'Sin nombre de materia' }}
                                </p>
                                <p class="text-xs text-gray-500 uppercase font-semibold tracking-tight mt-0.5">
                                    {{ $solicitud->evaluacion ?? '—' }}
                                    &mdash;
                                    {{ $solicitud->ciclo ?? '—' }}
                                </p>
                            </td>

                            {{-- COLUMNA: Estado (corregido para el ENUM real) --}}
                            <td class="p-4 text-center">
                                @php
                                    /*
                                     * ENUM real de la BD:
                                     * 'pendiente_docente' | 'rechazado_docente'
                                     * 'pendiente_coordinador' | 'rechazado_coordinador'
                                     * 'pendiente_admin' | 'finalizado'
                                     */

                                    // Estilos Tailwind por estado
                                    $clases = [
                                        'pendiente_docente'     => 'bg-orange-100 text-orange-700 border-orange-200',
                                        'rechazado_docente'     => 'bg-red-100    text-red-700    border-red-200',
                                        'pendiente_coordinador' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'rechazado_coordinador' => 'bg-red-100    text-red-700    border-red-200',
                                        'pendiente_admin'       => 'bg-blue-100   text-blue-700   border-blue-200',
                                        'finalizado'            => 'bg-green-100  text-green-700  border-green-200',
                                    ];

                                    // Ícono por estado
                                    $iconos = [
                                        'pendiente_docente'     => 'fa-hourglass-half',
                                        'rechazado_docente'     => 'fa-times-circle',
                                        'pendiente_coordinador' => 'fa-hourglass-half',
                                        'rechazado_coordinador' => 'fa-times-circle',
                                        'pendiente_admin'       => 'fa-hourglass-half',
                                        'finalizado'            => 'fa-check-circle',
                                    ];

                                    // Etiqueta legible para el estudiante
                                    $etiquetas = [
                                        'pendiente_docente'     => 'En revisión (Docente)',
                                        'rechazado_docente'     => 'Rechazada',
                                        'pendiente_coordinador' => 'En revisión (Coordinador)',
                                        'rechazado_coordinador' => 'Rechazada',
                                        'pendiente_admin'       => 'En revisión (Admin)',
                                        'finalizado'            => 'Aprobada y Finalizada',
                                    ];

                                    $estadoKey = $solicitud->estado;
                                    $estilo   = $clases[$estadoKey]   ?? 'bg-gray-100 text-gray-500 border-gray-200';
                                    $icono    = $iconos[$estadoKey]   ?? 'fa-circle';
                                    $etiqueta = $etiquetas[$estadoKey] ?? $estadoKey;
                                @endphp

                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase border {{ $estilo }}">
                                    <i class="fas {{ $icono }} text-[10px]"></i>
                                    {{ $etiqueta }}
                                </span>
                            </td>

                            {{-- COLUMNA: Fecha --}}
                            <td class="p-4 text-sm text-gray-500 font-medium">
                                @if($solicitud->fecha_solicitud)
                                    {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y H:i') }}
                                @else
                                    <span class="italic text-gray-400">Reciente</span>
                                @endif
                            </td>

                            {{-- COLUMNA: Acciones --}}
                            <td class="p-4 text-right">
                                <button
                                    class="text-[#582D81] hover:underline font-bold text-xs uppercase tracking-widest hover:text-[#432262] transition">
                                    <i class="fas fa-eye mr-1"></i> Ver Detalles
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center">
                                <div class="flex flex-col items-center text-gray-400">
                                    <i class="fas fa-inbox text-5xl mb-4 text-gray-300"></i>
                                    <p class="font-semibold text-base">Aún no tienes solicitudes</p>
                                    <p class="text-sm mt-1 italic">
                                        Cuando envíes una corrección de nota, aparecerá aquí.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Leyenda de estados --}}
        <div class="mt-6 flex flex-wrap gap-3 text-xs">
            <span class="font-bold text-gray-500 uppercase tracking-wider self-center">Referencias de Estado:</span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border bg-orange-100 text-orange-700 border-orange-200 font-semibold">
                <i class="fas fa-hourglass-half text-[10px]"></i> En revisión (Docente)
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border bg-yellow-100 text-yellow-700 border-yellow-200 font-semibold">
                <i class="fas fa-hourglass-half text-[10px]"></i> En revisión (Coordinador)
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border bg-blue-100 text-blue-700 border-blue-200 font-semibold">
                <i class="fas fa-hourglass-half text-[10px]"></i> En revisión (Admin)
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border bg-green-100 text-green-700 border-green-200 font-semibold">
                <i class="fas fa-check-circle text-[10px]"></i> Aprobada y Finalizada
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border bg-red-100 text-red-700 border-red-200 font-semibold">
                <i class="fas fa-times-circle text-[10px]"></i> Rechazada
            </span>
        </div>

    </div>{{-- fin container --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /**
             * Desvanecer alertas automáticamente después de 3 segundos
             */
            function desvanecerAlerta(id) {
                var el = document.getElementById(id);
                if (!el) return;
                setTimeout(function () {
                    el.style.opacity        = '0';
                    el.style.transform      = 'translateY(-10px)';
                    el.style.transition     = 'opacity 0.5s ease, transform 0.5s ease';
                    setTimeout(function () { el.remove(); }, 500);
                }, 3000);
            }

            desvanecerAlerta('alerta-error');
            desvanecerAlerta('alerta-exito');
        });
    </script>

</body>
</html>