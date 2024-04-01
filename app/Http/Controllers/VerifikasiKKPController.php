<?php

namespace App\Http\Controllers;

use App\Models\berkas;
use App\Models\tagihan;
use App\Models\logtagihan;
use App\Helper\Notification;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class VerifikasiKKPController extends Controller
{
    public function index()
    {
        if (! Gate::allows('ValidatorKKP')) {
            abort(403);
        }
        
        return view('verifikasi_kkp.index',[
            'data'=>tagihan::tagihansatker()->tagihanverifikatorKKP()->unverified()->search()->order()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function show(tagihan $verifikasi_kkp)
    {
        if (! Gate::allows('ValidatorKKP')) {
            abort(403);
        }

        if ($verifikasi_kkp->status != 2) {
            abort(403);
        }
        
        return view('uploadberkas.index',[
            'data'=>$verifikasi_kkp->berkasupload()->with('berkas')->get(),
            'back'=>'/verifikasi-kkp',
            'upload'=>'/verifikasi-kkp/'.$verifikasi_kkp->id.'/upload',
            'delete'=>'/verifikasi-kkp/'.$verifikasi_kkp->id.'/upload/',
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function tolak(tagihan $tagihan){
        if (! Gate::allows('ValidatorKKP')) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        $tagihan->update([
            'status'=>0
        ]);
        logtagihan::create([
            'tagihan_id'=>$tagihan->id,
            'action'=>'Tolak',
            'user'=>auth()->user()->nama . " / Verifikator KKP",
            'catatan'=>''
        ]);
        return redirect('/verifikasi-kkp')->with('berhasil','Data Tagihan Berhasil Dikembalikan');
    }

    public function approve(tagihan $tagihan){
        if (! Gate::allows('ValidatorKKP')) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        switch ($tagihan->jnstagihan) {
            case 0:
                $tagihan->update([
                    'status'=>4
                ]);
                logtagihan::create([
                    'tagihan_id'=>$tagihan->id,
                    'action'=>'Approve',
                    'user'=>auth()->user()->nama . " / Verifikator KKP",
                    'catatan'=>''
                ]);
                return redirect('/verifikasi-kkp')->with('berhasil','Data Tagihan Berhasil Diverifikasi');
                break;
            case 1:
                if ($tagihan->tanggal_spm == null) {
                    return back()->with('gagal','Data tidak dapat dikirim karena tanggal SPM belum di input');
                }
                $tagihan->update([
                    'status'=>3
                ]);
                logtagihan::create([
                    'tagihan_id'=>$tagihan->id,
                    'action'=>'Approve',
                    'user'=>auth()->user()->nama . " / Verifikator KKP",
                    'catatan'=>''
                ]);
                return redirect('/verifikasi-kkp')->with('berhasil','Data Tagihan Berhasil Diverifikasi');
                break;
            case 2:
                $tagihan->update([
                    'status'=>4
                ]);
                logtagihan::create([
                    'tagihan_id'=>$tagihan->id,
                    'action'=>'Approve',
                    'user'=>auth()->user()->nama . " / Verifikator KKP",
                    'catatan'=>''
                ]);
                return redirect('/verifikasi-kkp')->with('berhasil','Data Tagihan Berhasil Diverifikasi');
                break;
        }
    }

    public function upload(Request $request, tagihan $tagihan, berkasupload $berkas){
        if (! Gate::allows('ValidatorKKP')) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            return abort(403);
        }
        
        if ($request->_method === 'PATCH') {
            $request->validate([
                'berkas'=>'required',
                'uraian'=>'required',
                'fileupload'=>'required|mimes:pdf'
            ]);

            $file = $request->file('fileupload')->store('berkas');
            
            berkasupload::create([
                'tagihan_id'=>$tagihan->id,
                'berkas_id'=>$request->berkas,
                'uraian'=>$request->uraian,
                'file'=>$file
            ]);
            return redirect('/verifikasi-kkp/'.$tagihan->id)->with('berhasil','Dokumen Berhasil Ditembahkan');
        }

        if ($request->_method === 'DELETE') {
            if ($tagihan->id != $berkas->tagihan_id) {
                abort(403);
            }
            if ($berkas->berkas->kodeberkas === '03' || $berkas->berkas->kodeberkas === '04') {
                Storage::delete($berkas->file);
                $berkas->delete();
                return redirect('/verifikasi-kkp/'.$tagihan->id)->with('berhasil','Dokumen Berhasil Di Hapus');
            }else{
                abort(403);
            }
        }

        return view('uploadberkas.upload',[
            'berkas'=>berkas::keuangan()->orderby('kodeberkas')->get(),
            'data'=>$tagihan,
            'back'=>'/verifikasi-kkp/'.$tagihan->id,
            'upload'=>'/verifikasi-kkp/'.$tagihan->id.'/upload',
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function coa(tagihan $tagihan)
    {
        if (! Gate::allows('ValidatorKKP')) {
            abort(403);
        }
        
        return view('verifikasi_kkp.coa',[
            'data'=>$tagihan->realisasi() ->searchprogram()  
                                            ->searchkegiatan()
                                            ->searchkro()
                                            ->searchro()
                                            ->searchkomponen()
                                            ->searchsubkomponen()
                                            ->searchakun()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }
}
