<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class=" container">
                        <div class="flex flex-col sm:flex-row sm:flex-wrap justify-evenly item-start gap-5">
                            @foreach ($animals as $animal)
                                <div
                                    class="flex flex-col justify-between max-w-sm bg-white border border-gray-400 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-5">
                                    <img class="w-[512px] rounded transition-all duration-300 filter grayscale hover:grayscale-0"
                                        src="{{ asset("storage/$animal->image") }}" alt="" />
                                    <div class="p-5">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            {{ $animal->name }}</h5>
                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                            {{ Str::of($animal->description)->limit(40) }}</p>
                                        <a href=""
                                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            Olvasok tovább

                                        </a>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layot>