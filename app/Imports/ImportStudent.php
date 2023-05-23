<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportStudent implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // CUSTOMIZATION ROW ON EXCEL
        return new Student([
            'student_name' => $row[0],
            'student_email' => $row[1],
            'address' => $row[2],
            'study_course' => $row[3],
        ]);
    }
}
