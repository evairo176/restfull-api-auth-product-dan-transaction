<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buku = Buku::orderBy('created_at', 'DESC')->paginate(5);
        $response = [
            'message' => 'Data Buku',
            'data' => $buku,
        ];
        return response()->json($response, HttpFoundationResponse::HTTP_OK);
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
            "kode_buku" => ['required'],
            "judul" => ['required'],
            "pengarang" => ['required'],
            "isbn" => ['required'],
            "tahun" => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $buku = Buku::create($request->all());

            $response = [
                'message' => 'Berhasil disimpan',
                'data' => $buku,
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
        $buku = Buku::where('id', $id)->firstOrFail();
        if (is_null($buku)) {
            return $this->sendError('Buku tidak diemukan');
        }
        return response()->json([
            "success" => true,
            "message" => "Data Buku ditemukan.",
            "data" => $buku,
        ]);
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
        $buku = BUku::find($id);
        $buku->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Data Buku telah diubah.",
            "data" => $buku,
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
        $deletedRows = Buku::where('id', $id)->delete();
        return response()->json([
            "success" => true,
            "message" => "Data Buku berhasil dihapus.",
            "data" => $deletedRows,
        ]);
    }
}
