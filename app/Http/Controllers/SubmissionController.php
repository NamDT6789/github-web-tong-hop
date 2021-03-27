<?php

namespace App\Http\Controllers;

use App\Exports\Export;
use App\Imports\ImportExcel;
use App\Submission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use DateTime;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class SubmissionController extends Controller
{
    const FILE_NAME = 'Submission.xlsx';
    const SUBMITTED = 'Submitted';
    const PENDING = 'Pending';
    const REVIEW = 'Reviewed';
    const REJECT = 'Rejected';

    const TYPE_REGULAR = 'Regular';
    const TYPE_NORMAL = 'NormalException';
    const TYPE_SMR = 'SMR';

    public function dashboard()
    {
        $user = Auth::user();
        $user_name = $user['name'];
        $reviewer = Submission::getReviewer();

        return view('dashboard.dashboard', compact('user_name', 'reviewer'));
    }

    public function getDataYear()
    {
        $date = Carbon::now();
        [$data_regular_year, $data_normal_year, $data_smr_year] = $this->getDataOfYear($date);
        $year_X = array_keys($data_regular_year);
        $regular_year_Y = array_values($data_regular_year);
        $normal_year_Y = array_values($data_normal_year);
        $smr_year_Y = array_values($data_smr_year);

        return response()->json([
            'year_X' => $year_X,
            'regular_year_Y' => $regular_year_Y,
            'normal_year_Y' => $normal_year_Y,
            'smr_year_Y' => $smr_year_Y,
        ]);
    }

    public function getDataDashboard(Request $request)
    {
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $reviewer = $request['reviewer'];

        [$data_regular_week, $data_normal_week, $data_smr_week, $response] = $this->getDataOfWeek(Submission::getWeek($request['start_date']), Submission::getWeek($request['end_date']), $reviewer);
        [$data_regular_month, $data_normal_month, $data_smr_month] = $this->getDataOfMonth($start_date, $end_date, $reviewer);
        $week_X = array_keys($data_regular_week);
        $regular_week_Y = array_values($data_regular_week);
        $normal_week_Y = array_values($data_normal_week);
        $smr_week_Y = array_values($data_smr_week);
        $month_X = array_keys($data_regular_month);
        $regular_month_Y = array_values($data_regular_month);
        $normal_month_Y = array_values($data_normal_month);
        $smr_month_Y = array_values($data_smr_month);
        return response()->json([
            'week_X' => $week_X,
            'regular_week_Y' => $regular_week_Y,
            'normal_week_Y' => $normal_week_Y,
            'smr_week_Y' => $smr_week_Y,
            'month_X' => $month_X,
            'regular_month_Y' => $regular_month_Y,
            'normal_month_Y' => $normal_month_Y,
            'smr_month_Y' => $smr_month_Y,
            'data' => $response
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $user_name = $user['name'];
        $total = isset($_GET['total']) ? intval($_GET['total']) : 10;
        $svmc_review_status = Submission::getSvmcStatus();
        $progress = Submission::getProgressStatus();
        $reviewer = Submission::getReviewer();
        $google_review_status = Submission::getGoogleStatus();
        $items = Submission::query()->select([
            'id', 'submission_id', 'device_code', 'ap_version', 'modem_version', 'csc_version', 'total_csc', 'approval_type', 'reviewer', 'pl_email', 'first_model', 'svmc_project', 'submit_date_time', 'svmc_review_date', 'urgent_mark', 'svmc_review_status', 'svmc_comment', 'progress', 'google_review_status', 'week'
        ])->orderByDesc('id')->paginate($total);
        $countTotal = $items->total();
        $submission = $this->getResponse($items);
        return view('submission.index', compact('items', 'submission', 'svmc_review_status', 'progress', 'google_review_status', 'reviewer', 'countTotal', 'user_name'));
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrUpdate(Request $request, $id = null)
    {
        if ($id) {
            $submission = Submission::find($id);
            $check = Submission::query()->where('submission_id', $request['submission_id'])->where('id', '!=',$id)->first();
            $message = 'Update Submission success';
        } else {
            $submission = new Submission();
            $check = Submission::query()->where('submission_id', $request['submission_id'])->first();
            $message = 'Create Submission success';
        }
        if ($check) {
            $message = 'Submission da ton tai';
            return response()->json([
                'message' => $message
            ]);
        }
        $params = $request->request->all();
        $submission->submission_id = $params['submission_id'];
        $submission->device_code = $params['device_code'];
        $submission->ap_version = $params['ap_version'];
        $submission->modem_version = $params['modem_version'];
        $submission->csc_version = $params['csc_version'];
        $submission->total_csc = $params['total_csc'];
        $submission->approval_type = $params['approval_type'];
        $submission->reviewer = $params['reviewer'];
        $submission->pl_email = $params['pl_email'];
        $submission->first_model = $params['first_model'];
        $submission->svmc_project = $params['svmc_project'];
        $submission->submit_date_time = isset($params['date_submit']) ? $params['date_submit'] : Carbon::now();
        $submission->svmc_review_date = isset($params['date_review']) ? $params['date_review'] : Carbon::now();
        $submission->urgent_mark = $params['urgent_mark'];
        $submission->week = isset($params['week']) ? $params['week']: (isset($params['date_review']) ? Submission::getWeek($params['date_review']) : 0);
        $submission->svmc_review_status = $params['svmc_review_status'];
        $submission->progress = $params['progress'];
        $submission->google_review_status = $params['google_review_status'];
        $submission->svmc_comment = $params['svmc_comment'];
        if ($submission->save()) {
            return response()->json([
                'status' => 200,
                'message' => $message
            ]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id)
    {
        $submissionId = Submission::find($id);
        return response()->json($submissionId);
    }

    /**
     * @param null $time
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel($time = null)
    {
        $fileName = self::FILE_NAME;
        $export = new Export;
        $export->setTime($time);
        $binaryFileResponse = Excel::download($export, $fileName);
        return $binaryFileResponse;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function importExcel(Request $request)
    {
        try {
            $items = Excel::toArray(new ImportExcel(), $request->file('files'));
            foreach ($items[0] as $item) {

                $submission = new Submission();
                $total_csc = isset($item['carrier']) ? $this->getTotalCsc($item['carrier']) : 0;
                $first_model = isset($item['fm']) ? $this->getFirstModel($item['fm']) : '';
                $submit_date_time = isset($item['log']) ? $this->getDate($item['log'], $type = 'Submit') : '';
                $svmc_review_date = isset($item['log']) ? $this->getDate($item['log'], $type = 'Review') : '';
                $svmc_review_status = isset($item['status']) ? Submission::getKeySvmcStatus($item['status']) : 0;
                $reviewer = isset($item['reviewer']) ? Submission::getKeyReviewer($item['reviewer']) : '';
                $week = isset($submit_date_time) ? Submission::getWeek($submit_date_time) : 0;

                $submission->submission_id = isset($item['submission_id']) ? $item['submission_id'] : '';
                $submission->device_code = isset($item['device_code']) ? $item['device_code'] : '';
                $submission->ap_version = isset($item['fingerprint']) ? $this->getApVersion($item['fingerprint']) : '';
                $submission->modem_version = isset($item['modem_version']) ? $item['modem_version'] : '';
                $submission->csc_version = isset($item['csc_version']) ? $item['csc_version'] : '';
                $submission->total_csc = $total_csc;
                $submission->approval_type = isset($item['approval_type']) ? $item['approval_type'] : '';
                $submission->reviewer = $reviewer[0];
                $submission->pl_email = isset($item['sw_pl_email']) ? $item['sw_pl_email'] : '';
                $submission->first_model = $first_model;
                $submission->svmc_project = 0;
                $submission->submit_date_time = $submit_date_time;
                $submission->svmc_review_date = $svmc_review_date;
                $submission->urgent_mark = 0;
                $submission->week = $week;
                $submission->svmc_review_status = $svmc_review_status[0];
                $submission->svmc_comment = isset($item['comments']) ? $item['comments'] : '';
                $submission->progress = 0;
                $submission->google_review_status = 0;
                $submission->save();
            }
        } catch (\Exception $e) {
            print ($e);
        }
        return redirect('/submission');
    }

    /**
     * @param $carrier
     * @return int
     */
    protected function getTotalCsc($carrier)
    {
        $total = 0;
        if ($carrier) {
            $total = count(explode(',', $carrier));
        }
        return $total;
    }

    /**
     * @param $fm
     * @return int
     */
    protected function getFirstModel($fm)
    {
        $first_model = 1;
        if ($fm == 'No') {
            $first_model = 0;
        }
        return $first_model;
    }

    /**
     * @param $log
     * @param $type
     * @return null|string
     */
    protected function getDate($log, $type)
    {
        $items_temp = preg_split('/\r\n|\r|\n/', $log);
        $date_time = null;
        foreach ($items_temp as $items) {
            $temp = explode(' ', $items);
            if ($type == 'Submit') {
                if ($temp[4] == self::SUBMITTED) {
                    $date_time = $temp[1] . ' ' . $temp[2];
                    break;
                }
            }
            if ($type == 'Review') {
                if ($temp[4] == self::PENDING || $temp[4] == self::REVIEW || $temp[4] == self::REJECT) {
                    $date_time = $temp[1] . ' ' . $temp[2];
                    break;
                }
            }
        }
        return $date_time;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Submission::query()->where('id', $id)->delete();
        return response()->json([
            'status' => 200
        ]);
    }

    /**
     * @param $items
     * @return array
     */
    protected function getResponse($items)
    {
        $submission = [];
        if ($items) {
            foreach ($items as $item) {
                $submission[] = [
                    'id' => $item['id'],
                    'submission_id' => $item['submission_id'],
                    'device_code' => $item['device_code'],
                    'ap_version' => $item['ap_version'],
                    'modem_version' => $item['modem_version'],
                    'csc_version' => $item['csc_version'],
                    'total_csc' => $item['total_csc'],
                    'approval_type' => $item['approval_type'] === 'Regular' ? 'Regular' : ($item['approval_type'] === 'NormalException' ? 'NormalException' : 'SMR'),
                    'reviewer' => Submission::getValueReviewer($item['reviewer']),
                    'pl_email' => $item['pl_email'],
                    'first_model' => $item['first_model'] === 1 ? 'Yes' : 'No',
                    'svmc_project' => Submission::getTrueFalse($item['svmc_project']),
                    'week' => $item['week'],
                    'date_submit' => Submission::getDate($item['submit_date_time']),
                    'time_submit' => Submission::getTime($item['submit_date_time']),
                    'date_review' => Submission::getDate($item['svmc_review_date']),
                    'urgent_mark' => Submission::getTrueFalse($item['urgent_mark']),
                    'svmc_review_status' => Submission::getValueSvmcStatus($item['svmc_review_status']),
                    'progress' => Submission::getValueProgressStatus($item['progress']),
                    'google_review_status' => Submission::getValueGoogleStatus($item['google_review_status']),
                    'svmc_comment' => $item['svmc_comment'],
                ];
            }
        }
        return $submission;
    }

    protected function getApVersion($fingerprint)
    {
        $items = explode('/', $fingerprint);
        $ap_version = explode(':', $items[4]);

        return $ap_version[0];
    }

    protected function getDataOfWeek(int $week_start, int $week_end, $reviewer = null)
    {
        $data_regular_week = [];
        $data_normal_week = [];
        $data_smr_week = [];
        $data = [];
        $types = [self::TYPE_REGULAR, self::TYPE_NORMAL, self::TYPE_SMR];
        foreach ($types as $type) {
            for ($week = $week_start; $week <= $week_end; $week++) {
                $count = 0;
                $items = DB::table('submission')
                    ->where('week', '=', $week)
                    ->where('approval_type', $type)
                    ->select( DB::raw('COUNT(*) as count'));
                    if($reviewer != ''){
                        $items = $items->where('reviewer', $reviewer);
                    }
                    $items =$items
                    ->groupBy('week')
                    ->orderBy('week')
                    ->get()->toArray();
                if (count($items) > 0) {
                    $count = $items[0]->count;
                }
                $data['Week '.$week] = $count;
            }
            if ($type == self::TYPE_REGULAR) {
                $data_regular_week = $data;
            }
            if ($type == self::TYPE_NORMAL) {
                $data_normal_week = $data;
            }
            if ($type == self::TYPE_SMR) {
                $data_smr_week = $data;
            }
        }
        $response = $this->getDataSubmission($week_start, $week_end);
        return [$data_regular_week, $data_normal_week, $data_smr_week, $response];
    }

    protected function getDataOfMonth($start_date, $end_date, $reviewer = null)
    {
        $month_start = date('m', strtotime($start_date));
        $month_end = date('m', strtotime($end_date));
        $data_regular_month = [];
        $data_normal_month = [];
        $data_smr_month = [];
        $data = [];
        $types = [self::TYPE_REGULAR, self::TYPE_NORMAL, self::TYPE_SMR];
        foreach ($types as $type) {
            for ($month = $month_start; $month <= $month_end; $month++) {
                $count = 0;
                $items = DB::table('submission')
                    ->where('approval_type', $type)
                    ->select(DB::raw('MONTH(submit_date_time) as month'), DB::raw('COUNT(*) as count'))
                    ->whereMonth('submit_date_time', '=', $month);
                if ($month == $month_end) {
                    $items = $items->where('submit_date_time', '<=', $end_date);
                }
                if($reviewer != null){
                    $items = $items->where('reviewer', $reviewer);
                }
                $items = $items
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get()->toArray();
                if (count($items) > 0) {
                    $count = $items[0]->count;
                }
                $data['Month '.$month] = $count;
            }
            if ($type == self::TYPE_REGULAR) {
                $data_regular_month = $data;
            }
            if ($type == self::TYPE_NORMAL) {
                $data_normal_month = $data;
            }
            if ($type == self::TYPE_SMR) {
                $data_smr_month = $data;
            }
        }
        return [$data_regular_month, $data_normal_month, $data_smr_month];
    }

    protected function getDataOfYear($date)
    {
        $year_now = date('Y', strtotime($date));
        $year_old = $year_now - 1;
        $start_date = date('Y-m-d 00:00:00', strtotime($date));
        $data_regular_year = [];
        $data_normal_year = [];
        $data_smr_year = [];
        $data = [];
        $types = [self::TYPE_REGULAR, self::TYPE_NORMAL, self::TYPE_SMR];
        foreach ($types as $type) {
            for($year = $year_old; $year<=$year_now; $year++){
                $count = 0;
                $items = DB::table('submission')
                    ->where('approval_type', $type)
                    ->select(DB::raw('YEAR(submit_date_time) as year'), DB::raw('COUNT(*) as count'))
                    ->whereYear('submit_date_time', '=', $year)
                    ->where('submit_date_time' , '<=', $start_date)
                    ->groupBy('year')
                    ->orderBy('year')
                    ->get()->toArray();
                if (count($items) > 0) {
                    $count = $items[0]->count;
                }
                $data['Year '.$year] = $count;
            }
            
            if ($type == self::TYPE_REGULAR) {
                $data_regular_year = $data;
            }
            if ($type == self::TYPE_NORMAL) {
                $data_normal_year = $data;
            }
            if ($type == self::TYPE_SMR) {
                $data_smr_year = $data;
            }
        }
        return [$data_regular_year, $data_normal_year, $data_smr_year];
    }

    protected function getDataSubmission($week_start, $week_end)
    {
        $response = [];
        $items = DB::table('submission')
            ->where('week', '>=', $week_start)
            ->where('week', '<=', $week_end)
            ->whereIn('svmc_review_status',[Submission::STATUS_PENDING,Submission::STATUS_REJECTED])
            ->select('id','submission_id', 'ap_version', 'approval_type', 'first_model', 'svmc_review_status', 'svmc_comment')
            ->get()->toArray();
        if (count($items) > 0) {
            foreach ($items as $item) {
                $data_temp = [
                    'submission_id' => $item->submission_id,
                    'ap_version' => $item->ap_version,
                    'approval_type' => $item->approval_type,
                    'svmc_review_status' => Submission::getValueSvmcStatus($item->svmc_review_status),
                    'first_model' => $item->first_model == 1 ? 'Yes': 'No' ,
                    'svmc_comment' => $item->svmc_comment
                ];
                $response[] = $data_temp;
            }
        }
        return $response;
    }

    public function getStartAndEndDate($week, $year) {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
      }

    // Search
    public function getSearch(Request $req){
        $user = Auth::user();
        $user_name = $user['name'];
        $total = isset($_GET['total']) ? intval($_GET['total']) : 10;
        $svmc_review_status = Submission::getSvmcStatus();
        $progress = Submission::getProgressStatus();
        $reviewer = Submission::getReviewer();
        $google_review_status = Submission::getGoogleStatus();
        $items = Submission::query()->select([
            'id', 'submission_id', 'device_code', 'ap_version', 'modem_version', 'csc_version', 'total_csc', 'approval_type', 'reviewer', 'pl_email', 'first_model', 'svmc_project', 'submit_date_time', 'svmc_review_date', 'urgent_mark', 'svmc_review_status', 'svmc_comment', 'progress', 'google_review_status', DB::raw('week(submit_date_time) as week')
        ])->orderByDesc('id')->paginate($total);
        $countTotal = $items->total();
        
        $week_array = $this->getStartAndEndDate($req->key_week,2020);
        // print_r($week_array);
        
        // print_r($week_array['week_start']);
        // print_r($week_array['week_end']);
        //$search_reviewer = Submission::getKeyReviewer($req->key_reviewer);

        // Convert Reviewer
        $convert_reviewer = '';
        if($req->key_reviewer =='phan.hue'){
            $convert_reviewer = 11;
        }else if($req->key_reviewer =='ng.thanhtuan'){
            $convert_reviewer = 22;
        }else if($req->key_reviewer =='vuong.hue'){
            $convert_reviewer = 33;
        }else if($req->key_reviewer =='nong.thuy'){
            $convert_reviewer = 44;
        }else if($req->key_reviewer =='dat.pt2'){
            $convert_reviewer = 55;
        } else if($req->key_reviewer =='trung.nd3'){
            $convert_reviewer = 66;
        } else if($req->key_reviewer =='oanh.lt'){
            $convert_reviewer = 77;
        } else if($req->key_reviewer =='hoai.nt4'){
            $convert_reviewer = 88;
        } else if($req->key_reviewer =='tu.nv1'){
            $convert_reviewer = 99;
        } else if($req->key_reviewer =='huy.dn'){
            $convert_reviewer = 10;
        } else if($req->key_reviewer =='nam.dt1'){
            $convert_reviewer = 12;
        } else if($req->key_reviewer =='ninh.tn'){
            $convert_reviewer = 13;
        } else if($req->key_reviewer =='ly.ltt'){
            $convert_reviewer = 14;
        } else if($req->key_reviewer =='cong.ngm'){
            $convert_reviewer = 15;
        } else if($req->key_reviewer =='thuynga.dt'){
            $convert_reviewer = 16;
        } else if($req->key_reviewer =='mai.dth'){
            $convert_reviewer = 17;
        } else if($req->key_reviewer =='diep.vtn'){
            $convert_reviewer = 18;
        } else if($req->key_reviewer =='thang.dv'){
            $convert_reviewer = 19;
        }

        // Convert FM
        $convert_fm = '';
        if($req->key_first =='yes'){
            $convert_fm = 1;
        }else if($req->key_first =='no') {
            $convert_fm = 0;
        }

        // Convert SVMC Project
        $convert_svmc = '';
        if($req->key_svmc =='true'){
            $convert_svmc = 1;
        }else if($req->key_svmc =='false') {
            $convert_svmc = 0;
        }

        // Convert SVMC STT
        $convert_stt = '';
        if($req->key_revstatus =='approved'){
            $convert_stt = 1;
        }else if($req->key_revstatus =='pending') {
            $convert_stt = 2;
        }else if($req->key_revstatus =='reviewed') {
            $convert_stt = 3;
        }else if($req->key_revstatus =='rejected') {
            $convert_stt = 4;
        }else if($req->key_revstatus =='cancelled') {
            $convert_stt = 5;
        }
        // Convert Google STT
        $convert_ggstt = '';
        if($req->key_ggstt =='approved'){
            $convert_ggstt = 1;
        }else if($req->key_ggstt =='rejected') {
            $convert_ggstt = 2;
        }else if($req->key_ggstt =='obsoleted') {
            $convert_ggstt = 3;
        }

        $resultsearch = submission::where('submission_id','like','%'.$req->key_id.'%')
                            ->where('device_code','like','%'.$req->key_code.'%')
                            ->where('ap_version','like','%'.$req->key_apver.'%')
                            ->where('modem_version','like','%'.$req->key_cpver.'%')
                            ->where('csc_version','like','%'.$req->key_cscver.'%')
                            ->where('total_csc','like','%'.$req->key_totalcsc.'%')
                            ->where('approval_type','like','%'.$req->key_type.'%')
                            ->where('pl_email','like','%'.$req->key_swpl.'%')
                            ->where('svmc_review_status','like','%'.$convert_stt.'%')
                            ->where('google_review_status','like','%'.$convert_ggstt.'%')
                            ->where('progress','like','%'.$req->key_progress.'%')
                            ->where('week','like','%'.$req->key_week.'%')
                            // ->whereBetween('submit_date_time', $week_array)                        
                            ->where('reviewer','like','%'.$convert_reviewer.'%')
                            ->where('first_model','like','%'.$convert_fm.'%')
                            ->where('svmc_project','like','%'.$convert_svmc.'%')
                            ->get();
        $getresultsearch = $this->getResponse($resultsearch);               
        return view('submission.search',compact('resultsearch', 'getresultsearch' ,'svmc_review_status', 'progress', 'google_review_status', 'reviewer', 'countTotal','user_name'));                   
    }

    public function import() 
    {
        // $inputPath = request()->file('file')->getPathName();
        // $outputPath =  storage_path()."/".basename($inputPath).".csv";

        // var_dump($inputPath);
        // var_dump($outputPath);
        // exec("C:\SCS\Release\XConverter.exe -f  \"$inputPath\" -o \"$outputPath\"");
        // // phai co file csv trong storage

        // // thay the vaof Excel import
        // // File("$outputPath")
        // Excel::import(new ImportExcel,File("$outputPath"));
        // return back();
        Excel::import(new ImportExcel,request()->file('file'));
        return back()->with('success','All good!');
    }
}