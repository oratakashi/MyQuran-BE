<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surah;
use App\Models\Ayat;
use App\Http\Resources\BaseResource;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;
use App\Models\AyatIndopak;
use App\Models\AyatUstmani;
use Illuminate\Support\Facades\DB;

class CrawlerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = new BaseResource(404, "Please insert params!", null);
        return $response;
    }

    public function getSurah()
    {
        $request = Http::get("https://api.npoint.io/99c279bb173a6e28359c/data");
        $response = $request->json();

        foreach ($response as $item) {
            $validation = Surah::where("id", (int)$item["nomor"])->get();

            if(count($validation) == 0) {
                Surah::create([
                    "nama" => $item["nama"],
                    "rukuk" => $item["rukuk"],
                    "urut" => $item["urut"],
                    "keterangan" => $item["keterangan"],
                    "arti" => $item["arti"],
                    "asma" => $item["asma"],
                    "audio" => $item["audio"],
                    "type" => $item["type"],
                    "ayat" => $item["ayat"],
                    "id" => $item["nomor"],
                ]);
            }
        }

        return new BaseResource(200, "Data Surah", Surah::all());
    }

    public function updateAyat()
    {
        // $ayat = Ayat::where("nomor", 1)
        //     ->where("idSurah", "!=", 1)
        //     ->orderBy("idSurah")
        //     ->get()
        //     ->toArray();

        // $ayat = DB::table('ayat')
        //     ->where('idSurah', '!=', 1)
        //     ->orderBy("idSurah")
        //     ->join('ayat_indopak', 'ayat.id', '=', 'ayat_indopak.id');

        // $ayat = array_map(function($item) {
        //     return [
        //         "arabic" => str_replace("بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ ", "", $item["arabic"]),
        //         "id" => $item["id"],
        //     ];
        // }, $ayat);

        // foreach ($ayat as $item) {
        //     Ayat::where("id", $item["id"])
        //         ->update(["arabic" => $item["arabic"]]);
        // }

        $bismillah = Ayat::where("idSurah", 1)
            ->where("nomor", 1)
            ->first();

        $bismillahIndopak = DB::table('ayat')
            ->where('idSurah', 1)
            ->where('nomor', 1)
            ->join('ayat_indopak', 'ayat.id', '=', 'ayat_indopak.id')
            ->first();

        $bismillahUtsmani = DB::table('ayat')
            ->where('idSurah', 1)
            ->where('nomor', 1)
            ->join('ayat_ustmani', 'ayat.id', '=', 'ayat_ustmani.id')
            ->first();

        //Add Bismillah except At Taubah
        $surah = Surah::where("id", "!=", 9)
            ->where("id", "!=", 1)
            ->get();

        foreach ($surah as $item) {
            $id = Uuid::uuid4();
            Ayat::create([
                "id" => $id,
                "translation" => $bismillah["translation"],
                "nomor" => 0,
                "latin" => $bismillah["latin"],
                "idSurah" => $item["id"],
            ]);
            AyatIndopak::create([
                "id" => $id,
                "arabic" => $bismillahIndopak->arabic
            ]);
            AyatUstmani::create([
                "id" => $id,
                "arabic" => $bismillahUtsmani->arabic
            ]);
        }

        return new BaseResource(
            200,
            "Success Modify Surah",
            null
        );
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = Http::get("https://api.npoint.io/99c279bb173a6e28359c/surat/$id");
        $response = $request->json();
        $validation = Ayat::where("idSurah", (int)$id)->get();

        foreach ($response as $item) {
            // $validation = Ayat::where("idSurah", (int)$id)->get();


            if(count($validation) == 0) {
                Ayat::create([
                    "id" => Uuid::uuid4(),
                    // "arabic" => $item["ar"],
                    "translation" => $item["id"],
                    "nomor" => (int)$item["nomor"],
                    "latin" => $item["tr"],
                    "idSurah" => (int)$id
                ]);
            }
        }

        return response()->json(new BaseResource(
            200,
            "Data Surah",
            Ayat::where("idSurah", (int)$id)
                ->orderBy("nomor")
                ->get()
        ), 200);
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
