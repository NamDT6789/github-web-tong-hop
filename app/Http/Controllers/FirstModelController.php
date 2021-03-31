<?php

namespace App\Http\Controllers;

use App\FirstModel;
use App\Submission;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\ImportExcelFirst;
use App\Exports\Export;
use Maatwebsite\Excel\Facades\Excel;

class FirstModelController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		$user = Auth::user();
		$user_name = $user['name'];
		$status = FirstModel::getStatus();
		$reviewer = Submission::getReviewer();
		$items = FirstModel::query()->select([
			'id', 'submission_id', 'device_code', 'model_name', 'sale_code', 'check_file_cts', 'check_list', 'asignment', 'status','ratio_assignment','ratio_check_file','ratio_check_list',  'type', 'created_at', 'updated_at',
		])->orderByDesc('id')->paginate('20');
		$countTotal = $items->total();
		$first_model = $this->getResponse($items);
//		@dd($first_model);
		$total_reviewer = $this->getTotalReviewer();
		return view('first_model.index', compact('items', 'first_model', 'status', 'reviewer', 'countTotal', 'user_name', 'total_reviewer'));
	}
	/**
	 * @param $items
	 * @return array
	 */
	protected function getResponse($items) {
		$first_model = [];
		if ($items) {
			foreach ($items as $item) {
				$first_model[] = [
					'id' => $item['id'],
					'submission_id' => $item['submission_id'],
					'device_code' => $item['device_code'],
					'model_name' => $item['model_name'],
					'sale_code' => $item['sale_code'],
					'check_file_cts' => Submission::getValueReviewer($item['check_file_cts']),
					'check_list' => Submission::getValueReviewer($item['check_list']),
					'asignment' => Submission::getValueReviewer($item['asignment']),
					'status' => FirstModel::getValueStatus($item['status']),
					'type' => $item['type'],
                    'ratio_assignment' => $item['ratio_assignment'],
                    'ratio_check_file' => $item['ratio_check_file'],
                    'ratio_check_list' => $item['ratio_check_list']
				];
			}
		}
		return $first_model;
	}

	/**
	 * @param Request $request
	 * @param null $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createOrUpdate(Request $request, $id = null) {
		if ($id) {
			$first_model = FirstModel::find($id);
			$check = FirstModel::query()->where('submission_id', $request['submission_id'])->where('id', '!=', $id)->first();
			$message = 'Update First Model Success';
		} else {
			$first_model = new FirstModel();
			$check = FirstModel::query()->where('submission_id', $request['submission_id'])->first();
			$message = 'Create First Model Success';
		}
		if ($check) {
			$message = 'First Model da ton tai';
			return response()->json([
				'message' => $message,
			]);
		}

		$params = $request->request->all();
		$first_model->submission_id = $params['submission_id'];
		$first_model->device_code = $params['device_code'];
		$first_model->model_name = $params['model_name'];
		$first_model->sale_code = $params['sale_code'];
		if ($params['check_file_reviewer']) {
            $first_model->check_file_cts = implode(',', $params['check_file_reviewer']);
        } else {
            $first_model->check_file_cts = null;
        }
        if ($params['check_list_reviewer']) {
            $first_model->check_list = implode(',', $params['check_list_reviewer']);
        } else {
            $first_model->check_list = null;
        }
        $first_model->asignment = null;
        $first_model->ratio_assignment = 0;
        $first_model->ratio_check_file = FirstModel::RATIO_CHECK_FILE_SIM;
        $first_model->ratio_check_list = FirstModel::RATIO_CHECK_LIST_SIM;
		if ($params['type'] == 1) {
            $first_model->ratio_check_file = FirstModel::RATIO_CHECK_FILE_FULL;
            $first_model->ratio_check_list = FirstModel::RATIO_CHECK_LIST_FULL;
        }
        if ($params['type'] == 2) {
            $first_model->check_file_cts = null;
            $first_model->check_list = null;
            $first_model->asignment = $params['asignment_reviewer'];
            $first_model->ratio_assignment = FirstModel::RATIO_VARIANT;
            $first_model->ratio_check_file = 0;
            $first_model->ratio_check_list = 0;
        }
		$first_model->status = $params['status'];
		$first_model->type = $params['type'];
		if ($first_model->save()) {
			return response()->json([
				'status' => 200,
				'message' => $message,
			]);
		}
	}

	/**
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function update($id) {
		$submissionId = FirstModel::find($id);
		return response()->json($submissionId);
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy($id) {
		FirstModel::query()->where('id', $id)->delete();
		return response()->json([
			'status' => 200,
		]);
	}

    protected function getTotalReviewer()
    {
        $total = 'SELECT t.name, SUM(t.total) as totalReviewer FROM 
                    (SELECT name, total FROM (SELECT asignment as name, SUM(ratio_assignment) as total FROM first_model GROUP BY asignment) as a 
                     UNION ALL 
                     SELECT name, total FROM (SELECT check_file_cts as name, SUM(ratio_check_file) as total FROM first_model GROUP BY check_file_cts) as b
                     UNION ALL
                     SELECT name, total FROM (SELECT check_list as name, SUM(	ratio_check_list) as total FROM first_model GROUP BY check_list) as c
                    ) as t GROUP BY t.name';

        $totalReview = DB::select($total);
        $data = [];
        foreach ($totalReview as $items) {
            if ($items->name != null) {
                $data[] = [
                    'name' => Submission::getValueReviewer($items->name),
                    'total' => $items->totalReviewer
                ];
            }

        }
        return $data;
    }
	public function importFirst() 
    {
        Excel::import(new ImportExcelFirst,request()->file('file'));
        return back()->with('success','All good!');
    }
}