<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json([
            'status' => '200',
            'message' => 'Success',
            'data' => $transactions
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'person_name' => 'required',
            'person_gender' => 'required',
            'person_email' => 'required',
            'person_telp' => 'required',
            'person_company' => 'required',
            'activity_type' => 'required',
            'activity_name' => 'required',
            'short_desc' => 'required',
            'payment_img' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $transaction = Transaction::create([
            'person_name' => $request->person_name,
            'person_gender' => $request->person_gender,
            'person_email' => $request->person_email,
            'person_telp' => $request->person_telp,
            'person_company' => $request->person_company,
            'activity_type' => $request->activity_type,
            'activity_name' => $request->activity_name,
            'short_desc' => $request->short_desc,
            'payment_img' => $request->payment_img,
            'status' => True,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Created',
            'data' => $transaction
        ], 201);
    }


    public function show($id){
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction Not Found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Found',
            'data' => $transaction
        ], 200);
    }

    public function destroy($id){
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction Not Found'
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Deleted',
        ], 200);
    }

}
