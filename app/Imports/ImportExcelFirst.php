<?php
namespace App\Imports;
use App\FirstModel;
use Carbon\Carbon;
use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToModel;
class ImportExcelFirst implements  ToModel,WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
    /**
     * @param array $col
     * @return FirstModel
     */

     
     /**
     * @return int
     */

    public function startRow(): int
    {
        return 2;
    }


    public function model(array $col)
    {
        // Convert STT
        $stt = 1;
        if($col[11] == 'Approved'){
            $stt = 7;          
        }else if($col[11] == 'Pending'){
            $stt = 3;          
        }
        else if($col[11] == 'Reviewed'){
            $stt = 4;
        }
        else if($col[11] == 'Rejected'){
            $stt = 6;
        }
        else if($col[11] == 'Cancelled'){
            $stt = 5;
        }

        return new FirstModel([
            'submission_id' => number_format($col[1],0,'.',''),
            'device_code' => $col[4],
            'model_name' => $col[4],
            'sale_code'=> $col[5],
            'status' => $stt
        ]);

        //
    }
    

}