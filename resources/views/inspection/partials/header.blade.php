
<div class="mx-container mt-[1cm] flex flex-col gap-6 mb-10">
    <div class="flex gap-4 justify-between">
        <div class="flex flex-col gap-2.5">
            <h1 class="text-xl font-semibold leading-none">{{ $data->title }}</h1>
            <p class="text-base text-muted max-w-xs leading-5">
                {{ $data->description }}
            </p>
        </div>
        <div class="flex items-end text-right">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" width="64px" height="64px">
        </div>
    </div>
    <div class="grid grid-cols-2 gap-6">
        <div class="flex flex-col gap-1.5">
            <div class="flex gap-1">
                <span class="font-bold w-[180px]">Date d'établissement :</span>
                <span>{{ $data->formatedFinalizedDate }}</span>
            </div>
            @if($data->type === \App\Domain\InspectionReports\Enums\InspectionReportType::CHECK_OUT)
                <div class="flex gap-1">
                    <span class="w-[180px]">Date d'état des lieux d'entrée :</span>
                    <span>{{ $data->formatedCheckInDate }}</span>
                </div>
            @endif
        </div>
        <div class="bg-[#EBF1FF] border border-[#8FBFFF] rounded-sm p-3">
            <div class="flex justify-between gap-4">
                <div class="flex flex-col gap-0.5">
                    <div class="flex gap-1.5 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        <span class="font-semibold">Téléchargement des photos</span>
                    </div>
                    <p class="text-muted leading-5">Scannez ce QR code pour télécharger l’ensemble des photos en haute-définition.</p>
                </div>
                {{--
                <img
                        src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(storage_path(config('app.temp_storage_path') . '/' . $data->id . '/qrcode.svg'))) }}"
                        width="80"
                        height="80"
                        alt="QR Code"> --}}

            </div>
        </div>
    </div>
</div>
