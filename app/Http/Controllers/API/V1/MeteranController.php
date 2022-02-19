<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Meterans\MeteranRequest;
use App\Models\Meteran;
use Illuminate\Http\Request;

class MeteranController extends BaseController
{
    protected $meteran = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Meteran $meteran)
    {
        $this->middleware('auth:api');
        $this->meteran = $meteran;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('isAdmin');
        $meterans = $this->meteran->join('pelanggans','meterans.pelanggan_id','pelanggans.id')
        ->where([
            ['pelanggan_id',$request->pelanggan],
            ['periode',$request->tahun],
            ['bulan',$request->bulan],
        ])
        ->latest('meterans.created_at')->paginate(10);

        return $this->sendResponse($meterans, 'Meteran list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeteranRequest $request)
    {
        $pemakaian = $request->get('akhir')-$request->get('awal');
        $meteran = $this->meteran->create([
            'pelanggan_id' => $request->get('pelanggan_id'),
            'periode' => $request->get('periode'),
            'bulan' => $request->get('bulan'),
            'awal' => $request->get('awal'),
            'akhir' => $request->get('akhir'),
            'pemakaian' => $pemakaian,
        ]);

        return $this->sendResponse($meteran, 'Meteran Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meteran = $this->meteran->findOrFail($id);

        return $this->sendResponse($meteran, 'Meteran Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeterannRequest $request, $id)
    {
        $meteran = $this->meteran->findOrFail($id);

        $meteran->update($request->all());

        return $this->sendResponse($meteran, 'Meteran Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $meteran = $this->meteran->findOrFail($id);

        $meteran->delete();

        return $this->sendResponse($meteran, 'Meteran has been Deleted');
    }
}
