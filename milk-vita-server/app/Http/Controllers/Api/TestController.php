<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    public function all(Request $request, Test $test)
    {
        $where   = where($request->where);

        // MAKE PAGINATED DATA
        $tests = paginate($test, $where, $request->per_page, $request->page_no);

        return response()->json($tests);
    }

    public function store(Request $request, Test $test)
    {
        $validator = Validator::make($request->all(), [
            'test_name' => 'required|unique:tests,test_name',
            'standerd_value' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 200);
        }

        $test->create($request->only('test_name', 'standerd_value'));

        return response()->json($test->get());
    }

    public function update(Request $request, Test $test, $id)
    {
        $validator = Validator::make($request->all(), [
            'test_name' => 'required',
            'standerd_value' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 200);
        }

        $data = $request->only('test_name', 'standerd_value');
        $test = $test->find($id);
        //
        if (!$test->get()->isEmpty()) {
            return response()->json($test->update($data));
        } else {
            return response()->json(['erros' => ['Something is wrong!! please try again']]);
        }
    }
}
