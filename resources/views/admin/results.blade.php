<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            {{ __('Update Daily Results') }}
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

            <div class="p-6 bg-white shadow-sm border border-slate-200 rounded-2xl mb-6">
                <form method="GET" action="{{ route('admin.results.index') }}" class="flex items-end gap-4">
                    <div>
                        <x-input-label for="date" :value="__('Select Date')" class="text-slate-600 font-semibold" />
                        <input id="date" name="date" type="date" value="{{ $date }}" class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()" />
                    </div>
                </form>
            </div>

            <div class="p-6 bg-white shadow-lg border border-slate-200 rounded-2xl">
                <header class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-semibold text-slate-800">
                        {{ __('Results for ') }} <span class="font-extrabold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</span>
                    </h2>
                    <p class="text-sm text-slate-500 mt-2">Leave blank if result is not declared yet (will show WAIT on the frontend).</p>
                </header>

                <form method="post" action="{{ route('admin.results.store') }}">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-8">
                        @foreach($locations as $location)
                        <div class="border border-slate-200 rounded-xl p-4 bg-slate-50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="absolute top-0 left-0 w-full h-1 bg-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <label for="loc_{{ $location->id }}" class="block text-sm font-bold text-slate-700 mb-2 truncate" title="{{ $location->name }}">
                                {{ strtoupper($location->name) }}
                            </label>
                            <input type="text" id="loc_{{ $location->id }}" name="numbers[{{ $location->id }}]" 
                                value="{{ isset($results[$location->id]) ? $results[$location->id]->lucky_number : '' }}"
                                class="border-slate-300 rounded-lg shadow-sm w-full text-center text-2xl font-black text-indigo-900 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                                maxlength="2" placeholder="--">
                            <div class="text-xs font-semibold text-slate-400 text-center mt-2 flex justify-center items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $location->result_time }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ __('Publish Results') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
