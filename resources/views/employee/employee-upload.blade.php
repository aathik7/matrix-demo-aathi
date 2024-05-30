<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{ $title }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form method="post" action="{{ route('employee.upload') }}" enctype="multipart/form-data"  autocomplete="off">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-2 bg-white sm:p-6">
                            <label for="file" class="block font-medium text-sm text-gray-700">{{__('File')}}</label>
                            <input type="file" name="file" id="file" class="form-input rounded-md shadow-sm mt-1 block w-full" required />
                            @error('file')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 mr-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                {{__('Import')}}
                            </button>
                            <button type="button" x-data @click="templateDownload()"  class="inline-flex items-center px-4 py-2 mr-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                {{__('Template')}}
                            </button>
                            <button type="button" x-data @click="cancel()" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-500 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 cancelBtn">
                                {{__('Cancel')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
  function cancel() {
    window.location.href = "{{route('employee.index')}}";
  }
  function templateDownload() {
    window.location.href = "{{route('template.download')}}";
  }

  document.addEventListener('alpine:init', () => {
    Alpine.data('cancel', () => ({
      cancel
    }));
  });
</script>