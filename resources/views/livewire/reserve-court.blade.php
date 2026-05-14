<div class="max-w-[1600px] mx-auto px-4 py-10 space-y-10">
    
    <!-- TABLA DE DISPONIBILIDAD -->
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
        <!-- Cabecera de Tabla -->
        <div class="bg-slate-900 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-6 text-white">
                <div>
                    <h3 class="font-black text-lg uppercase tracking-wider">Disponibilidad</h3>
                    <p class="text-emerald-400 text-[10px] font-bold uppercase italic">Ayuntamiento de Cerro Muriano</p>
                </div>
                <!-- Selector de Pista (Solo para la vista de tabla) -->
                <div class="relative">
                    <select wire:model.live="court_id" class="bg-white/10 border border-white/20 rounded-xl text-xs font-bold py-2 px-8 focus:ring-emerald-500 appearance-none cursor-pointer hover:bg-white/20 transition-all">
                        @foreach($courts as $court)
                            <option value="{{ $court->id }}" class="bg-slate-800 text-white">{{ $court->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Navegador Semanal (Rango de fechas) -->
            <div class="flex items-center bg-white/5 rounded-xl p-1.5 border border-white/10">
                <button wire:click="changeWeek(-1)" class="p-2 hover:bg-emerald-500 rounded-lg transition disabled:opacity-10" @if($weekOffset == 0) disabled @endif>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <span class="px-6 text-[11px] font-black text-white uppercase tracking-[0.2em] min-w-[180px] text-center">
                    {{ $weekRange }}
                </span>
                <button wire:click="changeWeek(1)" class="p-2 hover:bg-emerald-500 rounded-lg transition disabled:opacity-10" @if($weekOffset == 4) disabled @endif>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>

        <!-- Timeline Horizontal -->
        <div class="overflow-x-auto border-t border-slate-100">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-4 border-r border-b border-slate-100 min-w-[140px] sticky left-0 bg-slate-50 z-20 shadow-[2px_0_5px_rgba(0,0,0,0.01)]">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Timeline</span>
                        </th>
                        @foreach($this->slots as $slot)
                            <th class="p-3 border-b border-slate-100 min-w-[85px] text-center">
                                <span class="text-[10px] font-black text-blue-600">{{ $slot }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $day)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="p-4 border-r border-b border-slate-50 sticky left-0 bg-white group-hover:bg-slate-50 z-10 transition-colors">
                                <span class="block text-[9px] {{ $day->isToday() ? 'text-emerald-600' : 'text-slate-400' }} font-black uppercase tracking-tighter">
                                    {{ $day->isToday() ? 'Hoy' : $day->translatedFormat('D') }}
                                </span>
                                <span class="text-sm font-black text-slate-800">{{ $day->format('d/m') }}</span>
                            </td>

                            @foreach($this->slots as $slot)
                                @php
                                    $cellTime = \Carbon\Carbon::parse($day->format('Y-m-d') . ' ' . $slot);
                                    $res = $existingReservations->first(fn($r) => $cellTime >= $r->start_time && $cellTime < $r->end_time);
                                    $isPast = $cellTime->isPast();
                                @endphp
                                <td class="p-1 border-b border-slate-50 min-w-[85px]">
                                    @if($res)
                                        <div class="h-10 w-full bg-emerald-500 rounded-lg shadow-sm border border-emerald-600/10"></div>
                                    @elseif($isPast)
                                        <div class="h-10 w-full bg-slate-100/40 rounded-lg opacity-10"></div>
                                    @else
                                        <div class="h-10 w-full bg-white border border-dashed border-slate-200 rounded-lg"></div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ZONA DE RESERVA -->
    <div class="bg-white rounded-[2.5rem] shadow-xl p-8 border border-slate-100 overflow-hidden">
        <div class="flex flex-col lg:flex-row items-center gap-10">
            <div class="lg:w-1/6 text-center lg:text-left">
                <h4 class="text-3xl font-black text-slate-900 leading-none tracking-tighter italic uppercase">Reserva <br><span class="text-emerald-500">Ahora</span></h4>
                <p class="text-[9px] text-slate-400 font-bold mt-2 uppercase tracking-widest italic">Confirma y juega</p>
            </div>

            <form wire:submit="save" class="flex-1 grid grid-cols-1 md:grid-cols-5 gap-4 w-full items-end">
                <!-- Selector de Pista Ensanchado -->
                <div class="md:col-span-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1 block">¿En qué pista?</label>
                    <select wire:model.live="selected_court_id" class="w-full rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-emerald-500 font-bold text-slate-700 py-3.5 px-4 transition-all text-sm">
                        @foreach($courts as $court)
                            <option value="{{ $court->id }}">📍 {{ $court->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="md:col-span-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1 block">Fecha</label>
                    <input type="date" wire:model="reservation_date" class="w-full rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-emerald-500 font-bold py-3.5 px-4 transition-all text-sm">
                </div>

                <div class="md:col-span-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1 block">Hora Inicio</label>
                    <input type="time" wire:model="start_time" class="w-full rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-emerald-500 font-bold py-3.5 px-4 transition-all text-sm">
                </div>

                <div class="md:col-span-1">
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-black uppercase tracking-widest hover:bg-emerald-500 transition-all shadow-lg active:scale-95 text-[10px]">
                        Confirmar Reserva
                    </button>
                </div>
            </form>
        </div>

        <!-- Mensajes de Estado -->
        @if (session()->has('message'))
            <div class="mt-6 p-4 bg-emerald-500 text-white rounded-xl font-bold text-xs flex items-center gap-2 animate-bounce">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                {{ session('message') }}
            </div>
        @endif

        @error('overlap') 
            <div class="mt-4 p-4 bg-red-50 text-red-600 rounded-xl text-[10px] font-black border border-red-100 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/></svg>
                {{ $message }}
            </div> 
        @enderror
    </div>
</div>