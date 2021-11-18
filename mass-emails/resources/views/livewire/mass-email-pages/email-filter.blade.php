<div>
  <div class="grid grid-cols-2 gap-4">
    <div class="py-2 pr-2 font-bold text-xl px-2">2. {{__('mass-emails::menu.pick_filters')}}</div>
    <div class="grid grid-cols-3">
      <div class="space-y-2 py-3">
        <input class="text-sky-500 transition border border-gray-300 rounded shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500" type="checkbox" wire:model.lazy="use_filter" value="true">
        <label class="ml-1 inline-block text-sm font-medium text-gray-700 @if($use_filter) underline @endif" for="">{{__('mass-emails::menu.use_filter')}}</label>
      </div>
      <div class="space-y-2">
        <select wire:model.lazy="picked_filter" wire:change="changeFilter"
                class="block  text-gray-700 border border-gray-200 rounded py-3 px-4 mt-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @if(!$use_filter) invisible  @endif" name="picked_filter" id="picked_filter">
          <option value="">{{ __('mass-emails::menu.no_filter')}}</option>
          @foreach($filters as $filter)
            <option value="{{$filter->id}}">{{$filter->name}}</option>
          @endforeach
        </select>
      </div>
      @error('picked_filter') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
    </div>
  </div>

  @foreach ($allFilters as $index => $filters)
  <div class="p-2 overflow-hidden bg-gray-50 rounded-xl">
    <ul class="space-y-2">
      <li class="py-1 transition rounded-xl ring-inset" x-data="{ open: true }">
        <button class="flex items-center justify-between w-full px-4 py-1 text-sm font-semibold focus:outline-none"
          x-on:click="open = !open" type="button">
          <div class="flex-1 space-y-2">
            <div class="grid grid-cols-3">
              <svg x-bind:class="open ? 'rotate-180 transform' : 'rotate-0 transform'" class="transition w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
              </svg>
              @if($filters["number_of_filters"] )
              <span class="text-center text-lg font-bold">{{sprintf(__('mass-emails::menu.selected_conditions'), $filters["number_of_filters"])}}</span>
              @endif
            </div>
          </div>
        </button>

        <div class="px-4 py-1" x-show="open">
          @foreach ($filters["filters"] as $choice_index => $choice)
          @if($choice["category"] == "Situação") <div class="pr-2 font-bold text-lg px-2">{{__('mass-emails::menu.property_filter')}}</div> @endif
          <div class="pr-2 font-bold px-2">{{$choice["category"]}}</div>
          <div class="grid grid-cols-5">
            @foreach ($choice["fields"] as $id => $filter)
              <div class="grid grid-rows-2">
                <div class="space-y-2 py-2">
                  <input class="text-sky-500 transition border border-gray-300 rounded shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500" type="checkbox" wire:model.lazy="allFilters.{{$index}}.filters.{{$choice_index}}.fields.{{$id}}.isVisible" value="true">
                  <label class="ml-1 inline-block text-sm font-medium text-gray-700" for="">{{$filter["field"]}}</label>
                </div>
                @if(isset($filter["type"]) != null)
                <div class="space-y-2">
                @switch($filter["type"])
                  @case("select")

                    @if(isset($filter["isVisible"]) && $filter["isVisible"])
                        <select wire:model.lazy="allFilters.{{$index}}.filters.{{$choice_index}}.fields.{{$id}}.value" wire:change="updateResults({{$index}})"
                        class="block w-32  text-gray-700 border border-gray-200 rounded py-3 px-4 mb-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="{{$filter["name"]}}" id="{{$filter["name"]}}">
                            <option value="">{{__('mass-emails::menu.pick_a_option')}}</option>
                        @foreach($filter["options"] as $idx => $option)
                            <option value="{{$idx}}">{{$option}}</option>
                          @endforeach
                        </select>
                    @endif
                    @break

                  @case("numeric")
                    @if(isset($filter["isVisible"]) && $filter["isVisible"])
                    <div class="flex">
                      <div class="">
                      <select wire:model.lazy="allFilters.{{$index}}.filters.{{$choice_index}}.fields.{{$id}}.signal"
                      class="block text-gray-700 border border-gray-200 rounded py-3 px-4 mb-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="{{$filter["name"]}}" id="{{$filter["name"]}}">
                        <option value="">{{__('mass-emails::menu.pick_a_option')}}</option>
                        @foreach($filter["options"] as $idx => $option)
                          <option value="{{$idx}}">{{$option}}</option>
                        @endforeach
                      </select>
                      </div>
                      <div class="mb-2">
                      <input class="ml-4 px-2 py-2 w-12 border border-gray-300" wire:model.lazy="allFilters.{{$index}}.filters.{{$choice_index}}.fields.{{$id}}.value" wire:change="updateResults({{$index}})" type="numeric"/>
                      </div>
                    </div>
                    @endif
                    @break

                  @case("multiselect")
                    @if(isset($filter["isVisible"]) && $filter["isVisible"])
                    <div wire:ignore>
                      <select wire:model.lazy="allFilters.{{$index}}.filters.{{$choice_index}}.fields.{{$id}}.value" wire:change="updateResults({{$index}})"
                      class="block text-gray-700 border border-gray-200 rounded py-3 px-4 mb-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="amenities" id="amenitiesOptions" multiple="multiple">
                        <option value="">{{__('mass-emails::menu.pick_a_option')}}</option>
                        @foreach($filter["options"] as $idx => $option)
                          <option value="{{$idx}}">{{$option}}</option>
                        @endforeach
                      </select>
                    </div>
                      <script>
                        $(document).ready(function() {

                          $('#amenitiesOptions').select2({
                            placeholder: "Select From List"
                          });

                          $(document).on('change', '#amenitiesOptions', function(e) {
                            let data = $(this).val();
                            @this.set('allFilters.{{$index}}.filters.{{$choice_index}}.fields.{{$id}}.value', data);
                          });

                        });
                      </script>
                      @endif
                    @break
                @endswitch
                </div>
                @endif
              </div>
            @endforeach
          </div>
          @endforeach

        </div>
      </li>
    </ul>
  </div>

  @if(count($allFilters) > 1)
  <div class="bg-white text-center p-4">
     OU
  </div>
  @endif

  @endforeach

    <div class="text-center text-md">
      <a wire:click="addNewFilter({{$index}})"
             class="mt-2 mr-2 cursor-pointer inline-flex items-center justify-center h-8 px-3 text-sm font-semibold tracking-tight text-white transition bg-green-400 rounded-lg shadow hover:bg-green-500 focus:bg-green-700 focus:outline-none focus:ring-offset-2 focus:ring-offset-green-700 focus:ring-2 focus:ring-white focus:ring-inset"
             type="button"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg> {{__('mass-emails::menu.add_condition')}} </a>
    </div>
    @isset($result_filtered)
      <p class="text-md font-bold text-center mt-4">{{sprintf(__('mass-emails::menu.founded_results'),$result_filtered)}}</p>
    @endisset

  <div class="flex-1 p-4 space-y-6">
    <div class="grid grid-cols-6">
      <div class="space-y-2 py-3">
        <input class="text-sky-500 transition border border-gray-300 rounded shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500" type="checkbox" wire:model.lazy="save_filter" value="true">
        <label class="ml-1 inline-block text-sm font-medium text-gray-700" for="">{{__('mass-emails::menu.save_filter')}}</label>
      </div>
      <div class="space-y-2">
        <input wire:model.lazy="filter_name" type="text" name="filter_name" id="filter_name"
          class="block text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 mt-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @if(!$save_filter) invisible  @endif @error('filter_name') border-red-700 @enderror">
          @error('filter_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
      </div>
      <div class="space-y-2">
        <button wire:click="storeFilter({{$index}})" type="button" class="ml-8 mt-2 inline-flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-green-500  focus:outline-none hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 @if(!$save_filter) hidden @endif"
        >{{__('mass-emails::menu.save_filter_btn')}}</button>
      </div>

      @if (session()->has('filter'))
        <div class="mt-4">
          <p class="inline-block text-xs text-green-500 border-green-400">{{session('filter')}}</p>
        </div>
      @endif
    </div>
  </div>
</div>
