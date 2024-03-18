<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
/* used for chainging ($import = new UserImport();$import->import($request->file('excel'));) */
use Maatwebsite\Excel\Concerns\Importable;
/* both works as a pair */
use Maatwebsite\Excel\Concerns\{SkipsFailures, SkipsOnFailure};
use Maatwebsite\Excel\Concerns\{SkipsErrors, SkipsOnError};

class UserImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
           'name'     => $row['name'],
           'email'    => $row['email'],
           'password' => bcrypt($row['password']),
        ]);
    }


    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required','unique:users,email'],
            'password' => ['required'],
        ];
    }
}