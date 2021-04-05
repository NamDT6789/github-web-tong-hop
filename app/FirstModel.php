<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FirstModel extends Model
{
	protected $table = 'first_model';
	protected $fillable = ['id', 'submission_id', 'device_code', 'model_name', 'sale_code', 'check_file_cts', 'check_list', 'asignment', 'status',
        'type','ratio_check_list', 'ratio_check_file', 'ratio_assignment'];
	const STATUS_SUBMITTED = 1;
	const STATUS_ON_GOING = 2;
	const STATUS_PENDING = 3;
	const STATUS_REVIEWED = 4;
	const STATUS_CANCELLED = 5;
	const STATUS_REJECTED = 6;
	const STATUS_APPROVAL = 7;

	const APPROVAL = 'Approval';
	const PENDING = 'Pending';
	const REVIEWED = 'Reviewed';
	const REJECTED = 'Rejected';
	const CANCELLED = 'Cancelled';
	const SUBMITTED = 'Submitted';
	const ON_GOING = 'On going';

	const ARRAY_STATUS = [
		self::STATUS_SUBMITTED => self::SUBMITTED,
		self::STATUS_ON_GOING => self::ON_GOING,
		self::STATUS_PENDING => self::PENDING,
		self::STATUS_REVIEWED => self::REVIEWED,
		self::STATUS_CANCELLED => self::CANCELLED,
		self::STATUS_REJECTED => self::REJECTED,
		self::STATUS_APPROVAL => self::APPROVAL,
	];

	const RATIO_VARIANT = 20;
	const RATIO_CHECK_FILE_SIM = 60;
	const RATIO_CHECK_LIST_SIM = 40;
	const RATIO_CHECK_FILE_FULL = 50;
	const RATIO_CHECK_LIST_FULL = 50;

    public function reviewer_model(){
        return $this->hasMany(ReviewerModel::class,'first_model_id','id');
    }

    public static function getPercent($type, $arrTotal) {
        switch ($type) {
            case 0:
                $percent = floor(50 / $arrTotal);
                return $percent;
            case 1:
                $percentFullFM = floor(85 / $arrTotal);
                return $percentFullFM;
        }
//        return self::ARRAY_STATUS;
    }

	/**
	 * @return array
	 */
	public static function getStatus() {
		return self::ARRAY_STATUS;
	}

	/**
	 * @param null $key
	 * @return mixed
	 */
	public static function getValueStatus($key = null) {
		if (array_key_exists($key, self::ARRAY_STATUS)) {
			return self::ARRAY_STATUS[$key];
		}
	}
	/**
	 * @param null $value
	 * @return array
	 */
	public static function getKeyStatus($value = null) {
		if (in_array($value, self::ARRAY_STATUS)) {
			return array_keys(self::ARRAY_STATUS, $value);
		}
	}

    public static function countPercent($value = null) {
        if (in_array($value, self::ARRAY_STATUS)) {
            return array_keys(self::ARRAY_STATUS, $value);
        }
    }
}
