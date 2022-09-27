<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('created_at', 'DESC')->paginate(5);
        $response = [
            'message' => 'Data Product',
            'data' => $product,
        ];
        return response()->json($response, HttpFoundationResponse::HTTP_OK);
    }
    public function search(Request $request,$search){
     
            $keyword = $search;
            $product = Product::where('name', 'like', "%" . $keyword . "%")->orderBy('created_at', 'DESC')->paginate(5);
            if(count($product)){
                $response = [
                    'message' => 'Data Search Berhasil',
                    'data' => $product,
                ];
                return response()->json($response, HttpFoundationResponse::HTTP_OK);
            }else{
                $response = [
                    'message' => 'Data Search Tidak Ditemukan',
                    'data' => $product,
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
            "name" => ['required'],
            "price" => ['required'],
            "stock" => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_BAD_REQUEST
            );
        }

        try {
            $product = Product::create($request->all());

            $response = [
                'message' => 'Berhasil disimpan',
                'data' => $product,
            ];

            return response()->json($response, HttpFoundationResponse::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Gagal " . $e->errorInfo,
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
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Data Product telah diubah.",
            "data" => $product,
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
