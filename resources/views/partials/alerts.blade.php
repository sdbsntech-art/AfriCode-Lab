@if(session('success'))
    <div x-data="{ show: true }" x-show="show" class="max-w-7xl mx-auto mt-4">
        <div class="flex items-center justify-between rounded-2xl border border-[#b9d1bc] bg-[#e8f0e8] p-4 text-[#1d4935]">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-xl text-[#1d4935]"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-[#1d4935] hover:text-[#b85e32]"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show" class="max-w-7xl mx-auto mt-4">
        <div class="flex items-center justify-between rounded-2xl border border-[#e4c0b4] bg-[#f8e8e3] p-4 text-[#873f31]">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-xl text-[#a44735]"></i>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-[#a44735] hover:text-[#713327]"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
@endif

@if(session('info'))
    <div x-data="{ show: true }" x-show="show" class="max-w-7xl mx-auto mt-4">
        <div class="flex items-center justify-between rounded-2xl border border-[#d9ded5] bg-white p-4 text-[#274535]">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-info text-xl text-[#b85e32]"></i>
                <span class="text-sm font-medium">{{ session('info') }}</span>
            </div>
            <button @click="show = false" class="text-[#526258] hover:text-[#b85e32]"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" class="max-w-7xl mx-auto mt-4">
        <div class="rounded-2xl border border-[#e4c0b4] bg-[#f8e8e3] p-4 text-[#873f31]">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2 text-sm font-bold text-[#a44735]">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Veuillez corriger les erreurs ci-dessous :
                </div>
                <button @click="show = false" class="text-[#a44735] hover:text-[#713327]"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
