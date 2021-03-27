<?php
namespace App\Exports;
use App\Submission;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class Export implements FromCollection, WithHeadings
{
    private $time;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $time = $this->getTime();
        $items = Submission::query()
            ->where('submit_date_time', '>=', $time)
            ->select(['submission_id', 'device_code', 'ap_version', 'modem_version', 'csc_version', 'total_csc', 'approval_type', 'reviewer', 'pl_email', 'first_model', 'svmc_project', 'submit_date_time', 'svmc_review_date', 'urgent_mark', 'svmc_review_status', 'svmc_comment', 'progress', 'google_review_status', 'week'])
            ->get();
        $response = $this->getResponse($items);
        return collect($response);
    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Submission ID',
            'Device code',
            'AP version',
            'Modem version',
            'CSC version',
            'Total CSC',
            'Approval type',
            'Reviewer',
            'S/W PL email',
            'First model',
            'SVMC project',
            'Week',
            'Submit date',
            'Submit time',
            'SVMC review date',
            'Urgent mark',
            'SVMC review status',
            'SVMC comment',
            'Progress',
            'Google review status',
        ];
    }
    /**
     * @param $items
     * @return array
     */
    protected function getResponse($items)
    {
        $response = [];
        $index = 1;
        foreach ($items as $item) {
            $submit_date = Submission::getDate($item->submit_date_time);
            $submit_time = Submission::getTime($item->submit_date_time);
            $svmc_review_date = Submission::getDate($item->svmc_review_date);
            $svmc_review_status = Submission::getValueSvmcStatus($item->svmc_review_status);
            $progress = Submission::getValueProgressStatus($item->progress);
            $google_review_status = Submission::getValueGoogleStatus($item->google_review_status);
            $urgent_mark = Submission::getTrueFalse($item->urgent_mark);
            $svmc_project = Submission::getTrueFalse($item->svmc_project);
            $reviewer = Submission::getValueReviewer($item->reviewer);
            $array = [
                'index' => $index,
                'submission_id' => "'".$item->submission_id,
                'device_code' => $item->device_code,
                'ap_version' => $item->ap_version,
                'modem_version' => $item->modem_version,
                'csc_version' => $item->csc_version,
                'total_csc' => $item->total_csc,
                'approval_type' => $item->approval_type === 'Regular' ? 'Regular' : ($item->approval_type === 'NormalException' ? 'NormalException' : 'SMR'),
                'reviewer' => $reviewer,
                'pl_email' => $item->pl_email,
                'first_model' => $item->first_model === 1 ? 'Yes' : 'No',
                'svmc_project' => $svmc_project,
                'week' => $item->week,
                'submit_date' => $submit_date,
                'submit_time' => $submit_time,
                'svmc_review_date' => $svmc_review_date,
                'urgent_mark' => $urgent_mark,
                'svmc_review_status' => $svmc_review_status,
                'svmc_comment' => $item->svmc_comment,
                'progress' => $progress,
                'google_review_status' => $google_review_status,
            ];
            $index++;
            $response[] = $array;
        }
        return $response;
    }
    /**
     * @return mixed
     */
    public function getTime()
    {
        $time = $this->time;
        switch ($time) {
            case 'w' :
                $start_time = mktime(0, 0, 0, date("m"), date("d") - 7, date("Y"));
                break;
            case 'm' :
                $start_time = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
                break;
            default:
                $start_time = mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1);
                break;
        }
        return date('Y/m/d 00:00:00', $start_time);
    }
    /**
     * @param $time
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }
}