<main class="grid grid-cols-12 gap-3 h-full w-full overflow-hidden">


      {{-- Media --}}
      <aside class=" lg:col-span-7  m-auto items-center w-full overflow-scroll">

          {{-- Description Textarea --}}
          <div class="mb-4 px-2">
              <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  What's on your mind?
              </label>
              <textarea
                  wire:model="description"
                  id="description"
                  rows="6"
                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                  placeholder="Share your thoughts..."></textarea>
              @error('description')
              <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
              @enderror
          </div>

          @if (count($media)==0)
          {{-- trigger button --}}
          <label for="customFileInput" class=" m-auto max-w-fit flex-col flex gap-3 cursor-pointer">
              <input wire:model.live="media" type="file" multiple accept=".jpg,.png,.jpeg,.mp4,.mov" id="customFileInput" type="text" class="sr-only">

              <span class="m-auto">

                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                  </svg>


              </span>

              <span class="bg-blue-500 text-white text-sm rounded-lg p-2 px-4">
                  Upload files from computer
              </span>


          </label>
          @else

          {{-- Show when file count is > 0 --}}
          <div class="flex overflow-x-auto w-full max-w-full h-96 snap-x snap-mandatory gap-2 px-2">
              @foreach ($media as $key=> $file)
              <div class="w-full h-full shrink-0 snap-always snap-center">
                  <img src="{{$file->temporaryUrl()}}" alt="" class="w-full h-full object-contain">
              </div>
              @endforeach
          </div>

          @endif

          {{-- Post and Cancel Buttons --}}
          <div class="flex gap-4 justify-end mt-6 px-2">
              <a href="{{ route('home') }}"
                  class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                  Cancel
              </a>
              <button
                  wire.loading.attr='disabled'
                  wire:click="save"
                  type="button"
                  class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                  Post
              </button>
          </div>


      </aside>
</main>