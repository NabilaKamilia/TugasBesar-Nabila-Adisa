<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Jenis;

use Illuminate\Http\Request;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    

    public function index(Request $request)
    {
        // $dashboards = Dashboard::all();
        //Eloquent untuk menampilkan data resep, dengan atau tanpa search
        $dashboards = Dashboard::where([
            ['plat_nomor', '!=', null, 'OR', 'nama_pemilik', '!=', null ], //ketika form search kosong, maka request akan null. Ambil semua data di database
            [function ($query) use ($request) {
                if (($keyword = $request->keyword)) {
                    $query->orWhere('plat_nomor', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('nama_pemilik', 'LIKE', '%' . $keyword . '%')
                        ->get(); //ketika form search terisi, request tidak null. Ambil data sesuai keyword
                }
            }]
        ])
            ->orderBy('id', 'desc')
            ->paginate(5);

            $dashboard_relasi = Dashboard::with('jenis')
            ->orderBy('id')
            ->paginate(5);

            return view('dashboard', compact('dashboards', 'dashboard_relasi'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenises = Jenis::all(); 
        return view('create', compact('jenises'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required',
            'nama_pemilik' => 'required',
            'jenis_mobil' => 'required',
            'harga' => 'required',
            'status' => 'required',
        ]);

        Dashboard::create([
            'plat_nomor' => $request -> plat_nomor,
            'nama_pemilik' => $request -> nama_pemilik,
            'jenis_id' => $request -> jenis_mobil,
            'harga' => $request -> harga,
            'status' => $request -> status,
        ]);

        // return redirect('/dashboard')->with('status', 'Mobil Ditambahkan!');
        return redirect('/dashboard');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        return view('detail', compact('dashboard' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $dashboard = Dashboard::find($id);
        $jenises = Jenis::all(); 
        return view('edit', compact('jenises','dashboard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        $request->validate([
            'plat_nomor' => 'required',
            'nama_pemilik' => 'required',
            'jenis_mobil' => 'required',
            'layanan' => 'required',
            'harga' => 'required',
            'status' => 'required',
        ]);
        
        Dashboard::where('id', $dashboard->id) 
                    ->update([
                    'plat_nomor' => $request -> plat_nomor,
                    'nama_pemilik' => $request -> nama_pemilik,
                    'jenis_mobil' => $request -> jenis_mobil,
                    'layanan' => $request ->layanan,
                    'harga' => $request -> harga,
                    'status' => $request -> status,
                    ]);

        return redirect('/dashboard')->with('status', 'Mobil Diupdate!');
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    

    public function destroy(Dashboard $dashboard)
    {
        Dashboard::destroy($dashboard->id);
        return redirect('/dashboard')->with('status', 'Mobil Telah Dipahus!');
    }
}
