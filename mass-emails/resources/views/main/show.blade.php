@extends('layouts.app')

@section('content')

<div class="mx-auto px-4 sm:px-6 lg:px-12" x-data="{isOpen:false}">
  <div class="p-6">
    <div class="-mx-12 overflow-x-auto">
        <div class="inline-block min-w-full px-4">
            <div class="overflow-hidden bg-white shadow rounded-xl">
                <div class="p-2 grid grid-cols-2 gap-4 bg-gray-200">
                    <div class="space-y-2">
                        <h4 class='py-2 px-4 font-nunito text-lg font-bold'>{{__('mass-emails::transaction.sent_emails')}}</h4>
                    </div>
                    <div class="space-y-2  text-right">
                      <a
                      href = {{route('massmails.index')}}
                      class="mt-2 mr-2 cursor-pointer inline-flex items-center justify-center h-8 px-3 text-sm font-semibold tracking-tight text-white transition bg-blue-400 rounded-lg shadow hover:bg-blue-500 focus:bg-blue-700 focus:outline-none focus:ring-offset-2 focus:ring-offset-blue-700 focus:ring-2 focus:ring-white focus:ring-inset"
                      type="button"><i class="fas fa-plane-departure mr-2"></i>  {{__('mass-emails::transaction.return_btn')}} </a>
              </div>
                </div>
                <table class="w-full text-left divide-y table-auto">
                  <thead>
                      <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.id')}}
                        </th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.destination_email')}}
                        </th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.sender_option')}}
                        </th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.subject')}}
                        </th>

                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.message')}}
                        </th>

                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                          {{__('mass-emails::transaction.status')}}
                        </th>

                      </tr>
                  </thead>

                  <tbody class="divide-y whitespace-nowrap">
                      @foreach ($email_transaction_items as $items)
                      <tr>
                        <td class="px-4 py-3">{{$items->id}}</td>
                        <td class="px-4 py-3">{{$items->destination_email}}</td>
                        <td class="px-4 py-3">{{($items->sent)}}</td>
                        <td class="px-4 py-3">{{$items->subject}}</td>
                        <td class="px-4 py-3">{{substr($items->message, 0, 50)}}...</td>
                        <td class="px-4 py-3">{{$items->status}}</td>

                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>

@endsection
