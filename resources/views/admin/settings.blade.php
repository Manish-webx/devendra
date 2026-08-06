<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <!-- Include Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame {
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            background: #fff;
        }
        .note-editor .note-toolbar {
            background-color: #f8fafc;
            border-bottom: 1px solid #cbd5e1;
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-sm flex items-center gap-2" role="alert">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                  <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="p-6 sm:p-8 bg-white shadow-lg border border-slate-200 rounded-2xl">
                <header class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-semibold text-slate-800">
                        {{ __('Site Content Settings') }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-600">
                        Update the content that appears on the homepage.
                    </p>
                </header>

                <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="bottom_text" :value="__('Homepage Bottom Text')" class="text-slate-700 font-bold mb-2" />
                        <textarea id="summernote" name="bottom_text">{{ old('bottom_text', $bottomText ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('bottom_text')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            {{ __('Save Settings') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Summernote JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Enter homepage bottom content here...',
                tabsize: 2,
                height: 300,
                toolbar: [
                  ['style', ['style']],
                  ['font', ['bold', 'underline', 'clear']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['table', ['table']],
                  ['insert', ['link', 'picture', 'video']],
                  ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
</x-app-layout>
