<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Saját posztjaim') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class=" container">
                        <div class="flex item-center justify-center">
                            @if (session('status') === 'animal-uploaded')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-md text-gray-600 dark:text-gray-400">{{ __('Sikeres feltöltés!.') }}</p>
                            @endif
                            @if (session('status') === 'animal-deleted')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                    class="text-md text-gray-600 dark:text-gray-400">{{ __('Sikeres törlés!') }}</p>
                            @endif
                            @if (session('status') === 'animal-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                    class="text-md text-gray-600 dark:text-gray-400">{{ __('Sikeres szerkesztés!') }}
                                </p>
                            @endif
                        </div>
                        <div class="flex flex-col sm:flex-row sm:flex-wrap justify-evenly item-start gap-5">

                            @forelse ($animals as $animal)
                                <div
                                    class="flex flex-col justify-between max-w-sm bg-white border border-gray-400 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-5">
                                    <img class="w-[512px] rounded transition-all duration-300 filter grayscale hover:grayscale-0"
                                        src="{{ asset("storage/$animal->image") }}" alt="{{ $animal->name }}" />
                                    <div class="p-5">
                                        <h5
                                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            {{ $animal->name }}</h5>
                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                            {{ Str::of($animal->description)->limit(40) }}</p>
                                        <div class="flex gap-5">

                                            <form action="{{ route('myposts.edit', $animal) }}" method="get">
                                                @csrf
                                                <button href="{{ route('myposts.edit', $animal) }}"
                                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    Szerkesztés
                                                    <svg class="ml-2 w-5 h-5  dark:text-gray-800 text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M7.75 4H19M7.75 4a2.25 2.25 0 0 1-4.5 0m4.5 0a2.25 2.25 0 0 0-4.5 0M1 4h2.25m13.5 6H19m-2.25 0a2.25 2.25 0 0 1-4.5 0m4.5 0a2.25 2.25 0 0 0-4.5 0M1 10h11.25m-4.5 6H19M7.75 16a2.25 2.25 0 0 1-4.5 0m4.5 0a2.25 2.25 0 0 0-4.5 0M1 16h2.25" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <x-danger-button x-data=""
                                                x-on:click="$dispatch('open-modal', 'confirm-animal-deletion-{{ $animal->uuid }}')">{{ __('Állat törlése') }}</x-danger-button>

                                            <x-modal name="confirm-animal-deletion-{{ $animal->uuid }}" focusable>
                                                <form method="post" action="{{ route('myposts.destroy', $animal) }}"
                                                    class="p-6">
                                                    @csrf
                                                    @method('delete')

                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                        {{ __('Biztos szeretnéd törölni ezt az állatot?') }}
                                                    </h2>

                                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                        {{ __('Ha egyszer kitörlöd az állatot, később újra fel kell töltened!') }}
                                                    </p>
                                                    <div class="mt-6 flex justify-end">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            {{ __('Mégse') }}
                                                        </x-secondary-button>

                                                        <x-danger-button class="ms-3">
                                                            {{ __('Állat törlése') }}
                                                        </x-danger-button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="text-center">
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">Még nincs feltöltött
                                        állatod</p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
