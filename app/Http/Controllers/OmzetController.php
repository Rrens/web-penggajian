<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Omzet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OmzetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::now();
        // $date = Carbon::createFromFormat('d/m/Y',  '19/04/2000');
        $month = $date->month;
        $year = $date->year;
        // $month = 1;
        // dd($date);
        $omzet = DB::table('cabangs as c')
            ->select('c.nama_cabang', DB::raw('MONTH(o.date) as date'), 'o.omzet', 'c.id as id', 'o.id as id_omzet')
            ->join('omzet as o', 'o.id_cabang', '=', 'c.id')
            ->whereMonth('o.date', '=', $month)
            ->whereYear('o.date', '=', $year)
            // ->groupBy(DB::raw('YEAR(date)'))
            ->get();


        $omzet_old =
            DB::table('omzet as o')
            ->select('c.nama_cabang', DB::raw('MONTH(o.date) as date'), 'o.omzet', 'c.id as id', 'o.id_cabang')
            ->join('cabangs as c', 'o.id_cabang', '=', 'c.id')
            // ->whereMonth('o.date', '!=', $month)
            // ->whereYear('o.date', '!=', $year)
            ->groupBy('o.id')
            ->orderBy('o.id', 'desc')
            ->paginate(10);
        // dd($omzet_old);
        if (empty($omzet[0])) {
            DB::table('omzet')->insert(
                [
                    [
                        'id_cabang' => 1,
                        'date' => $date
                    ],
                    [
                        'id_cabang' => 2,
                        'date' => $date
                    ],
                    [
                        'id_cabang' => 3,
                        'date' => $date
                    ],
                    [
                        'id_cabang' => 4,
                        'date' => $date
                    ],

                ]
            );
            $omzet = DB::table('cabangs as c')
                ->select('c.nama_cabang', DB::raw('MONTH(o.date) as date'), 'o.omzet', 'c.id as id', 'o.id as id_omzet')
                ->join('omzet as o', 'o.id_cabang', '=', 'c.id')
                ->whereMonth('o.date',  $month)
                ->get();
        }
        // $omzet = Cabang::whereMonth($)
        // dd($omzet);
        return view('owner.omzet.index', compact('omzet', 'omzet_old'));
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
        //
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
        // dd($request->all());
        $validator = Validator::make(request()->all(), [
            // 'id_jabatan' => 'required',
            'id' => 'required',
            'omzet' => 'required',
            'id_omzet' => 'required'
        ]);

        if ($validator->fails()) {
            dd($validator->errors());
            return back()->withErrors($validator->errors());
        } else {

            $bonus = Omzet::findOrFail($request->id_omzet);
            // dd($bonus);

            // $bonus->id_jabatan = $request->get('id_jabatan');
            // $bonus->id = $request->get('id');
            $bonus->updated_at = Carbon::now();
            $bonus->omzet = $request->get('omzet');
            $bonus->save();
            Alert::success('Success', 'Omzet berhasil diubah');
            // dd($bonus->save());

            return redirect()->back();
        }
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
