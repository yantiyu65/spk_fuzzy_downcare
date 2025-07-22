<?php

namespace App\Http\Controllers\User;

use App\Models\PerkembanganAnak;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RekomendasiTerapiController extends Controller
{
    public function index()
    {
        $data = PerkembanganAnak::where('user_id', Auth::id())
            ->latest()
            ->first();

        if (!$data) {
            return redirect()->route('user.perkembangan-anak.index')
                             ->with('warning', 'Data perkembangan belum tersedia.');
        }

        $rincian = $this->rincianRekomendasi($data->kategori, $data->kategori_usia);

        return view('user.perkembangan-anak.rekomendasi', [
            'data' => $data,
            'rincian' => $rincian,
        ]);
    }

    private function rincianRekomendasi($kategori, $usia)
    {
        $rentangUsia = $usia;

        $kategoriMap = [
            'Stimulus Perkembangan Anak: Rendah' => 'rendah',
            'Stimulus Perkembangan Anak: Sedang' => 'sedang',
            'Stimulus Perkembangan Anak: Tinggi' => 'tinggi',
        ];

        $kategoriKey = $kategoriMap[$kategori] ?? 'rendah';

        $rekomendasi = [
            'rendah' => [
                'rumah_sakit' => [
                    '0-2' => [
                        'Terapi okupasi awal untuk refleks dasar dan stimulasi sensorik ringan.',
                        'Terapi wicara pasif seperti mendengarkan suara orang tua atau musik lembut.',
                        'Pantauan fisioterapi dasar untuk gerak refleks dan tonus otot bayi.',
                    ],
                    '2-5' => [
                        'Terapi okupasi 2–3x/minggu untuk stimulasi sensorik dan motorik dasar.',
                        'Terapi wicara dengan pendekatan visual dan permainan bunyi sederhana.',
                        'Konsultasi perkembangan anak dan evaluasi fisioterapi rutin.',
                    ],
                    'default' => [
                        'Terapi okupasi intensif dengan target peningkatan kemandirian dasar.',
                        'Terapi wicara dengan fokus pada ekspresi satu-dua kata bermakna.',
                        'Fisioterapi untuk melatih kontrol tubuh dan keseimbangan dasar.',
                    ]
                ],
                'rumah' => [
                    '0-2' => [
                        'Sering ajak bayi bicara sambil menatap matanya.',
                        'Stimulasi motorik lewat tummy time atau bermain dengan mainan tekstur berbeda.',
                        'Responsif terhadap tangisan dan ekspresi untuk membangun koneksi emosi.',
                    ],
                    '2-5' => [
                        'Ajarkan anak menunjuk dan menyebut benda sehari-hari.',
                        'Lakukan aktivitas motorik seperti melempar bola besar atau berjalan di garis lurus.',
                        'Rutinitas konsisten seperti menyikat gigi bersama dengan contoh langsung.',
                    ],
                    'default' => [
                        'Lanjutkan kegiatan interaktif dengan musik, gambar, dan permainan nama benda.',
                        'Stimulasi gerak dengan meniru gerakan, naik-turun tangga, atau memindahkan benda.',
                        'Latih anak memilih pakaian atau peralatan makan secara mandiri.',
                    ]
                ]
            ],
            'sedang' => [
                'rumah_sakit' => [
                    '0-2' => [
                        'Konsultasi rutin untuk pemantauan stimulasi sensori dan wicara pasif.',
                        'Fisioterapi ringan untuk fleksibilitas dan pelenturan otot dasar.',
                        'Terapi wicara pasif melalui pengenalan suara, lagu, dan ekspresi wajah.',
                    ],
                    'default' => [
                        'Terapi wicara untuk memperpanjang kalimat dan memahami instruksi sederhana.',
                        'Okupasi untuk melatih koordinasi tangan dan aktivitas fungsional seperti meronce atau menyusun balok.',
                        'Fisioterapi ringan untuk koordinasi tubuh dan latihan keseimbangan dinamis.',
                    ]
                ],
                'rumah' => [
                    '0-2' => [
                        'Berikan stimulus lewat mainan warna-warni dan suara lembut.',
                        'Peluk dan timang bayi sambil menyanyikan lagu sederhana.',
                        'Ajari ekspresi wajah dengan bermain cermin bersama bayi.',
                    ],
                    'default' => [
                        'Permainan “ayo ambil” atau “tunjuk mana...” dengan gambar atau mainan.',
                        'Latih aktivitas rumah tangga sederhana seperti menyusun meja atau mengambil sendok.',
                        'Gunakan cerita gambar untuk latihan narasi pendek dan pengenalan emosi.',
                    ]
                ]
            ],
            'tinggi' => [
                'rumah_sakit' => [
                    '0-2' => [
                        'Pemantauan perkembangan untuk mengidentifikasi kelebihan stimulasi.',
                        'Terapi interaktif untuk mempertahankan respons positif anak.',
                        'Bimbingan orang tua tentang stimulasi lanjutan sesuai usia.',
                    ],
                    'default' => [
                        'Terapi wicara lanjutan untuk memperkaya kosakata dan dialog.',
                        'Kelas keterampilan seperti menulis nama sendiri, mengenal uang, atau menyebut hari.',
                        'Program sosial untuk melatih interaksi teman sebaya dalam kelompok kecil.',
                    ]
                ],
                'rumah' => [
                    '0-2' => [
                        'Ajarkan suara hewan, ekspresi wajah, atau lagu dengan gerakan tangan.',
                        'Berikan mainan edukatif yang merangsang eksplorasi awal.',
                        'Bacakan buku bergambar dan tunjukkan sambil menyebutkan benda-benda.',
                    ],
                    'default' => [
                        'Ajak anak bercerita tentang kegiatan harian menggunakan bahasa sederhana.',
                        'Libatkan anak dalam aktivitas harian seperti menyapu, merapikan mainan, atau membuat jus.',
                        'Perkuat kemandirian dengan memberi tanggung jawab kecil seperti menyiapkan tas atau baju.',
                    ]
                ]
            ]
        ];

        $kategoriData = $rekomendasi[$kategoriKey];

        $rs = $kategoriData['rumah_sakit'][$rentangUsia] ?? $kategoriData['rumah_sakit']['default'];
        $rh = $kategoriData['rumah'][$rentangUsia] ?? $kategoriData['rumah']['default'];

        return [
            'rumah_sakit' => $rs,
            'rumah' => $rh,
        ];
    }
}
