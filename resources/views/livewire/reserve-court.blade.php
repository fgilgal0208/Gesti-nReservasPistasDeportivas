<div class="max-w-[1600px] mx-auto px-4 py-8 space-y-8">
    
    @if($upcomingReservations->count() > 0)
        @php $current = $upcomingReservations[$currentReservationIndex]; @endphp
        <div class="bg-slate-900 rounded-3xl p-1 border-l-8 border-lime-400 shadow-2xl animate-fade-in">
            <div class="flex flex-col md:flex-row items-center justify-between px-8 py-4 gap-4">
                <div class="flex items-center gap-5">
                    <div class="bg-lime-400 p-3 rounded-2xl shadow-[0_0_15px_rgba(163,230,53,0.4)]">
                        <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black text-lime-400 uppercase tracking-[0.3em] italic">Tu Próxima Reserva</h4>
                        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mt-1">
                            <p class="text-white font-black text-xl uppercase italic leading-none">
                                {{ $current->court->name }} <span class="text-slate-500 mx-1">|</span> 
                                {{ \Carbon\Carbon::parse($current->start_time)->translatedFormat('d M \a \l\a\s H:i') }}h
                            </p>
                            
                            <div class="flex items-center gap-2">
                                <div class="bg-white/10 px-3 py-1 rounded-lg border border-white/20 flex items-center gap-2">
                                    <span class="text-[9px] font-black text-slate-400 uppercase">Concepto:</span>
                                    <span class="text-sm font-mono font-black text-lime-400 tracking-wider">{{ $current->payment_code }}</span>
                                </div>
                                
                                <button wire:click="cancelReservation({{ $current->id }})" 
                                        wire:confirm="¿Estás seguro de que quieres anular esta reserva? El hueco quedará libre para otros vecinos."
                                        class="p-1.5 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-lg transition-colors border border-red-500/20" 
                                        title="Anular pista">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 rounded-2xl p-2 border border-white/10">
                    <button wire:click="prevReservation" class="p-2 hover:bg-lime-400 hover:text-slate-900 text-white rounded-xl transition-all disabled:opacity-20" @if($currentReservationIndex == 0) disabled @endif>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    
                    <span class="text-[10px] font-black text-white px-3 border-x border-white/10 uppercase tracking-widest">
                        {{ $currentReservationIndex + 1 }} / {{ $upcomingReservations->count() }}
                    </span>

                    <button wire:click="nextReservation({{ $upcomingReservations->count() }})" class="p-2 hover:bg-lime-400 hover:text-slate-900 text-white rounded-xl transition-all disabled:opacity-20" @if($currentReservationIndex == $upcomingReservations->count() - 1) disabled @endif>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
        <div class="bg-slate-900 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-6 text-white">
                <div>
                    <h3 class="font-black text-lg uppercase tracking-wider italic">Disponibilidad</h3>
                    <p class="text-lime-400 text-[10px] font-bold uppercase tracking-widest">WPT Edition - Cerro Muriano</p>
                </div>
                <div class="relative">
                    <select wire:model.live="court_id" class="bg-white/10 border border-white/20 rounded-xl text-xs font-bold py-2 px-8 focus:ring-lime-500 appearance-none cursor-pointer hover:bg-white/20 transition-all text-white">
                        @foreach($courts as $court)
                            <option value="{{ $court->id }}" class="bg-slate-800">{{ $court->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex items-center bg-white/5 rounded-xl p-1.5 border border-white/10">
                <button wire:click="changeWeek(-1)" class="p-2 hover:bg-lime-400 hover:text-slate-900 text-white rounded-lg transition disabled:opacity-10" @if($weekOffset == 0) disabled @endif>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <span class="px-6 text-[11px] font-black text-white uppercase tracking-[0.2em] min-w-[180px] text-center">
                    {{ $weekRange }}
                </span>
                <button wire:click="changeWeek(1)" class="p-2 hover:bg-lime-400 hover:text-slate-900 text-white rounded-lg transition disabled:opacity-10" @if($weekOffset == 4) disabled @endif>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto border-t border-slate-100 p-6">
            <div class="min-w-[800px]">
                
                <div class="flex items-end pl-20 md:pl-28 mb-2">
                    @foreach($this->slots as $slot)
                        <div class="flex-1 relative h-4">
                            @if(str_ends_with($slot, ':00'))
                                <span class="absolute -left-3 bottom-0 text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                                    {{ explode(':', $slot)[0] }}h
                                </span>
                                <div class="absolute left-0 bottom-[-8px] w-px h-2 bg-slate-200"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="space-y-4">
                    @foreach($days as $day)
                        <div class="flex items-center gap-4 group">
                            
                            <div class="w-16 md:w-24 shrink-0 text-right">
                                <span class="block text-[10px] {{ $day->isToday() ? 'text-lime-600' : 'text-slate-400' }} font-black uppercase tracking-tighter">
                                    {{ $day->isToday() ? 'Hoy' : $day->translatedFormat('D') }}
                                </span>
                                <span class="text-sm font-black text-slate-800">{{ $day->format('d/m') }}</span>
                            </div>

                            <div class="flex-1 h-12 bg-slate-100 rounded-xl flex overflow-hidden shadow-inner border border-slate-200/50">
                                @foreach($this->slots as $slot)
                                    @php
                                        $cellTime = \Carbon\Carbon::parse($day->format('Y-m-d') . ' ' . $slot);
                                        
                                        $res = $existingReservations->first(function($r) use ($cellTime) {
                                            return $cellTime >= $r->start_time && $cellTime < $r->end_time;
                                        });

                                        $isPast = $cellTime->isPast();
                                    @endphp

                                    @if($isPast)
                                        <div class="flex-1 h-full bg-slate-200/60 transition-colors" title="Pasado: {{ $slot }}"></div>
                                    @elseif($res)
                                        @if($res->user_id === auth()->id())
                                            <div class="flex-1 h-full bg-blue-800 hover:bg-blue-700 transition-colors cursor-pointer" 
                                                 title="Tu reserva ({{ \Carbon\Carbon::parse($res->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($res->end_time)->format('H:i') }})">
                                            </div>
                                        @else
                                            <div class="flex-1 h-full bg-red-600 cursor-not-allowed" 
                                                 title="Ocupado ({{ \Carbon\Carbon::parse($res->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($res->end_time)->format('H:i') }})">
                                            </div>
                                        @endif
                                    @else
                                        <div class="flex-1 h-full bg-lime-400 hover:bg-lime-300 transition-colors cursor-pointer relative group/free" 
                                             onclick="window.scrollTo({top: document.body.scrollHeight, behavior: 'smooth'})"
                                             title="Hora libre: {{ $slot }}">
                                             <div class="absolute right-0 top-1/4 h-1/2 w-px bg-lime-500/30"></div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl p-8 border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <svg class="w-32 h-32 text-slate-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
        </div>

        <div class="flex flex-col lg:flex-row items-center gap-10 relative z-10">
            <div class="lg:w-1/6 text-center lg:text-left">
                <h4 class="text-3xl font-black text-slate-900 leading-none tracking-tighter italic uppercase">Reserva <br><span class="text-lime-500">Ya</span></h4>
                <p class="text-[9px] text-slate-400 font-bold mt-2 uppercase tracking-widest italic tracking-tighter">Entra en la pista</p>
            </div>

            <form wire:submit="save" class="flex-1 grid grid-cols-1 md:grid-cols-5 gap-4 w-full items-end">
                <div class="md:col-span-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Instalación</label>
                    <select wire:model.live="selected_court_id" class="w-full rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-lime-500 font-bold text-slate-700 py-3.5 px-4 transition-all text-sm">
                        @foreach($courts as $court)
                            <option value="{{ $court->id }}">📍 {{ $court->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="md:col-span-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Fecha</label>
                    <input type="date" wire:model.live="reservation_date" min="{{ date('Y-m-d') }}" class="w-full rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-lime-500 font-bold py-3.5 px-4 transition-all text-sm">
                </div>

                <div class="md:col-span-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block flex justify-between">
                        <span>Hora</span>
                        <span class="text-lime-500">90 MINS</span>
                    </label>
                    <select wire:model="start_time" class="w-full rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-lime-500 font-bold py-3.5 px-4 transition-all text-sm text-slate-700 cursor-pointer">
                        <option value="">Seleccionar...</option>
                        @forelse($this->availableSlots as $slot)
                            <option value="{{ $slot }}">{{ $slot }} (hasta {{ \Carbon\Carbon::parse($slot)->addMinutes(90)->format('H:i') }})</option>
                        @empty
                            <option value="" disabled>No hay horas disponibles</option>
                        @endforelse
                    </select>
                </div>

                <div class="md:col-span-1">
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-black uppercase tracking-widest hover:bg-lime-500 hover:text-slate-900 transition-all shadow-lg active:scale-95 text-[10px]">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>

        @if (session()->has('message'))
            <div class="mt-6 p-4 bg-lime-500 text-slate-900 rounded-xl font-black text-xs flex items-center gap-2 animate-bounce">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mt-6 p-4 bg-red-100 text-red-600 rounded-xl font-black text-xs flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
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