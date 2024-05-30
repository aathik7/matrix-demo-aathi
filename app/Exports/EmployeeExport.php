<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('employees')
        ->select(DB::raw("name, email, contact, designation, CASE WHEN active_flag = 1 THEN 'Active' ELSE 'Inactive' END"))
        ->get();Employee::all();
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return ['Name', 'Email', 'Contact', 'Designation', 'Status'];
    }
}
