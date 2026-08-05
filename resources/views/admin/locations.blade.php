<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Manage Locations') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-sm flex items-center gap-2" role="alert">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                  <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Add New Location Form -->
            <div class="p-6 sm:p-8 bg-white shadow-lg border border-slate-200 rounded-2xl">
                <header class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-semibold text-slate-800">
                        {{ __('Add New Location') }}
                    </h2>
                </header>

                <form method="post" action="{{ route('admin.locations.store') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Location Name (e.g. DESAWAR)')" class="text-slate-600 font-semibold" />
                            <input id="name" name="name" type="text" class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="result_time" :value="__('Result Time (e.g. 05:10 AM)')" class="text-slate-600 font-semibold" />
                            <input id="result_time" name="result_time" type="text" class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            <x-input-error class="mt-2" :messages="$errors->get('result_time')" />
                        </div>
                        <div>
                            <x-input-label for="sort_order" :value="__('Sort Order (Lower appears first)')" class="text-slate-600 font-semibold" />
                            <input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="0" />
                            <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            {{ __('Save Location') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Locations List -->
            <div class="p-6 sm:p-8 bg-white shadow-lg border border-slate-200 rounded-2xl">
                <header class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-semibold text-slate-800">
                        {{ __('Existing Locations') }}
                    </h2>
                </header>
                
                <div class="relative overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-sm text-left rtl:text-right text-slate-600">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold">Order</th>
                                <th scope="col" class="px-6 py-4 font-bold">Name</th>
                                <th scope="col" class="px-6 py-4 font-bold">Time</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                                <th scope="col" class="px-6 py-4 font-bold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($locations as $location)
                            <tr class="bg-white hover:bg-slate-50 transition-colors">
                                <form method="post" action="{{ route('admin.locations.update', $location->id) }}">
                                    @csrf
                                    @method('put')
                                    <td class="px-6 py-3">
                                        <input type="number" name="sort_order" value="{{ $location->sort_order }}" class="w-20 border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center font-semibold">
                                    </td>
                                    <td class="px-6 py-3 font-bold text-slate-900 whitespace-nowrap">
                                        <input type="text" name="name" value="{{ $location->name }}" class="border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold uppercase w-full">
                                    </td>
                                    <td class="px-6 py-3">
                                        <input type="text" name="result_time" value="{{ $location->result_time }}" class="border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-32 font-semibold text-slate-500">
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <label class="inline-flex items-center cursor-pointer">
                                          <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $location->is_active ? 'checked' : '' }}>
                                          <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500 shadow-inner"></div>
                                        </label>
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow">
                                            Update
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
