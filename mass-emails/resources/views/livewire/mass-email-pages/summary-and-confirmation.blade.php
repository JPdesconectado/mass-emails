<div>
  <div class="w-full py-2 pr-2 font-bold text-xl px-2">{{__('mass-emails::menu.btn_summary')}}</div>
  <div class="flex-1 p-4 space-y-6">

    <p class="text-center">{{sprintf(__('mass-emails::menu.transaction_list'), $transaction_code, $total)}}</p>
    <p class="text-center font-bold">{{__('mass-emails::menu.pending_list')}}</p>


    <div class="py-4">
      <p class="text-center font-bold text-xl">{{sprintf(__('mass-emails::menu.total_email'), $total)}}</p>
    </div>

    <div class="p-6">
      <div class="-mx-12 overflow-x-auto">
          <div class="inline-block min-w-full px-4">
              <div class="overflow-hidden bg-white shadow rounded-xl">
                  <div class="p-2 grid grid-cols-2 gap-4 bg-gray-200">
                      <div class="space-y-2">
                          <h4 class='py-2 px-4 font-nunito text-lg font-bold'>{{__('mass-emails::menu.results')}}</h4>
                      </div>
                      <div class="space-y-2  text-right">
                              <a
                              wire:click="cancelEmails"
                              class="mt-2 mr-2 cursor-pointer inline-flex items-center justify-center h-8 px-3 text-sm font-semibold tracking-tight text-white transition bg-red-400 rounded-lg shadow hover:bg-red-500 focus:bg-red-700 focus:outline-none focus:ring-offset-2 focus:ring-offset-red-700 focus:ring-2 focus:ring-white focus:ring-inset"
                              type="button"><i class="fas fa-plane-departure mr-2"></i>  {{__('mass-emails::menu.cancel_btn')}} </a>
                      </div>
                  </div>
                  <table class="w-full text-left divide-y table-auto">
                      <thead>
                          <tr class="bg-gray-50">
                              <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                                  {{__('mass-emails::menu.status_table')}}
                              </th>

                              <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                                  {{__('mass-emails::menu.email_table')}}
                              </th>

                              <th class="px-4 py-2 text-sm font-semibold text-gray-600 text-center">
                                  {{__('mass-emails::menu.scheduled_table')}}
                              </th>

                              <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                                  ...
                              </th>
                          </tr>
                      </thead>

                      <tbody class="divide-y whitespace-nowrap">
                          @foreach ($results as $result)
                          <tr>
                              <td class="px-4 py-3">{{__('mass-emails::menu.draft_table')}}</td>
                              @if($send_type == "owners")
                              <td class="px-4 py-3">@if($recipients == "contact") {{$result->owners->comercial_email}} @else {{$result->owners->reservation_email}} @endif</td>
                              @else
                              <td class="px-4 py-3">@if($recipients == "contact") {{$result->owners->comercial_email}} @else {{$result->owners->reservation_email}} @endif</td>
                              @endif
                              <td class="px-4 py-3 text-center">{{$scheduled}}</td>
                              <td class="px-4 py-3"></td>
                          </tr>
                          @endforeach

                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
  </div>
</div>
