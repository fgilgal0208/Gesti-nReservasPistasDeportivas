<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
    <h3 class="text-xl font-bold mb-4 text-indigo-700">🎾 Hacer una nueva reserva</h3>
    
    <!-- Mensaje de Éxito -->
    @if (session()->has('message'))
        <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-100 border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-4">
        
        <!-- Pista -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Selecciona una pista:</label>
            <select wire:model="court_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Elige una pista --</option>
                @foreach($courts as $court)
                    <option value="{{ $court->id }}">{{ $court->name }}</option>
                @endforeach
            </select>
            @error('court_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Fecha -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Día de juego:</label>
                <input type="date" wire:model="reservation_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('reservation_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Hora -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Hora de inicio:</label>
                <input type="time" wire:model="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">El sistema reservará automáticamente 90 minutos.</p>
                @error('start_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Alerta de Overbooking -->
        @error('overlap') 
            <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-100 border border-red-200 font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                {{ $message }}
            </div>
        @enderror

        <div class="pt-4">
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold px-4 py-3 rounded-md hover:bg-indigo-700 transition duration-300 shadow-md">
                Confirmar Reserva
            </button>
        </div>
    </form>
</div>