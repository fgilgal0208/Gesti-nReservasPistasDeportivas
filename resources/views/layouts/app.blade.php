<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Cerro Muriano Pádel | Ayuntamiento de Córdoba</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full text-slate-900 bg-slate-50 overflow-x-hidden">
        
        <div class="h-1.5 w-full bg-gradient-to-r from-blue-600 via-red-500 to-blue-600"></div>

        <div class="min-h-screen">
            <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
                <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20 items-center">
                        
                        <div class="flex items-center gap-4">
                            <div class="p-2 rounded-xl bg-slate-50 border border-slate-100 shadow-sm">
                                <svg class="w-10 h-10 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" fill-opacity="0.1"/>
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter leading-none">
                                    Cerro Muriano <br><span class="text-blue-600 text-xs font-bold tracking-[0.2em]">PÁDEL</span>
                                </h1>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-right hidden sm:block border-r border-slate-200 pr-6">
                                <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest italic">Vecino Registrado</span>
                                <p class="text-sm font-black text-slate-800 uppercase italic">{{ Auth::user()->name }}</p>
                            </div>
                            
                            <button wire:click="logout" class="flex items-center gap-2 group text-slate-400 hover:text-red-500 transition-colors">
                                <span class="text-[10px] font-black uppercase tracking-widest hidden md:block italic">Cerrar Sesión</span>
                                <div class="p-2.5 bg-slate-100 group-hover:bg-red-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="py-10">
                {{ $slot }}
            </main>

            <footer class="py-10 text-center border-t border-slate-100 bg-white mt-12">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] italic">
                    Ayuntamiento de Córdoba <span class="text-blue-600 mx-2">|</span> Instalaciones Deportivas Cerro Muriano
                </p>
            </footer>
        </div>
    </body>
</html>