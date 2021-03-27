<?php

namespace App\Imports;

use App\Submission;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Submission([
            'submission_id' => $row[1],
            'device_code' => $row[2],
            'ap_version' => $row[3],
            'modem_version' => $row[4],
            'csc_version' => $row[5],
            'total_csc' => $row[6],
            'approval_type' => $row[7],
            'reviewer' => $row[8],
            'pl_email' => $row[9],
            'first_model' => $row[10],
            'submit_date_time' => $row[13],
            // 'svmc_review_date' => $row[17],
            'svmc_review_status' => $row[17]
        ]);
    }
}
