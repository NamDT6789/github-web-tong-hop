<?php
namespace App\Imports;
use App\Submission;
use Carbon\Carbon;
use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToModel;
class ImportExcel implements  ToModel,WithStartRow
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
     * @return Submission
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
        // dd($col[1]);
        // convert Reviewer
        $r = 1;
        if($col[8] == 'phan.hue@samsung.com'){
            $r = 11;
        }else if($col[8] == 'ng.thanhtuan@samsung.com'){
            $r = 22;
        }else if($col[8] == 'vuong.hue@samsung.com'){
            $r = 33;
        }else if($col[8] == 'nong.thuy@samsung.com'){
            $r = 44;
        }else if($col[8] == 'dat.pt2@samsung.com'){
            $r = 55;
        }else if($col[8] == 'trung.nd3@samsung.com'){
            $r = 66;
        }else if($col[8] == 'oanh.lt@samsung.com'){
            $r = 77;
        }else if($col[8] == 'hoai.nt4@samsung.com'){
            $r = 88;
        }else if($col[8] == 'tu.nv1@samsung.com'){
            $r = 99;
        }else if($col[8] == 'huy.dn@samsung.com'){
            $r = 10;
        }else if($col[8] == 'nam.dt1@samsung.com'){
            $r = 12;
        }else if($col[8] == 'ninh.tn@samsung.com'){
            $r = 13;
        }else if($col[8] == 'ly.ltt@samsung.com'){
            $r = 14;
        }else if($col[8] == 'cong.ngm@samsung.com'){
            $r = 15;
        }else if($col[8] == 'thuynga.dt@samsung.com'){
            $r = 16;
        }else if($col[8] == 'mai.dth@samsung.com'){
            $r = 17;
        }else if($col[8] == 'diep.vtn@samsung.com'){
            $r = 18;
        }else if($col[8] == 'thang.dv@samsung.com'){
            $r = 19;
        }
        // Convert FM
        $fm = 1;
        if($col[0] == ''){
            $fm = 0;
        }else if($col[0] != ''){
            $fm = 1;
        }

        $fm_new = 0;
        // Convert SVMC Stt
        $svmc_proj = 1;
        if($col[9] == 'svmc.gba@samsung.com'){
            $svmc_proj = 1;
        }else if($col[9] != 'svmc.gba@samsung.com'){
            $svmc_proj = 0;
        }
        // Convert Stt
        $stt = 1;
        $gg_stt = 1;
        if($col[2] == 'Approved'){
            $stt = 1;
            $gg_stt = 1;           
        }else if($col[2] == 'Pending'){
            $stt = 2;     
            $gg_stt = 4;       
        }
        else if($col[2] == 'Reviewed'){
            $stt = 3;
            $gg_stt = 4;
        }
        else if($col[2] == 'Rejected'){
            $stt = 4;
            $gg_stt = 4;
        }
        else if($col[2] == 'Cancelled'){
            $stt = 5;
            $gg_stt = 4;
        }
        // Convert progess
        $progress = 1;
        if($gg_stt != 1){
            $progress = 2;
        }else{
            $progress = 1;
        }
        //Convert CSC Ver
        $csc_ver = 'a';
        if($col[13] ==''){
            $csc_ver = 'input CSC version';
        }else{
            $csc_ver = $col[13];
        }
        //Convert Modem ver
        $modem_ver = 'a';
        if($col[9] ==''){
            $modem_ver = 'input Modem version';
        }else{
            $modem_ver = $col[9];
        }
        
        // $getweek = date("y-m-d h:i:s", strtotime($col[2]));

        $getweek =  date("y-m-d h:i:s", strtotime(strtr($col[10],'/', '-')));

        // W21 convert updated
        $modem_ver_new ='input Modem version';
        $csc_ver_new = 'input CSC version';
        
       
        return new Submission([
            // 'submission_id' => number_format($col[1],0,'.',''),
            'submission_id' => number_format($col[0],0,'.',''),
            'submit_date_time' => date("y-m-d h:i:s", strtotime(strtr($col[10],'/', '-'))),
            'svmc_review_date' => date("y-m-d h:i:s", strtotime(strtr($col[10],'/', '-'))),

            // 'submit_date_time' => date("y/d/m h:i:s", strtotime($col[10])),
            // 'svmc_review_date' => date("y/d/m h:i:s", strtotime($col[10])),



            'ap_version' => $col[5],
            'device_code' => $col[13],
            // 'csc_version' => $col[10],
            'csc_version' => $csc_ver_new,
            'total_csc' => 1,
            'reviewer' => $r,
            'svmc_review_status' => $stt,
            'google_review_status' => $gg_stt,
            'progress' => $progress,
            'pl_email' => $col[15],
            'first_model' => $fm_new,
            // 'first_model' => intval($col[10]),
            // 'modem_version' => $col[9],
            'modem_version' => $modem_ver_new,
            'approval_type'=> $col[1],
            'svmc_project' =>  $svmc_proj ,
            'week' => Submission::getWeek($getweek)
            
            // 'svmc_review_status' => $col[17]
        ]);

        //
    }
    

}