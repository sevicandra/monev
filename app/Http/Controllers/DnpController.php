<?php

namespace App\Http\Controllers;

use App\Models\dnp;
use App\Models\tagihan;
use App\Helper\Notification;
use Spipu\Html2Pdf\Html2Pdf;
use App\Models\pegawainondjkn;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class DnpController extends Controller
{
    public function index(tagihan $tagihan)
    {
        if (! Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        return view('tagihan.dnp.index',[
            'data'=>$tagihan->dnp()->search()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create(tagihan $tagihan)
    {
        if (! Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        if ($tagihan->status != 0) {
            return abort(403);
        }
        if ($tagihan->dokumen->statusdnp != '1') {
            abort(403);
        }
        if (request('nama')) {
            $response = Http::withBasicAuth(config('alika.id'), config('alika.password'))->get(config('alika.uri').'data-pegawai',[
                'keyword'=>request('nama'),
                'limit' => null,
                'offset' => 0,
                'X-API-KEY'=>config('alika.api'),
            ]);
            return view('tagihan.dnp.tarik_pegawai_gaji',[
                'data'=>collect(json_decode($response->getBody()->getContents(), false)),
                'tagihan'=>$tagihan,
                'notifikasi'=>Notification::Notif()
            ]);
        }else{
            return view('tagihan.dnp.tarik_pegawai_gaji',[
                'data'=>[],
                'tagihan'=>$tagihan,
                'notifikasi'=>Notification::Notif()
            ]);
        }
    }

    public function create_non_djkn(tagihan $tagihan)
    {
        if (! Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }
        if ($tagihan->status != 0) {
            return abort(403);
        }
        if ($tagihan->dokumen->statusdnp != '1') {
            abort(403);
        }
        return view('tagihan.dnp.tarik_pegawai_nondjkn',[
            'data'=>pegawainondjkn::search()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(tagihan $tagihan, $nip)
    {
        if (! Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }
        if ($tagihan->status != 0) {
            return abort(403);
        }
        if ($tagihan->dokumen->statusdnp != '1') {
            abort(403);
        }
        
        $response = Http::withBasicAuth(config('alika.id'), config('alika.password'))->get(config('alika.uri').'data-pegawai',[
            'keyword' => $nip,
            'limit' => null,
            'offset' => 0,
            'X-API-KEY'=>config('alika.api'),
        ]);
        
        foreach (collect(json_decode($response->getBody()->getContents(), true)) as $key) {
            $kdgol = substr($key['kdgol'], 0, 1);
            dnp::create([
                'tagihan_id'=>$tagihan->id,
                'nip'=>$key['nip'],
                'nama'=>$key['nmpeg'],
                'kodegolongan'=>$kdgol,
                'rekening'=>$key['rekening'],
                'namabank'=>$key['nm_bank'],
                'namarekening'=>$key['nmrek'],
            ]);
        }

        return redirect('/tagihan/'.$tagihan->id.'/dnp')->with('berhasil', 'Data Pegawai Berhasil Di Tambahkan');
    }

    public function store_non_djkn(tagihan $tagihan,pegawainondjkn $pegawainondjkn)
    {
        if (! Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }
        
        if ($tagihan->status != 0) {
            return abort(403);
        }
        if ($tagihan->dokumen->statusdnp != '1') {
            abort(403);
        }
        $kdgol = substr($pegawainondjkn->kodegolongan, 0, 1);
        dnp::create([
            'tagihan_id'=>$tagihan->id,
            'nip'=>$pegawainondjkn->nip,
            'nama'=>$pegawainondjkn->nama,
            'kodegolongan'=>$kdgol,
            'rekening'=>$pegawainondjkn->rekening,
            'namabank'=>$pegawainondjkn->namabank,
            'namarekening'=>$pegawainondjkn->namarekening,
        ]);

        return redirect('/tagihan/'.$tagihan->id.'/dnp')->with('berhasil', 'Data Pegawai Berhasil Di Tambahkan');
    }

    public function destroy(tagihan $tagihan, dnp $dnp)
    {
        if (! Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        if ($tagihan->status != 0) {
            return abort(403);
        }
        $dnp->delete();
        return redirect('/tagihan/'.$tagihan->id.'/dnp')->with('berhasil', 'Data Pegawai Berhasil Di Hapus');
    }

    public function cetak(tagihan $tagihan)
    {
        if (! Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }
        ob_start();
        $html2pdf = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->writeHTML(view('tagihan.dnp.cetak',[
            'data'=>$tagihan,
        ]));
        $html2pdf->output('register_tagihan.pdf');
    }
}
