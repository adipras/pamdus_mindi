<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Pelanggans\PelangganRequest;
use App\Models\Pelanggan;

class PelangganController extends BaseController
{
    protected $pelanggan = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Pelanggan $pelanggan)
    {
        $this->middleware('auth:api');
        $this->pelanggan = $pelanggan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isAdmin');
        $pelanggans = $this->pelanggan->latest()->paginate(10);

        return $this->sendResponse($pelanggans, 'Pelanggan list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PelangganRequest $request)
    {
        $pelanggan = $this->pelanggan->create([
            'no_meteran' => $request->get('no_meteran'),
            'nama' => $request->get('nama'),
            'nik' => $request->get('nik'),
            'address' => $request->get('address'),
        ]);

        return $this->sendResponse($pelanggan, 'Pelanggan Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelanggan = $this->pelanggan->findOrFail($id);

        return $this->sendResponse($pelanggan, 'Pelanggan Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PelangganRequest $request, $id)
    {
        $pelanggan = $this->pelanggan->findOrFail($id);

        $pelanggan->update($request->all());

        return $this->sendResponse($pelanggan, 'Pelanggan Information has been updated');
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

        $pelanggan = $this->pelanggan->findOrFail($id);

        $pelanggan->delete();

        return $this->sendResponse($pelanggan, 'Pelanggan has been Deleted');
    }
}
