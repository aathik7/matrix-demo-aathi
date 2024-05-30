<?php

namespace App\Services;

use App\Imports\EmployeeImport;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeService
{
    protected Employee $employee;
    protected const INACTIVE_FLAG = 0;

    /**
     * EmployeeService's Constructor
     *
     */
    function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Fetch Employee details from database
     * @return mixed
     */
    public function getEmployeeList(): mixed
    {
        return $this->employee->orderByDesc('active_flag')->orderByDesc('created_at')->get(['id', 'name', 'email', 'contact', 'designation', 'active_flag']);
    }

    /**
     * Fetch Inventory details from database
     * @return mixed
     */
    public function getEmployeeDetails(): mixed
    {
        return User::where('id', Auth::user()->id)->first(['id', 'name', 'user_type']);
    }

    /*
     * Create new Employee
     *
     * @param $input
     * @return Status
     */
    public function store($input)
    {
        try {
            $this->employee->create($input);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /*
     *
     * @param $input
     * @return Status
     */
    public function update($input)
    {
        try {
            $this->employee->where('id', $input['id'])->update([
                'name' => $input['name'],
                'email' => $input['email'],
                'contact' => $input['contact'],
                'designation' => $input['designation'],
                'city' => $input['city']
            ]);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /*
     *
     * @param  $request
     * @return Status
     */
    public function destroy($request)
    {
        $this->employee->where('id', $request['id'])->update(['active_flag' => self::INACTIVE_FLAG, 'deleted_at' => Carbon::now()]);
    }

    /**
     * Fetch Employee details from database
     * @param $id
     * @return mixed
    */
    public function getDetails($id): mixed
    {
        return $this->employee->where('id', $id)->first(['id', 'name', 'email', 'contact', 'designation', 'city', 'active_flag']);
    }

    /**
     * @param $request
     * @return mixed
    */
    public function search($request)
    {
        $output = '';
        $employees = $this->employee->where('name','LIKE','%'.$request['key']."%")->get(['id', 'name', 'email', 'contact', 'designation', 'city', 'active_flag'])->toArray();
        if(!empty($employees)) {
            foreach ($employees as $key => $employee) {
                $status = $employee["active_flag"] ? "Active" : "Inactive";
                $output.= '<tr ';
                $output.= '>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    '.$employee['name'].'
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    '.$employee['email'].'
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                '.$employee['contact'].'
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                '.$employee['designation'].'
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                '.$status.'
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="/employee/edit/'.$employee['id'].'" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Edit</a>';
                $output.= '<a data-toggle="modal" onclick="enablePopup('.$employee['id'].')  class="text-red-600 hover:text-red-900 mb-2 mr-2 deleteBtn" name="deleteBtn" title="Delete Item">Delete</a></td></tr>';
            }
        }
        return Response($output);
    }

    /**
     * Upload Employee details to database
     * @param $file
     * @return void
    */
    public function employeeUpload($file): void
    {
        Excel::import(new EmployeeImport, $file);
    }
}
