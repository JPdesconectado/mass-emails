<h3 class="font-bold text-2xl mb-8">{{__('mass-emails::menu.title')}}</h3>
                <div class="p-8 bg-gray-100">

                    <div
                        class="flex flex-col items-center justify-center max-w-md p-6 mx-auto space-y-6 text-center bg-white shadow rounded-2xl">
                        <div class="flex items-center justify-center w-16 h-16 text-blue-500 rounded-full bg-blue-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.94 6.412A2 2 0 002 8.108V16a2 2 0 002 2h12a2 2 0 002-2V8.108a2 2 0 00-.94-1.696l-6-3.75a2 2 0 00-2.12 0l-6 3.75zm2.615 2.423a1 1 0 10-1.11 1.664l5 3.333a1 1 0 001.11 0l5-3.333a1 1 0 00-1.11-1.664L10 11.798 5.555 8.835z" clip-rule="evenodd" />
                              </svg>
                        </div>

                        <header class="max-w-xs space-y-1">
                            <h2 class="text-sm font-medium text-gray-500 mb-4">{{__('mass-emails::menu.waiting_label')}}</h2>

                            <p class="text-sm font-medium text-gray-500">
                            {{__('mass-emails::menu.description_label')}}
                            </p>
                        </header>

                        <a
                            href = {{route('massmails.create')}}
                            class="inline-flex items-center justify-center h-8 px-3 text-sm font-semibold tracking-tight text-white transition bg-blue-600 rounded-lg shadow hover:bg-blue-500 focus:bg-blue-700 focus:outline-none focus:ring-offset-2 focus:ring-offset-blue-700 focus:ring-2 focus:ring-white focus:ring-inset"
                            type="button">
                            {{__('mass-emails::menu.add_btn')}}
                    </a>
                    </div>
                </div>

