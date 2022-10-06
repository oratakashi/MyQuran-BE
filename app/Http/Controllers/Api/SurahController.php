<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Surah;
use App\Models\Ayat;
use App\Models\AyatIndopak;
use App\Models\AyatUstmani;
use App\Http\Resources\BaseResource;
use App\Http\Resources\PaginationResource;

class SurahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BaseResource(200, "Berhasil Mendapatkan data surah", Surah::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = $request->type;

        $json = json_decode($request->getContent());

        try {
            if($type != "") {
                if($type == "indopak") {
                    foreach ($json as $item) {
                        $surah = Ayat::where("idSurah", $item->surah)
                            ->where("nomor", $item->nomor)
                            ->first()
                            ->toArray();

                        AyatIndopak::create([
                            "id" => $surah["id"],
                            "arabic" => $item->ayat
                        ]);

                    }
                    return response()->json(new BaseResource(
                        200,
                        "Operation Success!",
                        $json
                    ), 200);
                } else if($type == "utsmani") {
                    foreach ($json as $item) {
                        $surah = Ayat::where("idSurah", $item->surah)
                            ->where("nomor", $item->nomor)
                            ->first()
                            ->toArray();

                        // dd($surah);

                        AyatUstmani::create([
                            "id" => $surah["id"],
                            "arabic" => $item->ayat
                        ]);

                    }
                    return response()->json(new BaseResource(
                        200,
                        "Operation Success!",
                        $json
                    ), 200);
                } else {
                    return response()->json(new BaseResource(
                        400,
                        "Type is Unknown!",
                        null
                    ), 400);
                }
            } else {
                return response()->json(new BaseResource(
                    500,
                    "Type is Empty!",
                    null
                ), 500);
            }
        }catch(Exception $e) {
            return response()->json(new BaseResource(
                500,
                "Something wrong!",
                null
            ), 500);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $pageSize = 10;

        if($request->pageSize != "") {
            $pageSize = (int)$request->pageSize;
        }

        if($request->type == 'indopak') {
            if($request->page != "") {
                $data = DB::table('ayat')
                    ->where('idSurah', $id)
                    ->orderBy('nomor', 'asc')
                    ->join('ayat_indopak', 'ayat.id', '=', 'ayat_indopak.id')
                    ->paginate($pageSize);

                return response()->json(
                    new PaginationResource(
                        200,
                        "Success Get Ayat $id",
                        $data->currentPage(),
                        $data->lastPage(),
                        $data->total(),
                        $data->items()
                    ),
                        200
                    );
            } else {
                $data = DB::table('ayat')
                ->where('idSurah', $id)
                ->orderBy('nomor', 'asc')
                ->join('ayat_indopak', 'ayat.id', '=', 'ayat_indopak.id')
                ->get();

                return response()->json(
                    new BaseResource(
                        200,
                        "Success Get Ayat $id",
                        $data
                    ),
                        200
                    );
            }
        } else {
            if($request->page != "") {
                $data = DB::table('ayat')
                    ->where('idSurah', $id)
                    ->orderBy('nomor', 'asc')
                    ->join('ayat_ustmani', 'ayat.id', '=', 'ayat_ustmani.id')
                    ->paginate($pageSize);

                return response()->json(
                    new PaginationResource(
                        200,
                        "Success Get Ayat $id",
                        $data->currentPage(),
                        $data->lastPage(),
                        $data->total(),
                        $data->items()
                    ),
                        200
                    );
            } else {
                $data = DB::table('ayat')
                ->where('idSurah', $id)
                ->orderBy('nomor', 'asc')
                ->join('ayat_ustmani', 'ayat.id', '=', 'ayat_ustmani.id')
                ->get();

                return response()->json(
                    new BaseResource(
                        200,
                        "Success Get Ayat $id",
                        $data
                    ),
                        200
                    );
            }
        }

        // $ayat = Ayat::where("idSurah", (int)$id)
        //     ->orderBy("nomor")
        //     ->get();

        // if($request->page != "") {
        //     $ayat = Ayat::where("idSurah", (int)$id)
        //     ->orderBy("nomor")
        //     ->paginate($pageSize)
        //     ->items();
        // }

        // return new BaseResource(
        //     200,
        //     "Berhasil Mendapatkan Data Surah",
        //     $ayat
        // );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
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
