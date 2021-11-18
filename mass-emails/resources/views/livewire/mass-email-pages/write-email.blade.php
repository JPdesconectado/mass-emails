<div>
  <div class="w-full py-2 pr-2 font-bold text-xl px-2">3. {{__('mass-emails::menu.write')}}</div>
  <div class="flex-1 p-4 space-y-6">

      <div class="grid grid-cols-5">
        <div class="space-y-2 py-3">
          <input class="text-sky-500 transition border border-gray-300 rounded shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500" type="checkbox" wire:model.lazy="use_template" value="true">
          <label class="ml-1 inline-block text-sm font-medium text-gray-700 @if($use_template) underline @endif" for="">{{__('mass-emails::menu.use_template')}}</label>
        </div>
        <div class="space-y-2">
          <select wire:model.lazy="selected_template" wire:change="changeTemplate"
                  class="block  text-gray-700 border border-gray-200 rounded py-3 px-4 mt-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @if(!$use_template) invisible  @endif" name="selected_template" id="selected_template">
            <option value="">{{ __('crud-accommodation.no_template')}}</option>
            @foreach($templates as $template)
              <option value="{{$template->id}}">{{$template->title}}</option>
            @endforeach
          </select>
        </div>
        @error('selected_template') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
      </div>

    <div class="grid grid-cols-1 gap-4">
      <div class="space-y-2">
        <div class="inline-block text-sm font-medium text-gray-700">{{__('mass-emails::menu.subject')}}</div>
        <input wire:model.lazy="subject" type="text" name="subject" id="subject"
            class="w-full text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('subject') border-red-700 @enderror">
        @error('subject') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
      </div>
    </div>

    <div class="space-y-2 mt-4">
      <div class="inline-block text-sm font-medium text-gray-700">{{__('mass-emails::menu.message')}}</div>
        <textarea wire:model.lazy="message" type="text" name="message" id="message" rows="10"
            class="block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 resize-y @error('message') border-red-700 @enderror"></textarea>
        @error('message') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
    </div>

    <div class="space-y-2 mt-4">
      <p class="text-center text-gray-700 underline text-sm">{{__('mass-emails::menu.possible_tags')}}</p>

      <div class="grid grid-cols-3 justify-items-center">
          @foreach ($tags as $tag)
          <p class="text-sm text-gray-700 italic">{{$tag}}</p>
          @endforeach
      </div>
    </div>

    <div class="grid grid-cols-6">
      <div class="space-y-2 py-3">
        <input class="text-sky-500 transition border border-gray-300 rounded shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500" type="checkbox" wire:model.lazy="test_email" value="true">
        <label class="ml-1 inline-block text-sm font-medium text-gray-700" for="">{{__('mass-emails::menu.test_email')}}</label>
      </div>
      <div class="space-y-2">
        <input wire:model.lazy="email" type="text" name="email" id="email"
        class="block text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 mt-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @if(!$test_email) invisible  @endif @error('subject') border-red-700 @enderror">
        @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
      </div>

      <div class="space-y-2">
        <button wire:click="sendTestEmail" wire:loading.attr="disabled" type="button" class="ml-8 mt-2 inline-flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-green-500  focus:outline-none hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 @if(!$test_email) hidden @endif"
        >{{__('mass-emails::menu.send_test_email')}}</button>
      </div>


      @if (session()->has('email'))
        <div class="mt-4">
          <p class="inline-block text-xs text-green-500 border-green-400">{{session('email')}}</p>
        </div>
      @endif
    </div>



    <div class="grid grid-cols-6">
      <div class="space-y-2 py-3">
        <input class="text-sky-500 transition border border-gray-300 rounded shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500" type="checkbox" wire:model.lazy="save_template" value="true">
        <label class="ml-1 inline-block text-sm font-medium text-gray-700" for="">{{__('mass-emails::menu.save_template')}}</label>
      </div>
      <div class="space-y-2">
        <input wire:model.lazy="template_name" type="text" name="template_name" id="template_name"
          class="block text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 mt-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @if(!$save_template) invisible  @endif @error('template_name') border-red-700 @enderror">
          @error('template_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
      </div>
      <div class="space-y-2">
        <button wire:click="storeTemplate" type="button" class="ml-8 mt-2 inline-flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-green-500  focus:outline-none hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 @if(!$save_template) hidden @endif"
        >{{__('mass-emails::menu.save_template_btn')}}</button>
      </div>

      @if (session()->has('template'))
        <div class="mt-4">
          <p class="inline-block text-xs text-green-500 border-green-400">{{session('template')}}</p>
        </div>
      @endif
    </div>
  </div>
</div>
