<div>
  <div class="w-full py-2 pr-2 font-bold text-xl px-2">{{__('mass-emails::menu.total_results')}}</div>
  <div class="flex-1 p-4 space-y-6">

    <p class="text-xl">{{sprintf(__('mass-emails::menu.owner_number'), $total_owners)}}</p>
    <p class="text-xl">{{sprintf(__('mass-emails::menu.property_number'), $total_properties)}}</p>

    <div class="p-6">
      <div class="-mx-12 overflow-x-auto">
          <div class="inline-block min-w-full px-4">
              <div class="overflow-hidden bg-white shadow rounded-xl">
                  <div class="p-2 grid grid-cols-2 gap-4 bg-gray-200">
                      <div class="space-y-2">
                          <h4 class='py-2 px-4 font-nunito text-lg font-bold'>{{__('mass-emails::menu.results')}}</h4>
                      </div>
                  </div>
                  <table class="w-full text-left divide-y table-auto">
                      <thead>
                          <tr class="bg-gray-50">
                              <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                                  {{__('mass-emails::menu.select_table')}}
                              </th>

                              <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                                  {{__('mass-emails::menu.property_title_table')}}
                              </th>

                              <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                                  {{__('mass-emails::menu.owner_name_table')}}
                              </th>

                              <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                                {{__('mass-emails::menu.owner_name_table')}}
                            </th>

                              <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                                  ...
                              </th>
                          </tr>
                      </thead>

                      <tbody class="divide-y whitespace-nowrap">
                          @foreach ($results as $idx=> $result)
                          <tr>
                              <td class="px-4 py-3">
                                <input wire:model.lazy="selected_options.{{$idx}}" wire:change="redoCheckedOptions"
                                    class="text-blue-500 transition border border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                    type="checkbox">
                              </td>
                              <td class="px-4 py-3">{{$result->title}}</td>
                              <td class="px-4 py-3">@if($recipients == "contact") {{$result->owners->comercial_name}} @else {{$result->owners->reservation_brand_name}} @endif</td>
                              <td class="px-4 py-3">@if($recipients == "contact") {{$result->owners->comercial_email}} @else {{$result->owners->reservation_email}} @endif</td>
                              <td class="px-4 py-3"></td>
                          </tr>
                          @endforeach

                      </tbody>
                  </table>
              </div>
              <div class="mt-4 text-sm">{{sprintf(__("mass-emails::menu.selected_owners"), $checked, count($selected_options))}}</div>
          </div>
      </div>
  </div>
  </div>
</div>
