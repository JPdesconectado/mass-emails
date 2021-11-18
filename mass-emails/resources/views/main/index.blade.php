@extends("layouts.app")

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-12" x-data="{isOpen:false}">
  @if (session()->has('message'))
        <div class="mt-4">
          <p class="relative text-center px-3 py-3 border rounded bg-green-200 border-green-300 text-green-800">{{session('message')}}</p>
        </div>
  @endif
@if(!$showEmptyState)

<div class="p-6">
  <div class="-mx-12 overflow-x-auto">
      <div class="inline-block min-w-full px-4">
          <div class="overflow-hidden bg-white shadow rounded-xl">
              <div class="p-2 grid grid-cols-2 gap-4 bg-gray-200">
                  <div class="space-y-2">
                      <h4 class='py-2 px-4 font-nunito text-lg font-bold'>{{__('mass-emails::transaction.title')}}</h4>
                  </div>
                  <div class="space-y-2  text-right">
                          <a
                          href = {{route('massmails.create')}}
                          class="mt-2 mr-2 cursor-pointer inline-flex items-center justify-center h-8 px-3 text-sm font-semibold tracking-tight text-white transition bg-blue-400 rounded-lg shadow hover:bg-blue-500 focus:bg-blue-700 focus:outline-none focus:ring-offset-2 focus:ring-offset-blue-700 focus:ring-2 focus:ring-white focus:ring-inset"
                          type="button"><i class="fas fa-plane-departure mr-2"></i>  {{__('mass-emails::transaction.add_btn')}} </a>
                  </div>
              </div>
              <table class="w-full text-left divide-y table-auto">
                  <thead>
                      <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.id')}}
                        </th>

                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.identification_code')}}
                        </th>

                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.admin_id')}}
                        </th>

                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.status')}}
                        </th>

                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.actions')}}
                        </th>
                      </tr>
                  </thead>

                  <tbody class="divide-y whitespace-nowrap">
                      @foreach ($email_transaction as $transaction)
                      <tr>
                        <td class="px-4 py-3">{{$transaction->id}}</td>
                        <td class="px-4 py-3">{{$transaction->token}}</td>
                        <td class="px-4 py-3">{{$transaction->admin_name}}</td>
                        <td class="px-4 py-3">{{$transaction->status}}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('massmails.show', [$transaction->id]) }}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                              </svg>
                            </a>
                        </td>

                      </tr>
                      @endforeach

                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
@else
    @include('mass-emails::main.emptystate')
@endif
</div>
@endsection


