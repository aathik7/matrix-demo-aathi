<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeeImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $i = 0;
        foreach ($rows as $row)
        {
            if ($i != 0 && !empty($row[0])) {
                $employeeCount = Employee::where('email', $row[1])->orWhere('contact', $row[2])->count();
                if ($employeeCount == 0) {
                    Employee::create([
                        'name' => $row[0],
                        'email' => $row[1],
                        'contact' => $row[2],
                        'designation' => $row[3],
                        'city' => $row[4],
                    ]);
                }
            }
            $i++;
        }
    }
}
