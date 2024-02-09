<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KartuSantriModel;
use App\Models\RegisSiswa;
use \Hermawan\DataTables\DataTable;
use \Ramsey\Uuid\Uuid;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class KartuSantri extends BaseController
{
    function __construct()
    {
        $this->kartu = new KartuSantriModel();
        $this->registrasi = new RegisSiswa();
    }
    public function index()
    {
        $data = [
            'title' => 'Kartu Santri',
            'menu' => 'kartu',
            'sub' => ''
        ];
        return view('admin/data-kartu',$data);
    }

    public function getData()
    {
        if($this->request->isAJAX()){
            $builder = $this->kartu->get();
            return DataTable::of($builder)
                        ->add('centang',function($row){
                            $check = '<input type="checkbox" value="'.$row->id_kartu.'" name="idsantri[]" class="centangid">';
                            return $check;
                        })
                        ->add('qr',function($row){
                            return '<img src="'.$row->qrcode.'" alt="'.$row->nocard.'" style="width: 50px;">';
                        })

                        ->add('rf',function($row){
                            if($row->rfid == null){
                                return '<button type="button" id="'. $row->id_kartu.'" class="btn btn-info btn-sm"><i class="bi bi-credit-card"></i></button>';
                            }else{
                                return '<button type="button" class="btn btn-warning btn-sm"><i class="bi bi-credit-card"></i></button>';
                                
                            }
                        })
                        ->add('info',function($row){
                            if($row->status == '0'){
                                return '<button type="button" id="'. $row->id_kartu.'" class="btn btn-danger btn-sm btn-status"><i class="bi bi-power"></i> Non Active</button>';
                            }else{
                                return '<button type="button" class="btn btn-primary btn-sm"><i class="bi bi-power"></i> Active</button>';
                                
                            }
                        })
                        ->add('aksi',function($row){
                                $html = '<button type="button" id="'. $row->id_santri.'"  class="btn btn-primary btn-sm btn-status me-1"><i class="bi bi-printer"></i></button>';
                                $html .= '<button type="button" id="'. $row->id_santri.'"  class="btn btn-danger btn-sm btn-status"><i class="bi bi-trash"></i></button>';
                                return $html;
                        })
                        ->toJson(true);
        }
    }

    public function generateKartu()
    {
        if($this->request->isAJAX())
        {
            $santri = $this->registrasi->getData(['id_tahun'=> getTahun()->id_tahun,'status'=> 1])->findAll();
            $berhasil = $gagal = 0 ;
            foreach ($santri as $santri) {
                $ceksantri = $this->kartu->get(['santri.id_santri'=> $santri->id_santri])->first();
                if($ceksantri){
                    $gagal++;
                }else{
                    // generate kartu
                    $writer = new PngWriter();
                    $barcode = createRandom(6);
                    $qrCode = QrCode::create($barcode)
                        ->setEncoding(new Encoding('UTF-8'))
                        ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                        ->setSize(300)
                        ->setMargin(10)
                        ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                        ->setForegroundColor(new Color(0, 0, 0))
                        ->setBackgroundColor(new Color(255, 255, 255));
                    $logo = Logo::create( FCPATH .'logo.png')
                        ->setResizeToWidth(70);
                    $label = Label::create($barcode)
                        ->setTextColor(new Color(255, 0, 0));

                    $result = $writer->write($qrCode, $logo, $label);
                    $qr = $result->getDataUri();
                    $save = $this->kartu->insert([
                        'id_kartu' => Uuid::uuid4()->toString(),
                        'id_santri' => $santri->id_santri,
                        'nocard' => $barcode,
                        'qrcode' => $qr,
                        'password' => password_hash('123456',PASSWORD_DEFAULT),
                        'status' => '1'
                    ]);
                    if($save){
                        $berhasil++;
                    }
                }
            }
            $msg=[
                'sukses' =>[
                    'icon' => 'success',
                    'head' => 'Hore..!',
                    'pesan' => $berhasil . ' Berhasil Di Tambahkan ,'. $gagal . ' Gagal Ditambahkan'
                ]
            ];
            echo json_encode($msg);

        }
    }
}
