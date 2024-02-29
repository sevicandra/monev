<?php

namespace App\Http\Controllers;

use App\Models\nomor;
use GuzzleHttp\Client;
use App\Models\tagihan;
use App\Models\register;
use App\Models\logtagihan;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Str;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use Endroid\QrCode\Logo\Logo;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Gate;
use Endroid\QrCode\Encoding\Encoding;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\ClientException;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeShrink;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;

class RegisterController extends Controller
{
    private $_client;

    public function __construct()
    {
        $this->_client = new Client([
            'base_uri' => config('esign.uri'),
            'verify' => false,
            'auth' => [config('esign.id'), config('esign.password')]
        ]);
    }

    public function index()
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }
        return view('register_tagihan.index', [
            'data' => register::registerppk()->where('status', 0)->where('tahun', session()->get('tahun'))->search()->orderby('nomor', 'DESC')->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }


    public function create()
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }
        return view('register_tagihan.create', [
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            $ppk_id = auth()->user()->nip;
        }

        if (Gate::allows('Staf_PPK')) {
            $ppk_id = auth()->user()->mapingstafppk->ppk_id;
        }

        $nomor = nomor::where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'))->first();
        register::create([
            'tahun' => session()->get('tahun'),
            'kodesatker' => auth()->user()->satker,
            'ppk_id' => $ppk_id,
            'nomor' => $nomor->nomor,
            'ekstensi' => $nomor->ekstensi,
            'status' => 0,
            'file' => 'register/' . Str::uuid()->toString() . '.pdf'
        ]);
        $nomor->update([
            'nomor' => $nomor->nomor + 1
        ]);
        return redirect('/register')->with('berhasil', 'Register Berhasil Ditambahkan');
    }

    public function show(register $register)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($register->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if ($register->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
        }

        return view('register_tagihan.detail', [
            'data' => $register->tagihan,
            'register' => $register,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function destroy(register $register)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($register->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if ($register->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
        }
        foreach ($register->register_tagihan as $key) {
            $key->delete();
        }
        $register->delete();
        return redirect('/register')->with('berhasil', 'Register Berhasil Di Hapus');
    }

    public function detailcreate(register $register)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (Gate::allows('PPK')) {
            if ($register->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if ($register->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
        }
        return view('register_tagihan.create_detail', [
            'data' => tagihan::tagihansatker()->tagihanppk()->notregistered()->get(),
            'register' => $register,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function preview(register $register)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (Gate::allows('PPK')) {
            if ($register->ppk_id != auth()->user()->nip) {
                abort(403);
            }
            $ppk = auth()->user()->nama;
        }

        if (Gate::allows('Staf_PPK')) {
            if ($register->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
            $ppk = auth()->user()->mapingstafppk->ppk->nama;
        }
        ob_start();
        $html2pdf = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(5, 5, 5, 5));
        $html2pdf->addFont('Arial');
        $html2pdf->writeHTML(view('register_tagihan.surat', [
            'data' => $register->tagihan,
            'register' => $register,
            'ppk' => $ppk,
        ]));
        $html2pdf->output('register_tagihan.pdf');
    }

    public function esign(Request $request, register $register)
    {
        if (!Gate::allows('PPK')) {
            abort(403);
        }
        if (Gate::allows('PPK')) {
            if ($register->ppk_id != auth()->user()->nip) {
                abort(403);
            }
            $ppk = auth()->user()->nama;
        }

        if ($request->_method === 'POST') {
            $request->validate([
                'passphrase' => 'required'
            ]);

            $qr = config('app.url') .  '/file-view/' . $register->file;
            $writer = new PngWriter();
            $qrCode = QrCode::create($qr)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                ->setSize(100)
                ->setMargin(0)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeShrink())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));
            $image_path = 'img/logo.jpeg';
            $image_data = base64_encode(file_get_contents($image_path));
            $image_type = pathinfo($image_path, PATHINFO_EXTENSION);
            // Generate data URI
            $src_img = 'data:image/' . $image_type . ';base64,' . $image_data;

            $logo = Logo::create($src_img)
                ->setResizeToWidth(20);

            $result = $writer->write($qrCode, $logo);
            $qrcode = $result->getDataUri();

            Pdf::setOption(['dpi' => 1000, 'defaultFont' => 'Arial']);
            Pdf::setOption('A4', 'portrait');
            $pdf = Pdf::loadView('register_tagihan.surat_esign', [
                'data' => $register->tagihan,
                'register' => $register,
                'qrcode' => $qrcode,
                'ppk' => $ppk
            ]);
            $content = $pdf->download()->getOriginalContent();
            Storage::delete($register->file);
            Storage::put($register->file, $content);
            try {
                $response = $this->_client->request('POST', 'pdf', [
                    'query' => [
                        'nik' => $request->session()->get('nik'),
                        'passphrase' => $request->passphrase,
                        'jenis_dokumen' => 'Register Tagihan',
                        'nomor' => $register->nomor . $register->ekstensi . $register->tahun,
                        'tujuan' => 'Pejabat Penandatangan SPM',
                        'perihal' => 'Register Tagihan',
                        'info' => 'Register Tagihan',
                        'tampilan' => 'invisible'
                    ],
                    'multipart' => [
                        [
                            'name'     => 'file',
                            'contents' => Storage::get($register->file),
                            'filename' => explode('/', $register->file)[1]
                        ]
                    ]
                ]);

                $result_header = $response->getHeaders();
                $result_body = $response->getBody()->getContents();

                Storage::put($register->file, $result_body);
                $register->update([
                    'dokumen_date' => $result_header['Date'][0],
                    'dokumen_id' => $result_header['id_dokumen'][0],
                    'status' => 1
                ]);

                foreach ($register->tagihan as $tagihan) {
                    $tagihan->update(['status' => 2]);
                    logtagihan::create([
                        'tagihan_id' => $tagihan->id,
                        'action' => 'Esign',
                        'user' => auth()->user()->nama,
                        'catatan' => ''
                    ]);
                }

                return redirect('/register')->with('berhasil', 'Proses penandatanganan berhasil!');
            } catch (ClientException $th) {
                $response = $th->getResponse();
                $responseBodyAsString = json_decode($response->getBody()->getContents(), true);
                return redirect('/register')->with('gagal', $responseBodyAsString['error']);
            }
        }
        return view('register_tagihan.esign', [
            'notifikasi' => Notification::Notif()
        ]);
    }
}
