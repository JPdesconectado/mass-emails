
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0 mx-auto bg-white">
            <h3 class="font-bold text-3xl px-8 py-4">{{__('mass-emails::menu.title')}}</h3>

            <div class="grid grid-cols-5">
                <a  class="text-md text-gray-700   text-center  mx-8 my-4  @if($pageForm === 0)text-blue-600    border-b border-blue-600 @endif">{{__('mass-emails::menu.btn_send')}}</a>

                <a  class="text-md text-gray-700   text-center  mx-8 my-4  @if($pageForm === 1 || $pageForm === 2)text-blue-600    border-b border-blue-600 @endif">{{__('mass-emails::menu.btn_filter')}}</a>

                <a  class="text-md text-gray-700   text-center  mx-8 my-4  @if($pageForm === 3)text-blue-600    border-b border-blue-600 @endif"> {{__('mass-emails::menu.btn_submission')}}</a>

                <a  class="text-md text-gray-700   text-center  mx-8 my-4  @if($pageForm === 4)text-blue-600    border-b border-blue-600 @endif"> {{__('mass-emails::menu.btn_recipients')}}</a>

                <a  class="text-md text-gray-700   text-center  mx-8 my-4  @if($pageForm === 5)text-blue-600    border-b border-blue-600 @endif"> {{__('mass-emails::menu.btn_summary')}}</a>

            </div>

            <form wire:submit.prevent="submit">
                @csrf

                <div class="overflow-hidden sm:rounded-md">
                    <div class="px-4 bg-white sm:p-6">



                        @includeWhen($pageForm === 0, 'mass-emails::livewire.mass-email-pages.email-submission-type')


                        @includeWhen($pageForm === 1,'mass-emails::livewire.mass-email-pages.email-filter')

                        @includeWhen($pageForm === 2,'mass-emails::livewire.mass-email-pages.added-filters')

                        @includeWhen($pageForm === 3,'mass-emails::livewire.mass-email-pages.write-email')



                        @includeWhen($pageForm === 4,'mass-emails::livewire.mass-email-pages.choose-recipients')



                        @includeWhen($pageForm === 5,'mass-emails::livewire.mass-email-pages.summary-and-confirmation')












                        <div class="mt-5 text-center sm:px-6">
                            <button wire:click="submit" type="button" class="ml-auto mr-0 inline-flex justify-center py-2 px-20 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600  focus:outline-none hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                              {{__('mass-emails::menu.next')}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

