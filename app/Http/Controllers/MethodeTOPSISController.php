<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\AlternatifKriteriaValue;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class MethodeTOPSISController extends Controller
{
    public function index()
    {
        $data = AlternatifKriteriaValue::with('kriteria', 'alternatif')->get();

        return view('menu.methodetopsis', compact('data'));
    }

    public function methodetopsis()
    {

        $alternatif = Alternatif::all();
        $kriteria = Kriteria::all();
        $altkrit = AlternatifKriteriaValue::all();

        // Inisialisasi variable array untuk menyimpan nilai sum, results dan matrix ternormalisasi
        $sum = [];
        $results = [];
        $originalResults = [];

        // Perulangan untuk menghitung matrix ternormalisasi
        foreach ($alternatif as $a) {
            $resultRow = [];

            foreach ($kriteria as $k) {
                $altKriteriaData = $altkrit->where('alternatif_id', $a->id)->where('kriteria_id', $k->id)->first();

                if ($altKriteriaData) {
                    $value = $altKriteriaData->value;

                    $totalKriteriaSquaredSum = AlternatifKriteriaValue::where('kriteria_id', $k->id)
                        ->selectRaw('SUM(POW(value, 2)) as total_squared_sum')
                        ->value('total_squared_sum');

                    $sum[$k->id] = $totalKriteriaSquaredSum;

                    $result = $value / sqrt($totalKriteriaSquaredSum);

                    // Menyimpan hasil asli dalam variabel
                    $resultRow[$k->id] = $result;
                } else {
                    $resultRow[$k->id] = 0;
                }
            }

            $originalResults[$a->id] = $resultRow;
        }


        $weightedResults = [];

        // Perulangan kedua untuk mengalikan hasil asli dengan bobot
        foreach ($originalResults as $a => $resultRow) {
            $weightedResultRow = [];

            foreach ($kriteria as $k) {
                $bobotKriteria = $k->bobot;
                $resultWithWeight = $resultRow[$k->id] * $bobotKriteria;
                $weightedResultRow[$k->id] = $resultWithWeight;
            }

            $weightedResults[$a] = $weightedResultRow;
        }

        $valuesByKriteria = [];

        // Perulangan untuk mengelompokkan nilai berdasarkan id_kriteria
        foreach ($weightedResults as $a => $resultRow) {
            foreach ($resultRow as $k => $value) {
                $idKarakter = $k;
                $idKriteria = $kriteria->find($idKarakter)->id;

                if (!isset($valuesByKriteria[$idKriteria])) {
                    $valuesByKriteria[$idKriteria] = [];
                }

                $valuesByKriteria[$idKriteria][] = $value;
            }
        }

        $Amax = [];
        $Amin = [];

        // Perulangan dan kondisi untuk mencari nilai tertinggi dan terendah pada setiap kriteria yang menyesuaikan dengan attribut yang ada
        foreach ($valuesByKriteria as $idKriteria => $values) {
            $kriteriaObj = $kriteria->find($idKriteria);
            $attribute = $kriteriaObj->attribut;

            if ($attribute === 'Benefit') {
                $maxValue = max($values);
                $Amax[$idKriteria] = $maxValue;
                $minValue = min($values);
                $Amin[$idKriteria] = $minValue;
            } elseif ($attribute === 'Cost') {
                $maxValue = max($values);
                $Amin[$idKriteria] = $maxValue;
                $minValue = min($values);
                $Amax[$idKriteria] = $minValue;
            }
        }

        // Inisialisasi array untuk menyimpan hasil solusi ideal positif dan negatif
        $resultSquaredPositif = [];
        $resultSquaredNegatif = [];

        // Perulangan untuk mencari hasil nilai ideal positif
        foreach ($weightedResults as $a => $resultRow) {
            foreach ($resultRow as $k => $value) {
                $idKriteria = $k;

                $amaxForKriteria = $Amax[$idKriteria];
                $valueAfterSubtraction = $value - $amaxForKriteria;
                $resultSquaredPositif[$a][$k] = pow($valueAfterSubtraction, 2);
            }
        }

        // Perulangan untuk mencari hasil nilai ideal negatif
        foreach ($weightedResults as $a => $resultRow) {
            foreach ($resultRow as $k => $value) {
                $idKriteria = $k;

                $aminForKriteria = $Amin[$idKriteria];
                $valueAfterSubtraction = $value - $aminForKriteria;
                $resultSquaredNegatif[$a][$k] = pow($valueAfterSubtraction, 2);
            }
        }

        // Inisialisasi array untuk menyimpan hasil penjumlahan setiap nilai berdasarkan id_alternatif
        $sumByAlternatifPositif = [];
        $sumByAlternatifNegatif = [];

        // Perulangan untuk mencari hasil penjumlahan nilai ideal positif
        foreach ($resultSquaredPositif as $a => $resultRow) {
            $sumByAlternatifPositif[$a] = 0;

            foreach ($resultRow as $k => $value) {
                $sumByAlternatifPositif[$a] += $value;
            }
        }

        // Perulangan untuk mencari hasil penjumlahan nilai ideal positif
        foreach ($resultSquaredNegatif as $a => $resultRow) {
            $sumByAlternatifNegatif[$a] = 0;

            foreach ($resultRow as $k => $value) {
                $sumByAlternatifNegatif[$a] += $value;
            }
        }

        // Inisalisasi untuk mendapatkan nilai D+ dan D-
        $sqrtByAlternatifPositif = [];
        $sqrtByAlternatifNegatif = [];

        foreach ($sumByAlternatifPositif as $a => $sum) {
            $sqrtByAlternatifPositif[$a] = sqrt($sum);
        }


        foreach ($sumByAlternatifNegatif as $a => $sum) {
            $sqrtByAlternatifNegatif[$a] = sqrt($sum);
        }

        return view('menu.methodetopsis', compact('sqrtByAlternatifNegatif', 'sqrtByAlternatifPositif', 'resultSquaredNegatif', 'resultSquaredPositif', 'Amax', 'Amin', 'originalResults', 'weightedResults', 'alternatif', 'kriteria'));
    }

    public function hasil()
    {

        $alternatif = Alternatif::all();
        $kriteria = Kriteria::all();
        $altkrit = AlternatifKriteriaValue::all();

        // Inisialisasi variable array untuk menyimpan nilai sum, results dan matrix ternormalisasi
        $sum = [];
        $results = [];
        $originalResults = [];

        // Perulangan untuk menghitung matrix ternormalisasi
        foreach ($alternatif as $a) {
            $resultRow = [];

            foreach ($kriteria as $k) {
                $altKriteriaData = $altkrit->where('alternatif_id', $a->id)->where('kriteria_id', $k->id)->first();

                if ($altKriteriaData) {
                    $value = $altKriteriaData->value;

                    $totalKriteriaSquaredSum = AlternatifKriteriaValue::where('kriteria_id', $k->id)
                        ->selectRaw('SUM(POW(value, 2)) as total_squared_sum')
                        ->value('total_squared_sum');

                    $sum[$k->id] = $totalKriteriaSquaredSum;

                    $result = $value / sqrt($totalKriteriaSquaredSum);

                    // Menyimpan hasil asli dalam variabel
                    $resultRow[$k->id] = $result;
                } else {
                    $resultRow[$k->id] = 0;
                }
            }

            $originalResults[$a->id] = $resultRow;
        }


        $weightedResults = [];

        // Perulangan kedua untuk mengalikan hasil asli dengan bobot
        foreach ($originalResults as $a => $resultRow) {
            $weightedResultRow = [];

            foreach ($kriteria as $k) {
                $bobotKriteria = $k->bobot;
                $resultWithWeight = $resultRow[$k->id] * $bobotKriteria;
                $weightedResultRow[$k->id] = $resultWithWeight;
            }

            $weightedResults[$a] = $weightedResultRow;
        }

        $valuesByKriteria = [];

        // Perulangan untuk mengelompokkan nilai berdasarkan id_kriteria
        foreach ($weightedResults as $a => $resultRow) {
            foreach ($resultRow as $k => $value) {
                $idKarakter = $k;
                $idKriteria = $kriteria->find($idKarakter)->id;

                if (!isset($valuesByKriteria[$idKriteria])) {
                    $valuesByKriteria[$idKriteria] = [];
                }

                $valuesByKriteria[$idKriteria][] = $value;
            }
        }

        $Amax = [];
        $Amin = [];

        // Perulangan dan kondisi untuk mencari nilai tertinggi dan terendah pada setiap kriteria yang menyesuaikan dengan attribut yang ada
        foreach ($valuesByKriteria as $idKriteria => $values) {
            $kriteriaObj = $kriteria->find($idKriteria);
            $attribute = $kriteriaObj->attribut;

            if ($attribute === 'Benefit') {
                $maxValue = max($values);
                $Amax[$idKriteria] = $maxValue;
                $minValue = min($values);
                $Amin[$idKriteria] = $minValue;
            } elseif ($attribute === 'Cost') {
                $maxValue = max($values);
                $Amin[$idKriteria] = $maxValue;
                $minValue = min($values);
                $Amax[$idKriteria] = $minValue;
            }
        }

        // Inisialisasi array untuk menyimpan hasil solusi ideal positif dan negatif
        $resultSquaredPositif = [];
        $resultSquaredNegatif = [];

        // Perulangan untuk mencari hasil nilai ideal positif
        foreach ($weightedResults as $a => $resultRow) {
            foreach ($resultRow as $k => $value) {
                $idKriteria = $k;

                $amaxForKriteria = $Amax[$idKriteria];
                $valueAfterSubtraction = $value - $amaxForKriteria;
                $resultSquaredPositif[$a][$k] = pow($valueAfterSubtraction, 2);
            }
        }

        // Perulangan untuk mencari hasil nilai ideal negatif
        foreach ($weightedResults as $a => $resultRow) {
            foreach ($resultRow as $k => $value) {
                $idKriteria = $k;

                $aminForKriteria = $Amin[$idKriteria];
                $valueAfterSubtraction = $value - $aminForKriteria;
                $resultSquaredNegatif[$a][$k] = pow($valueAfterSubtraction, 2);
            }
        }

        // Inisialisasi array untuk menyimpan hasil penjumlahan setiap nilai berdasarkan id_alternatif
        $sumByAlternatifPositif = [];
        $sumByAlternatifNegatif = [];

        // Perulangan untuk mencari hasil penjumlahan nilai ideal positif
        foreach ($resultSquaredPositif as $a => $resultRow) {
            $sumByAlternatifPositif[$a] = 0;

            foreach ($resultRow as $k => $value) {
                $sumByAlternatifPositif[$a] += $value;
            }
        }

        // Perulangan untuk mencari hasil penjumlahan nilai ideal positif
        foreach ($resultSquaredNegatif as $a => $resultRow) {
            $sumByAlternatifNegatif[$a] = 0;

            foreach ($resultRow as $k => $value) {
                $sumByAlternatifNegatif[$a] += $value;
            }
        }

        // Inisalisasi untuk mendapatkan nilai D+ dan D-
        $sqrtByAlternatifPositif = [];
        $sqrtByAlternatifNegatif = [];

        foreach ($sumByAlternatifPositif as $a => $sum) {
            $sqrtByAlternatifPositif[$a] = sqrt($sum);
        }


        foreach ($sumByAlternatifNegatif as $a => $sum) {
            $sqrtByAlternatifNegatif[$a] = sqrt($sum);
        }

        // Inisialisasi array untuk menyimpan hasil perhitungan
        $finalResults = [];

        // Perulangan untuk mencari nilai preverensi (D-/((D-)+D+))
        foreach ($alternatif as $a) {
            $idAlternatif = $a->id;

            if (isset($sqrtByAlternatifNegatif[$idAlternatif]) && isset($sqrtByAlternatifPositif[$idAlternatif])) {
                $negatif = $sqrtByAlternatifNegatif[$idAlternatif];
                $positif = $sqrtByAlternatifPositif[$idAlternatif];

                // Melakukan perhitungan
                $hasil = $negatif / ($negatif + $positif);

                $finalResults[$idAlternatif] = $hasil;
            }
        }

        arsort($finalResults);

        // Inisialisasi array untuk menyimpan peringkat
        $ranking = [];

        // Hitung peringkat dan simpan dalam array
        $rank = 1;
        foreach ($finalResults as $alternatifId => $hasil) {
            $alternatif = Alternatif::find($alternatifId);

            if ($alternatif) {
                $ranking[] = [
                    'rank' => $rank,
                    'alternatif_keterangan' => $alternatif->keterangan,
                    'alternatif_name' => $alternatif->nama,
                    'final_value' => $hasil
                ];
            }

            $rank++;
        }

        return view('menu.hasil', compact('finalResults', 'alternatif', 'ranking'));
    }
}
