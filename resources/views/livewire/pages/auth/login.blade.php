<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-teal-800 to-emerald-600 relative overflow-hidden w-full">
    
    <!-- Círculos decorativos de fondo -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-10"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-300 rounded-full mix-blend-overlay filter blur-3xl opacity-20"></div>
    <div class="absolute -bottom-8 left-20 w-96 h-96 bg-blue-400 rounded-full mix-blend-overlay filter blur-3xl opacity-20"></div>

    <div class="w-full max-w-md bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8 relative z-10 border border-white/20 sm:mx-auto mx-4">
        
        <!-- Logo / Cabecera -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-blue-600 to-emerald-500 mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Acceso a Pistas</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Ayuntamiento de Cerro Muriano</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="login" class="space-y-6">
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Correo Electrónico</label>
                <input wire:model="form.email" id="email" class="block w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm" type="email" required autofocus autocomplete="username" placeholder="tu@correo.com" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Contraseña</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-semibold text-blue-600 hover:text-emerald-500 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                            ¿La has olvidado?
                        </a>
                    @endif
                </div>
                <input wire:model="form.password" id="password" class="block w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm" type="password" required autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block">
                <label for="remember" class="inline-flex items-center cursor-pointer">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 w-5 h-5 transition duration-200">
                    <span class="ms-3 text-sm text-gray-600 font-medium">Mantener sesión iniciada</span>
                </label>
            </div>

            <!-- Botón Login -->
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center items-center gap-2 bg-gradient-to-r from-blue-700 to-teal-600 text-white font-bold px-6 py-4 rounded-xl hover:from-blue-800 hover:to-emerald-700 focus:ring-4 focus:ring-emerald-200 transition-all duration-300 shadow-lg transform hover:-translate-y-0.5">
                    <span>Entrar a mi cuenta</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">¿No tienes cuenta? 
                    <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-blue-700 transition-colors" wire:navigate>Regístrate aquí</a>
                </p>
            </div>
        </form>
    </div>
</div>