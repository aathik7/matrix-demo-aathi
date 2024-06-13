<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class EmployeeController extends Controller
{
    protected EmployeeService $employeeService;
    protected const ACTIVE_FLAG = 1;

    /**
     * EmployeeController's Constructor
     * 
     * @param EmployeeService $employeeService
     */
    function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = $this->employeeService->getEmployeeList();
        return view('employee.index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create', ['title' => 'Create Employee']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'contact' => 'required|string|max:10|unique:employees,contact',
            'designation' => 'required|string',
            'city' => 'string'
        ]);
        if ($validator->fails()) {
            return Redirect::route('employee.index')->withErrors($validator);
        }
        $this->employeeService->store($request->all());
        return redirect()->route('employee.index')->with('success','Employee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     */
    public function edit(string $id)
    {
        $employeeDetails = $this->employeeService->getDetails($id);
        return view('employee.edit', ['employee' => $employeeDetails, 'title' => 'Edit Employee']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'email' => 'required|email',
            'contact' => 'required|string|max:10',
            'designation' => 'required|string',
            'city' => 'string'
        ]);
        if ($validator->fails()) {
            return Redirect::route('employee.index')->withErrors($validator);
        }
        $this->employeeService->update($request->all());
        return redirect()->route('employee.index')->with('success','Employee Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Log::info($request->all());
        $validator = Validator::make($request->all(), ['id' => 'required']);
        if ($validator->fails()) {
            return Redirect::route('employee.index')->withErrors($validator);
        }
        $this->employeeService->destroy($request->all());
        return redirect()->route('employee.index')->with('success','Employee Deleted successfully.');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        return $this->employeeService->search($request->all());
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if (Auth::check()) {
            $employeeDetails = Employee::orderByDesc('active_flag')->orderByDesc('created_at')->get(['id', 'name', 'email', 'designation', 'active_flag'])->toArray();
            return view('dashboard', ['i' => 1, 'employeeDetails' => $employeeDetails]);
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function employeeExport()
    {
        if (Auth::check()) {
            return Excel::download(new EmployeeExport, 'employee'. time() .'.xlsx');
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function employeeImport()
    {
        if (Auth::check()) {
            return view('employee.employee-upload', ['title' => 'Employee Import']);
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * @return BinaryFileResponse
     */
    public function templateDownload()
    {
        $fileUrl = public_path('assets/docs/template.xlsx');
        return Response::download($fileUrl, 'template.xlsx');
    }

    /**
     * Write code on Method
     * @param Request $request
     * @return response()
     */
    public function employeeUpload(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {
                return Redirect::route('employee.index')->withErrors($validator);
            }
            $file = $request->file('file');
            $this->employeeService->employeeUpload($file);
            return Redirect::route('employee.index');
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
}
