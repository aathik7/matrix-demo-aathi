<x-app-layout>
@include('flash-message')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{__('Employee')}} 
        </h2>
    </x-slot>

    <div>
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            <form class="flex items-center" action="{{ route('employee.index') }}" method="get">  
                <div>
                     <input type="text" autocomplete="off" id="searchItem"  class="form-input rounded-md shadow-sm mt-1 block w-full" name="filter[search]" placeholder="Search" value="{{request()->get('filter[search]')}}">
                </div> 
                <div>
                    <input type="submit"  value="Reset" class="ml-6 cursor-pointer">
                </div>
            </form>
              
            <div>
                <div class="row">
                    <div class="block col-md-1 mb-4 flex items-center justify-end">
                        <a href="{{ route('employee.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        {{__('Add Employee')}} </a>
                    </div>
                </div>
                <div class="row col-md-2">
                    <div class="block col-md-1 mb-4 flex items-center justify-end">
                        <a href="{{ route('employee.report') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        {{__('Employee Report')}} </a>
                    </div>
                    <div class="block col-md-1 flex items-center justify-end">
                        <a href="{{ route('employee.import') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        {{__('Employee Import')}} </a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-8 min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs uppercase tracking-wider">
                                        {{__('Name')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs uppercase tracking-wider">
                                        {{__('Email')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs uppercase tracking-wider">
                                        {{__('Contact')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs uppercase tracking-wider">
                                        {{__('Designation')}}
                                    </th>
                                    <th scope="col" width="200" class="px-6 py-3 bg-gray-50 text-left text-xs uppercase tracking-wider">
                                        {{__('Status')}}
                                    </th>
                                    <th scope="col" width="200" class="px-6 py-3 bg-gray-50 text-left text-xs uppercase tracking-wider">
                                        {{__('Actions')}}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $employee->name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $employee->email }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $employee->contact }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $employee->designation }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $employee->active_flag == 1 ? 'Active' : 'Inactive' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('employee.edit', $employee->id) }}" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Edit</a>
                                            <a data-toggle="modal" data-id="{{ $employee->id }}" onclick="enablePopup('{{ $employee->id }}')"  class="text-red-600 hover:text-red-900 mb-2 mr-2 deleteBtn" name="deleteBtn" title="Delete Item">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                </table>
                               
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <form action="{{ route('employee.destroy', '$item->id') }}" method="post">
                                        <input id="id" name="itemId" type="hidden">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span hidden="true close-btn">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            @csrf
                                            @method('DELETE')
                                                <p>Are you sure you want to delete this company?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-500 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 close-btn" 
                                                 data-dismiss="modal">Close</button>
                                                <button type="submit" class="inline-flex items-center px-4 py-2 mr-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"> Delete</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    function enablePopup(itemId) {
        if (confirm('Are you sure you want to delete this item from the database?')) {
            $.ajax({
                type: "POST",
                url: "/employee/destroy",
                data: '_token=<?php echo csrf_token() ?>&id='+ itemId,
                
                success: function(data) {
                    alert('Item Deleted');
                    window.location.href = "/employee/index";
                }
            });
        }
    }

    $('#searchItem').on('keyup',function() {
        value = $(this).val();
        $.ajax({
            type: 'GET',
            url: 'search',
            data: '_token=<?php echo csrf_token() ?>'+'&key='+value,
            success:function(data){
                $('tbody').html(data);
            }
        });
    });
</script>


