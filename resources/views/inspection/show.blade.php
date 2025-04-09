@extends('layouts.app')
@section('content')
<div class="mt-8 mx-auto max-w-sm">
    <a href="#" class="mb-8 flex justify-center">
        <img src="{{ asset('logo.png') }}" alt="Logo L'Expert Etat des Lieux" width="52px">
    </a>
    <div class="bg-white rounded-sm shadow-xs flex flex-col gap-6 py-3">
        <div class="px-3 flex flex-col gap-2 items-center">
            <div class="bg-primary-100 text-secondary-500 rounded-full size-12 border-6 border-primary-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
            </div>
            <span class="text-md font-medium">{{ $inspectionReport->type->label() }}</span>
        </div>
        <div class="px-3 flex flex-col gap-1.5 text-[14px]">
            <div class="grid grid-cols-2 justify-between">
                <span>Date de réalisation</span>
                <span class="text-right">
                    {{ $inspectionReport->finalized_at->translatedFormat('d F Y') }}
                </span>
            </div>
            <div class="grid grid-cols-2 justify-between">
                <span>Adresse</span>
                <span class="text-right">{{ $inspectionReport->address }}</span>
            </div>
        </div>
        <div class="px-3 flex flex-col gap-1.5">
            <a href="{{ $zipPath }}" target="_blank" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-semibold transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-white text-[14px] shadow hover:bg-primary/90 h-9 px-4 py-2">Télécharger les photos</a>
            <a href="{{ $filePath }}" target="_blank" class="inline-flex items-center justify-center whitespace-nowrap underline text-gray-500">Télécharger l'état des lieux</a>
        </div>
    </div>
</div>
@endsection
