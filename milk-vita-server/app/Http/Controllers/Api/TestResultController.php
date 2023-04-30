<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TestResult;
use Illuminate\Support\Facades\Validator;

class TestResultController extends Controller
{
    public function all(Request $request, TestResult $testResult)
    {
        $where   = where($request->where);

        // MAKE PAGINATED DATA
        $testResults = paginate($testResult, $where, $request->per_page, $request->page_no);

        return response()->json($testResults);
    }

    public function store(Request $request, TestResult $testResult)
    {
        $validator = Validator::make($request->all(), [
            'test_id' => 'required|integer',
            'testable_id' => 'required|integer',
            'testable_type' => 'required',
            'tested_by' => 'required|integer',
            'result' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 200);
        }

        $testResult->create($request->only('test_id', 'testable_id', 'testable_type', 'tested_by', 'result'));

        return response()->json($testResult->get());
    }

    public function update(Request $request, TestResult $testResult, $id)
    {
        $validator = Validator::make($request->all(), [
            'test_id' => 'required|integer',
            'testable_id' => 'required|integer',
            'testable_type' => 'required',
            'tested_by' => 'required|integer',
            'result' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 200);
        }

        $data = $request->only('test_id', 'testable_id', 'testable_type', 'tested_by', 'result');
        $testResult = $testResult->find($id);
        //
        if (!$testResult->get()->isEmpty()) {
            return response()->json($testResult->update($data));
        } else {
            return response()->json(['erros' => ['Something is wrong!! please try again']]);
        }
    }
}
