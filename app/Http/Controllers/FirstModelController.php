<?php

namespace App\Http\Controllers;

use App\FirstModel;
use App\ReviewerModel;
use App\Submission;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\ImportExcelFirst;
use App\Exports\Export;
use Maatwebsite\Excel\Facades\Excel;

class FirstModelController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $user_name = $user['name'];
        $status = FirstModel::getStatus();
        $reviewer = Submission::getReviewer();
//		dd($reviewer, '3');
        $items = FirstModel::query()->select([
            'id', 'submission_id', 'device_code', 'model_name', 'sale_code', 'check_file_cts', 'check_list', 'asignment', 'status', 'ratio_assignment', 'ratio_check_file', 'ratio_check_list', 'type', 'created_at', 'updated_at',
        ])->orderByDesc('id')->paginate('10');
//		dd($items);
        $countTotal = $items->total();
//        $first_model = $items;
        $first_model = $this->getResponse($items);
        $total_reviewer = $this->getTotalReviewer();
        return view('first_model.index', compact('items', 'first_model', 'status', 'reviewer', 'countTotal', 'user_name', 'total_reviewer'));
    }

    public function editPercent($id)
    {
        $firstModel = FirstModel::find($id);
        $reviewer = $firstModel->reviewer_model;
//        $getReviewer = ReviewerModel::find($reviewer->id);
//        dd($reviewer);
        $user = Auth::user();
        $user_name = $user['name'];
        return view('first_model.edit-percent', compact('user_name', 'reviewer', 'firstModel'));
    }

    public function storePercent(Request $request, $id)
    {

//        $this->validate($request, [
//            'long' => 'required',
//            'lat' => 'required',
//            'address_gmap' => 'required',
//            'phone'=> 'unique:account_provider',
//            'email' => 'unique:account_provider,email',
//            'secrect_code' => "max:4| min:4|regex:!^[0-9][0-9]*$!"
//        ],[
//            'long.required' => 'Vĩ độ không được để trống',
//            'lat.required' => 'Kinh độ không được để trống',
//            'address_gmap.required' => 'Địa chỉ gmap không được để trống',
//            'phone.unique'=>'Số điện thoại đã tồn tại',
//            'email.unique' => 'Địa chỉ email đã tồn tai',
//            'secrect_code.max' => 'Độ dài tối đa của mã số bí mật là 4 số !',
//            'secrect_code.min' => 'Độ dài tối thiểu của mã số bí mật là 4 số !',
//            'secrect_code.regex' => 'Mã số bí mật không đúng định dạng !',
//        ]);

        $params = $request->request->all();
        foreach ($params as $key => $item) {

            if ($key !== '_token') {
                $reviewerModel = ReviewerModel::find($key);
                $reviewerModel->percent = (int)$item;
                $reviewerModel->save();
            }
        }
        return redirect()->route('first_model.editPercent', $id)->with('notify','Update success');
    }

    /**
     * @param $items
     * @return array
     */
    protected function getResponse($items)
    {
        $first_model = [];
        if ($items) {
            foreach ($items as $item) {
                $first_model[] = [
                    'id' => $item['id'],
                    'submission_id' => $item['submission_id'],
                    'device_code' => $item['device_code'],
                    'model_name' => $item['model_name'],
                    'sale_code' => $item['sale_code'],
                    'check_file_cts' => $item->reviewer_model,
                    'check_list' => $item->reviewer_model,
                    'asignment' => Submission::getValueReviewer($item['asignment']),
                    'status' => FirstModel::getValueStatus($item['status']),
                    'type' => $item['type'],
                    'ratio_assignment' => $item->reviewer_model,
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
    public function createOrUpdate(Request $request, $id = null)
    {
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

        $first_model->asignment = null;
        $first_model->ratio_assignment = 0;
        $first_model->ratio_check_file = FirstModel::RATIO_CHECK_FILE_SIM;
        $first_model->ratio_check_list = FirstModel::RATIO_CHECK_LIST_SIM;
//		if ($params['type'] == 1) {
//            $first_model->ratio_check_file = FirstModel::RATIO_CHECK_FILE_FULL;
//            $first_model->ratio_check_list = FirstModel::RATIO_CHECK_LIST_FULL;
//        }
//        if ($params['type'] == 2) {
//            $first_model->check_file_cts = null;
//            $first_model->check_list = null;
//            $first_model->asignment = $params['asignment_reviewer'];
//            $first_model->ratio_assignment = FirstModel::RATIO_VARIANT;
//            $first_model->ratio_check_file = 0;
//            $first_model->ratio_check_list = 0;
//        }
        $first_model->status = $params['status'];
        $first_model->type = $params['type'];
        $first_model->save();
        if ($params['type'] != '2') {
            if ($params['check_file_reviewer']) {
                $check_file_cts = $params['check_file_reviewer'];
                foreach ($check_file_cts as $file) {
                    try {
                        $reviewModel = new ReviewerModel();
                        $reviewModel->check_file = $file;
                        $reviewModel->reviewer_name = Submission::getValueReviewer($file);
                        $reviewModel->reviewer_id = $file;
                        $reviewModel->check_type = 2;
                        $reviewModel->percent = FirstModel::getPercent($params['type'], count($check_file_cts));
                        $reviewModel->first_model_id = $first_model->id;
                        $reviewModel->save();
                    } catch (\Exception $e) {
                        // do task when error
                        echo $e->getMessage();   // insert query
                    }
                }
            }
            if ($params['check_list_reviewer']) {
                $check_list = $params['check_list_reviewer'];
                foreach ($check_list as $list) {
                    try {
                        $reviewModel2 = new ReviewerModel();
                        $reviewModel2->check_list = $list;
                        $reviewModel2->reviewer_name = Submission::getValueReviewer($list);
                        $reviewModel2->reviewer_id = $list;
                        $reviewModel2->check_type = 1;
                        $reviewModel2->percent = FirstModel::getPercent($params['type'], count($check_list));
                        $reviewModel2->first_model_id = $first_model->id;
                        $reviewModel2->save();
                    } catch (\Exception $e) {
                        // do task when error
                        echo $e->getMessage();   // insert query
                    }
                }
            }
        }
        if ($params['type'] === '2') {
            try {
                $reviewModel3 = new ReviewerModel();
                $reviewModel3->reviewer_name = Submission::getValueReviewer($params['asignment_reviewer']);
                $reviewModel3->check_type = 3;
                $reviewModel3->reviewer_id = $params['asignment_reviewer'];
                $reviewModel3->percent = FirstModel::RATIO_VARIANT;
                $reviewModel3->first_model_id = $first_model->id;
                $reviewModel3->save();
            } catch (\Exception $e) {
                // do task when error
                echo $e->getMessage();   // insert query
            }
        }
//		if ($first_model->save()) {
        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
//		}
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id)
    {
        $submissionId = FirstModel::find($id);
        $reviewer = $submissionId->reviewer_model;
        $submissionId['reviewer'] = $reviewer;
        return response()->json($submissionId);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        FirstModel::query()->where('id', $id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }

    protected function getTotalReviewer()
    {
//        $total = 'SELECT t.name, SUM(t.total) as totalReviewer FROM
//                    (SELECT name, total FROM (SELECT asignment as name, SUM(ratio_assignment) as total FROM first_model GROUP BY asignment) as a
//                     UNION ALL
//                     SELECT name, total FROM (SELECT check_file_cts as name, SUM(ratio_check_file) as total FROM first_model GROUP BY check_file_cts) as b
//                     UNION ALL
//                     SELECT name, total FROM (SELECT check_list as name, SUM(	ratio_check_list) as total FROM first_model GROUP BY check_list) as c
//                    ) as t GROUP BY t.name';
        $total = 'SELECT * ,SUM(percent) as total from reviewer_connect GROUP by  reviewer_name';

        $totalReview = DB::select($total);
//        @dd($totalReview);
//        $data = [];
//        foreach ($totalReview as $items) {
//            if ($items->name != null) {
//                $data[] = [
//                    'name' => Submission::getValueReviewer($items->name),
//                    'total' => $items->totalReviewer
//                ];
//            }
//
//        }
//        return $data;
        return $totalReview;
    }

    public function importFirst()
    {
        Excel::import(new ImportExcelFirst, request()->file('file'));
        return back()->with('success', 'All good!');
    }
}