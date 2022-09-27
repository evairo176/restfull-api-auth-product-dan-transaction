<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transactions::orderBy('created_at', 'DESC')->paginate(5);
        $response = [
            'message' => 'Data Transactions',
            'data' => $transactions,
        ];
        return response()->json($response, HttpFoundationResponse::HTTP_OK);
    }
    public function search(Request $request,$search){
     
        $keyword = $search;
        $transactions = Transactions::where('price', 'like', "%" . $keyword . "%")->orderBy('created_at', 'DESC')->paginate(5);
        if(count($transactions)){
            $response = [
                'message' => 'Data Search Berhasil',
                'data' => $transactions,
            ];
            return response()->json($response, HttpFoundationResponse::HTTP_OK);
        }else{
            $response = [
                'message' => 'Data Search Tidak Ditemukan',
                'data' => $transactions,
            ];
            return response()->json($response, HttpFoundationResponse::HTTP_NOT_FOUND);
        }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => ['required'],
            "product_id" => ['required'],
            "quantity" => ['required'],
            "price" => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_BAD_REQUEST
            );
        }

        try {


            $data = [
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'status' => 'PENDING',
                'reference_number' => 'RN'.$request->user_id.$request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total_price' => $request->price * $request->quantity,

            ];
            $transactions = Transactions::create($data);

            $response = [
                'respone_code' => 2009900,
                'message' => 'Berhasil disimpan',
                'data' => $transactions,
            ];

            return response()->json($response, HttpFoundationResponse::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'respone_code' => 5009901,
                'message' => "Gagal " . $e->errorInfo,
                HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transactions = Transactions::find($id);
        $data = [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'status' => 'SUCCESS',
            'reference_number' => $transactions->reference_number,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total_price' => $request->price * $request->quantity,

        ];
        $transactions->update($data);
        return response()->json([
            'respone_code' => 2009900,
            "success" => true,
            "message" => "Data Transactions telah diubah.",
            "data" => $transactions,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
