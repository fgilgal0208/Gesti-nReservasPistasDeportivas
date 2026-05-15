<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = ''; // Campo de teléfono añadido a la lógica
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'], // Validación del teléfono
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Creamos el usuario con el teléfono
        event(new Registered($user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $validated['password'],
        ])));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-[80vh] flex items-center justify-center w-full">
    <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-5xl border border-slate-100">
        
        <div class="md:w-5/12 bg-slate-900 p-12 flex flex-col justify-center items-start relative overflow-hidden hidden md:flex">
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            
            <div class="relative z-10">
                <h2 class="text-4xl font-black text-white leading-none tracking-tighter italic uppercase mb-4">
                    Pistas <br><span class="text-emerald-500">Cerro Muriano</span>
                </h2>
                <p class="text-slate-400 text-sm font-bold uppercase tracking-widest italic mb-8">
                    El deporte en tu pueblo, a un clic.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center gap-3 text-slate-300">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Reserva al instante</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-300">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Gestiona tus partidos</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-7/12 p-8 md:p-12 lg:p-16 flex flex-col justify-center bg-white">
            <div class="mb-8">
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Crear Cuenta</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Regístrate para empezar a jugar</p>
            </div>

            <form wire:submit="register" class="space-y-5">
                <div>
                    <label for="name" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1 block">Nombre Completo</label>
                    <input wire:model="name" id="name" type="text" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 font-bold py-3 px-4 transition-all text-sm text-slate-700" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-[10px] uppercase font-bold" />
                </div>

                <div>
                    <label for="phone" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1 block">Teléfono de Contacto</label>
                    <input wire:model="phone" id="phone" type="text" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 font-bold py-3 px-4 transition-all text-sm text-slate-700" required placeholder="600 000 000" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-[10px] uppercase font-bold" />
                </div>

                <div>
                    <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1 block">Correo Electrónico</label>
                    <input wire:model="email" id="email" type="email" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 font-bold py-3 px-4 transition-all text-sm text-slate-700" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] uppercase font-bold" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="password" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1 block">Contraseña</label>
                        <input wire:model="password" id="password" type="password" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 font-bold py-3 px-4 transition-all text-sm text-slate-700" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] uppercase font-bold" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1 block">Repetir Contraseña</label>
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 font-bold py-3 px-4 transition-all text-sm text-slate-700" required />
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a class="text-[11px] font-bold text-slate-400 hover:text-emerald-500 uppercase tracking-wider transition-colors" href="{{ route('login') }}" wire:navigate>
                        ¿Ya tienes cuenta? Entrar
                    </a>

                    <button type="submit" class="w-full sm:w-auto bg-slate-900 text-white py-3 px-8 rounded-xl font-black uppercase tracking-widest hover:bg-emerald-500 transition-all shadow-lg active:scale-95 text-[11px]">
                        Registrarse
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>