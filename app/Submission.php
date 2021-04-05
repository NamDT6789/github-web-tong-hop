<?php
namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
class Submission extends Model
{
    protected $table = 'submission';
    protected $fillable = ['id','submission_id', 'device_code', 'ap_version', 'modem_version', 'csc_version', 'total_csc', 'approval_type', 'reviewer', 'pl_email', 'first_model', 'svmc_project', 'submit_date_time', 'svmc_review_date', 'urgent_mark', 'week', 'svmc_review_status', 'svmc_comment', 'progress', 'google_review_status'];
    const STATUS_APPROVAL = 1;
    const STATUS_PENDING = 2;
    const STATUS_REVIEWED = 3;
    const STATUS_REJECTED = 4;
    const STATUS_CANCELLED = 5;
    const APPROVAL = 'Approval';
    const PENDING = 'Pending';
    const REVIEWED = 'Review';
    const REJECTED = 'Rejected';
    const CANCELLED = 'Cancelled';
    const PROGRESS_COMPLETE = 1;
    const PROGRESS_ONGOING = 2;
    const PROGRESS_NOT_SET = 3;
    const COMPLETE = 'Completed';
    const ONGOING = 'Ongoing';
    const NOT_SET = 'Not set';
    const GG_APPROVED = 1;
    const GG_REJECTED = 2;
    const GG_OBSOLETED = 3;
    const GOOGLE_APPROVED = 'Approved';
    const GOOGLE_REJECTED = 'Rejected';
    const GOOGLE_OBSOLETED = 'Obsoleted';
    const ARRAY_STATUS = [
        self::STATUS_APPROVAL => self::APPROVAL,
        self::STATUS_PENDING => self::PENDING,
        self::STATUS_REVIEWED => self::REVIEWED,
        self::STATUS_REJECTED => self::REJECTED,
        self::STATUS_CANCELLED => self::CANCELLED
    ];
    const PROGRESS = [
        self::PROGRESS_COMPLETE => self::COMPLETE,
        self::PROGRESS_ONGOING => self::ONGOING,
        self::PROGRESS_NOT_SET => self::NOT_SET
    ];
    const GOOGLE_STATUS = [
        self::GG_APPROVED => self::GOOGLE_APPROVED,
        self::GG_REJECTED => self::GOOGLE_REJECTED,
        self::GG_OBSOLETED => self::GOOGLE_OBSOLETED
    ];
    const REVIEWER = [
        '1' => 'Nguyễn Văn A1',
        '2' => 'Nguyễn Văn A2',
        '3' => 'Nguyễn Văn A3',
        '4' => 'Nguyễn Văn A4',
        '5' => 'Nguyễn Văn A5',
        '6' => 'Nguyễn Văn A6',
    ];
    /**
     * @return array
     */
    public static function getSvmcStatus()
    {
        return self::ARRAY_STATUS;
    }
    /**
     * @return array
     */
    public static function getProgressStatus()
    {
        return self::PROGRESS;
    }
    /**
     * @return array
     */
    public static function getGoogleStatus()
    {
        return self::GOOGLE_STATUS;
    }
    /**
     * @param null $key
     * @return mixed
     */
    public static function getValueSvmcStatus($key = null)
    {
        if (array_key_exists($key, self::ARRAY_STATUS)) {
            return self::ARRAY_STATUS[$key];
        }
    }
    /**
     * @param null $value
     * @return array
     */
    public static function getKeySvmcStatus($value = null)
    {
        if (in_array($value, self::ARRAY_STATUS)) {
            return array_keys(self::ARRAY_STATUS, $value);
        }
    }
    /**
     * @param null $key
     * @return mixed
     */
    public static function getValueProgressStatus($key = null)
    {
        if (array_key_exists($key, self::PROGRESS)) {
            return self::PROGRESS[$key];
        }
    }
    /**
     * @param null $key
     * @return mixed
     */
    public static function getValueGoogleStatus($key = null)
    {
        if (array_key_exists($key, self::GOOGLE_STATUS)) {
            return self::GOOGLE_STATUS[$key];
        }
    }
    /**
     * @param null $key
     * @return string
     */
    public static function getTrueFalse($key = null)
    {
        $value = 'False';
        if ($key === 1) {
            $value = 'True';
        }
        return $value;
    }
    /**
     * @param null $dateTime
     * @return false|string
     */
    public static function getDate($dateTime = null)
    {
        $date = date('d/m/Y', strtotime($dateTime));
        return $date;
    }
    /**
     * @param null $datTime
     * @return false|string
     */
    public static function getTime($datTime = null)
    {
        $time = date('H:i', strtotime($datTime));
        return $time . ' KST';
    }
    /**
     * @return array
     */
    public static function getReviewer()
    {
        return self::REVIEWER;
    }
    /**
     * @param null $key
     * @return mixed
     */

    public static function getValueReviewer($key = null)
    {
        if (array_key_exists($key, self::REVIEWER)) {
            return self::REVIEWER[$key];
        }
    }

//    public static function getValueReviewerBySelect2($arrReviewer = [])
//    {
//        if ($arrReviewer) {
//            foreach ($arrReviewer as $r) {
//                if (array_key_exists($r, self::REVIEWER)) {
//                    return self::REVIEWER[$r];
//                }
//            }
//        }
//    }
    /**
     * @param null $value
     * @return array
     */
    public static function getKeyReviewer($value = null)
    {
        if (in_array($value, self::REVIEWER)) {
            return array_keys(self::REVIEWER, $value);
        }
    }

    public static function getWeek($date = null)
    {
        $now = new Carbon($date);
        return $now->weekOfYear;
    }
}