<div class="space-y-10">
    
    @if($upcomingReservations->count() > 0)
        @php $current = $upcomingReservations[$currentReservationIndex]; @endphp
        <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl border-l-8 border-blue-600 animate-fade-in text-white">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <h4 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] italic mb-2">Próximo Partido</h4>
                    <div class="flex items-center gap-4">
                        <p class="text-2xl font-black uppercase italic leading-none">
                            {{ $current->court->name }} <span class="text-slate-600 mx-1">|</span> 
                            {{ $current->start_time->translatedFormat('d M - H:i') }}h
                        </p>
                        <button wire:click="cancelReservation({{ $current->id }})" wire:confirm="¿Anular reserva?" class="text-red-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                    <div class="mt-4 inline-flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-2 rounded-xl">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Concepto Pago:</span>
                        <span class="text-sm font-mono font-black text-blue-400">{{ $current->payment_code }}</span>
                    </div>
                </div>

                <div class="bg-white/5 p-6 rounded-3xl border border-white/10">
                    <form wire:submit.prevent="uploadReceipt" class="space-y-4">
                        <label class="block text-[9px] font-black text-blue-500 uppercase tracking-widest italic mb-2">Subir Justificante (Imagen - Máx 10MB)</label>
                        <div class="flex items-center gap-4">
                            <input type="file" wire:model="justificante" class="text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-blue-600 file:text-white cursor-pointer" />
                            <button type="submit" wire:loading.attr="disabled" class="bg-white text-slate-900 px-6 py-2 rounded-full text-[10px] font-black uppercase hover:bg-blue-500 hover:text-white transition-all shadow-md">
                                <span wire:loading.remove>Enviar</span>
                                <span wire:loading>Enviando...</span>
                            </button>
                        </div>
                        @error('justificante') <span class="text-red-500 text-[10px] font-black italic">{{ $message }}</span> @enderror
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-[3rem] shadow-xl border border-slate-100 overflow-hidden">
        <div class="bg-slate-900 p-6 flex flex-col md:flex-row justify-between items-center text-white">
            <div class="flex items-center gap-6">
                <h3 class="font-black text-lg uppercase italic">Disponibilidad</h3>
                <select wire:model.live="court_id" class="bg-white/10 border-white/20 rounded-xl text-xs font-bold text-white">
                    @foreach($courts as $court) <option value="{{ $court->id }}" class="text-slate-900">{{ $court->name }}</option> @endforeach
                </select>
            </div>
            <div class="flex items-center gap-4">
                <button wire:click="changeWeek(-1)" class="p-2 hover:bg-blue-600 rounded-lg"> < </button>
                <span class="text-[10px] font-black uppercase tracking-widest">{{ $weekRange }}</span>
                <button wire:click="changeWeek(1)" class="p-2 hover:bg-blue-600 rounded-lg"> > </button>
            </div>
        </div>

        <div class="overflow-x-auto p-8">
            <div class="min-w-[900px] space-y-4">
                <div class="flex pl-28">
                    @foreach($this->slots as $slot)
                        @if(str_ends_with($slot, ':00')) <div class="flex-1 text-[9px] font-black text-slate-300 uppercase italic">{{ explode(':', $slot)[0] }}h</div> @endif
                    @endforeach
                </div>
                @foreach($days as $day)
                    <div class="flex items-center gap-4">
                        <div class="w-24 text-right">
                            <span class="block text-[9px] font-black uppercase italic {{ $day->isToday() ? 'text-blue-600' : 'text-slate-300' }}">{{ $day->translatedFormat('D') }}</span>
                            <span class="text-sm font-black">{{ $day->format('d/m') }}</span>
                        </div>
                        <div class="flex-1 h-12 bg-slate-50 rounded-2xl flex overflow-hidden border border-slate-100">
                            @foreach($this->slots as $slot)
                                @php
                                    $cellTime = \Carbon\Carbon::parse($day->format('Y-m-d') . ' ' . $slot);
                                    $res = $existingReservations->first(fn($r) => $cellTime >= $r->start_time && $cellTime < $r->end_time);
                                    $isPast = $cellTime->isPast();
                                @endphp
                                @if($isPast) <div class="flex-1 bg-slate-200/50 border-r border-white/20"></div>
                                @elseif($res) <div class="flex-1 {{ $res->user_id == auth()->id() ? 'bg-blue-600' : 'bg-red-500' }} border-r border-black/5"></div>
                                @else <div class="flex-1 bg-lime-400 hover:bg-lime-300 transition-colors border-r border-lime-500/20"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] p-8 shadow-xl border border-slate-100">
        <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div>
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Pista</label>
                <select wire:model.live="selected_court_id" class="w-full rounded-2xl border-slate-100 bg-slate-50 font-bold text-sm py-3">
                    @foreach($courts as $court) <option value="{{ $court->id }}">{{ $court->name }}</option> @endforeach
                </select>
            </div>
            <div>
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Fecha</label>
                <input type="date" wire:model.live="reservation_date" min="{{ date('Y-m-d') }}" class="w-full rounded-2xl border-slate-100 bg-slate-50 font-bold text-sm py-3">
            </div>
            <div>
                <label class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1 block italic">Hora (90 min)</label>
                <select wire:model="start_time" class="w-full rounded-2xl border-slate-100 bg-slate-50 font-bold text-sm py-3">
                    <option value="">Elegir hora...</option>
                    @foreach($this->availableSlots as $slot) <option value="{{ $slot }}">{{ $slot }}</option> @endforeach
                </select>
            </div>
            <button type="submit" class="bg-slate-900 text-white py-4 rounded-2xl font-black uppercase text-[11px] hover:bg-blue-600 transition-all">Confirmar Reserva</button>
        </form>
    </div>

</div>