<?php
// app/Services/MbtiService.php
// Service tính toán kết quả MBTI

namespace App\Services;

use App\Models\CauHoi;

class MbtiService
{
    /**
     * Tính toán kết quả MBTI từ câu trả lời
     * @param array $danhSachTraLoi [['cau_hoi_id' => 1, 'lua_chon' => 'A'], ...]
     * @return array
     */
    public function tinhKetQua($danhSachTraLoi)
    {
        // Khởi tạo điểm cho 8 chiều
        $diem = ['E'=>0, 'I'=>0, 'S'=>0, 'N'=>0, 'T'=>0, 'F'=>0, 'J'=>0, 'P'=>0];
        $chiTiet = [];

        // Duyệt từng câu trả lời
        foreach ($danhSachTraLoi as $traLoi) {
            $cauHoi = CauHoi::find($traLoi['cau_hoi_id']);
            if (!$cauHoi) continue;

            // Xác định chiều được chọn
            $chieuDuocChon = ($traLoi['lua_chon'] == 'A') ? $cauHoi->chieu_a : $cauHoi->chieu_b;

            // Tăng điểm
            $diem[$chieuDuocChon]++;

            $chiTiet[] = [
                'cau_hoi_id' => $cauHoi->id,
                'lua_chon' => $traLoi['lua_chon'],
                'chieu_duoc_chon' => $chieuDuocChon,
            ];
        }

        // Tính phần trăm
        $tongEI = $diem['E'] + $diem['I'] ?: 1;
        $tongSN = $diem['S'] + $diem['N'] ?: 1;
        $tongTF = $diem['T'] + $diem['F'] ?: 1;
        $tongJP = $diem['J'] + $diem['P'] ?: 1;

        $phanTram = [
            'e' => round($diem['E'] / $tongEI * 100, 2),
            'i' => round($diem['I'] / $tongEI * 100, 2),
            's' => round($diem['S'] / $tongSN * 100, 2),
            'n' => round($diem['N'] / $tongSN * 100, 2),
            't' => round($diem['T'] / $tongTF * 100, 2),
            'f' => round($diem['F'] / $tongTF * 100, 2),
            'j' => round($diem['J'] / $tongJP * 100, 2),
            'p' => round($diem['P'] / $tongJP * 100, 2),
        ];

        // Xác định kiểu MBTI
        $kieuMbti = '';
        $kieuMbti .= ($phanTram['e'] >= $phanTram['i']) ? 'E' : 'I';
        $kieuMbti .= ($phanTram['s'] >= $phanTram['n']) ? 'S' : 'N';
        $kieuMbti .= ($phanTram['t'] >= $phanTram['f']) ? 'T' : 'F';
        $kieuMbti .= ($phanTram['j'] >= $phanTram['p']) ? 'J' : 'P';

        return [
            'kieu_mbti' => $kieuMbti,
            'diem' => $diem,
            'phan_tram' => $phanTram,
            'chi_tiet' => $chiTiet,
        ];
    }
}
