<?php

namespace App\Http\Controllers;

use App\Models\nomor;
use GuzzleHttp\Client;
use App\Models\tagihan;
use App\Models\register;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use Endroid\QrCode\Logo\Logo;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Http;
use Endroid\QrCode\Encoding\Encoding;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\UpdateregisterRequest;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('register_tagihan.index',[
            'data'=>register::where('status', '<', 1)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('register_tagihan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreregisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nomor=nomor::where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'))->first();
        register::create([
            'tahun'=>session()->get('tahun'),
            'kodesatker'=>auth()->user()->satker,
            'ppk'=>auth()->user()->nip,
            'nomor'=>$nomor->nomor,
            'ekstensi'=>$nomor->ekstensi,
            'status'=>0,
            'file'=>'register/'.Str::uuid()->toString().'.pdf'
        ]);
        $nomor->update([
            'nomor'=>$nomor->nomor+1
        ]);
        return redirect('/register')->with('berhasil', 'Register Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\register  $register
     * @return \Illuminate\Http\Response
     */
    public function show(register $register)
    {
        return view('register_tagihan.detail',[
            'data'=>$register->tagihan,
            'register'=>$register
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\register  $register
     * @return \Illuminate\Http\Response
     */
    public function edit(register $register)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateregisterRequest  $request
     * @param  \App\Models\register  $register
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateregisterRequest $request, register $register)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\register  $register
     * @return \Illuminate\Http\Response
     */
    public function destroy(register $register)
    {
        foreach ($register->register_tagihan as $key) {
            $key->delete();
        }
        $register->delete();
        return redirect('/register')->with('berhasil', 'Register Berhasil Di Hapus');
    }

    public function detailcreate(register $register)
    {
        return view('register_tagihan.create_detail',[
        'data'=>tagihan::notregistered()->get(),
        'register'=>$register
        ]);
    }
    public function preview(register $register)
    {

        ob_start();
        $html2pdf = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $image = file_get_contents(config('app.url').'/img/logo.jpeg');
        $html2pdf->writeHTML(view('register_tagihan.surat',[
            'data'=>$register->tagihan,
            'register'=>$register,
            'logo'=>$image
        ]));
        $html2pdf->output('register_tagihan.pdf');
    }

    public function esign(Request $request, register $register)
    {
        
        if ($request->_method === 'POST') {
            $request->validate([
                'passphrase'=>'required'
            ]);

            $qr = config('app.url') .  '/' . $register->file;
            $writer = new PngWriter();
            $qrCode = QrCode::create($qr)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                ->setSize(100)
                ->setMargin(0)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeShrink())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));
            $logo = Logo::create(config('app.url'). '/img/kemenkeu_color.png')
                ->setResizeToWidth(20);
            $result = $writer->write($qrCode, $logo);
            $qrcode = $result->getDataUri();
            $image = file_get_contents(config('app.url').'/img/logo.jpeg');
            
    
            Pdf::setOption(['dpi' => 1000, 'defaultFont' => 'Arial']);
            Pdf::setOption('A4', 'portrait');
            $pdf = Pdf::loadView('register_tagihan.surat_esign',[
                'data'=>$register->tagihan,
                'register'=>$register,
                'logo'=>$image,
                'qrcode'=>$qrcode
            ]);
            $content = $pdf->download()->getOriginalContent();
    
            Storage::put($register->file,$content) ;
            try {
                $response = $this->_client->request('POST', 'pdf', [
                    'query' => [
                        'nik' => '',
                        'passphrase' => htmlspecialchars($request->passphrase),
                        'jenis_dokumen' => 'Register Tagihan',
                        'nomor' => $register->nomor.$register->ekstensi.$register->tahun,
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
                Storage::put($register->file, $result_body) ;
                $register->update([
                    'dokumen_date' => $result_header['Date'][0],
                    'dokumen_id' => $result_header['id_dokumen'][0],
                    'status' => 1
                ]);

                foreach ($register->tagihan as $tagihan) {
                    $tagihan->update(['status'=>2]);
                }

                return redirect('/register')->with('berhasil','Proses penandatanganan berhasil!');
            } catch (ClientException $th) {
                $response = $th->getResponse();
                $responseBodyAsString = json_decode($response->getBody()->getContents(), true);
                return redirect('/register')->with('gagal',$responseBodyAsString['error']);
            }
        }
        return view('register_tagihan.esign');
    }
}
