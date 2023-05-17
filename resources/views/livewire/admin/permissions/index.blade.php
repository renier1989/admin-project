<div>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-2">
                <div class="p-2 bg-green-500 text-white hover:bg-green-400 trastition duration-500 rounded-md cursor-pointer">
                    Create Permission
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul role="list" class="divide-y divide-gray-100">
                        @forelse ($permissions as $permission)
                        <li class="flex justify-between gap-x-6 py-5 items-center">
                            <div class="flex gap-x-4">
                                {{-- <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                    src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt=""> --}}
                                <div class="min-w-0 flex-auto">
                                    <p class="text-2xl font-semibold leading-6 text-gray-900">{{$permission->name}}</p>
                                    {{-- <p class="mt-1 truncate text-xs leading-5 text-gray-500">dries.vincent@example.com --}}
                                    </p>
                                </div>
                            </div>
                            <div class="hidden sm:flex sm:flex-col sm:items-end">
                                <div class="flex space-x-1 mb-2">
                                    <span class="px-2 py-1 rounded-md bg-green-500 font-semibold text-white cursor-pointer hover:bg-green-700 transition duration-500">
                                        Edit
                                    </span>
                                    <span class="px-2 py-1 rounded-md bg-red-500 font-semibold text-white cursor-pointer hover:bg-red-700 transition duration-500">
                                        Delete
                                    </span>
                                </div>
                                {{-- <p class="text-sm leading-6 text-gray-900">Business Relations</p> --}}
                                <div class="mt-1 flex items-center gap-x-1.5">
                                    <div class="flex-none rounded-full bg-emerald-500/20 p-1">
                                        <div class="h-1.5 w-1.5 rounded-full bg-emerald-500"></div>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-500">Active</p>
                                </div>
                            </div>
                        </li>
                        @empty
                        <div class="flex justify-center font-semibold text-2xl text-slate-500">
                            Can't find results to show right now!
                        </div>
                        @endforelse
                    </ul>

                    
                </div>
            </div>
        </div>
    </div>
</div>