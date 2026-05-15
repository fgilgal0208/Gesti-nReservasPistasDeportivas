<x-app-layout>
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-4xl font-black text-slate-900 uppercase italic tracking-tighter leading-none">
                    Reserva de <span class="text-blue-600">Pistas</span>
                </h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mt-2">
                    Servicio Municipal de Deportes - Cerro Muriano
                </p>
            </div>
            
            <div class="flex gap-4">
                <div class="bg-white px-5 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Tu Ubicación</span>
                        <span class="text-xs font-black text-slate-800 uppercase italic">Cerro Muriano, Córdoba</span>
                    </div>
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-xl shadow-slate-200/60 rounded-[3rem] border border-slate-200 overflow-hidden">
            <div class="p-2 sm:p-4 lg:p-8">
                <livewire:reserve-court />
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 border border-blue-100 p-8 rounded-[2.5rem]">
                <div class="bg-blue-600 w-10 h-10 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <h4 class="text-blue-900 font-black text-sm uppercase tracking-widest mb-2 italic font-black">Pago de Tasas</h4>
                <p class="text-blue-800/60 text-[11px] leading-relaxed font-bold italic uppercase tracking-tighter">
                    Indica el código MUR-XXXX en tu transferencia o Bizum. El justificante debe presentarse si es requerido por el personal municipal.
                </p>
            </div>

            <div class="bg-white border border-slate-200 p-8 rounded-[2.5rem] shadow-sm">
                <div class="bg-slate-900 w-10 h-10 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-slate-900 font-black text-sm uppercase tracking-widest mb-2 italic">Uso de la Pista</h4>
                <p class="text-slate-500 text-[11px] leading-relaxed font-bold italic uppercase tracking-tighter">
                    Las reservas tienen una duración fija de 90 minutos. Se ruega puntualidad para respetar el turno de los siguientes vecinos.
                </p>
            </div>

            <div class="bg-red-50 border border-red-100 p-8 rounded-[2.5rem]">
                <div class="bg-red-500 w-10 h-10 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-red-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h4 class="text-red-900 font-black text-sm uppercase tracking-widest mb-2 italic">Incidencias</h4>
                <p class="text-red-800/60 text-[11px] leading-relaxed font-bold italic uppercase tracking-tighter">
                    Para reportar cualquier daño en la red, cerramiento o iluminación, contacta con el servicio de mantenimiento municipal.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>