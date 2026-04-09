<?php
// app/Services/GeminiService.php
// Service gọi Google Gemini API

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private $apiKey;
    private $model;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('gemini.api_key');
        $this->model = config('gemini.model');
        $this->baseUrl = config('gemini.base_url');
    }

    /**
     * Gửi prompt đến Gemini API
     */
    public function guiPrompt($prompt)
    {
        if (empty($this->apiKey)) {
            Log::error('Gemini API Key chưa được cấu hình');
            return null;
        }

        try {
            $url = "{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}";

            $response = Http::timeout(30)->post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 2048,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            }

            Log::error('Gemini API Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Gợi ý nghề nghiệp
     */
    public function goiYNgheNghiep($kieuMbti, $phanTram, $thongTin = [])
    {
        $soThich = $thongTin['so_thich'] ?? 'Chưa cung cấp';
        $kyNang = $thongTin['ky_nang'] ?? 'Chưa cung cấp';
        $trinhDo = $thongTin['trinh_do_hoc_van'] ?? 'Chưa cung cấp';
        $linhVuc = $thongTin['linh_vuc_quan_tam'] ?? 'Chưa cung cấp';
        $kinhNghiem = $thongTin['kinh_nghiem'] ?? 'Chưa cung cấp';
        $mucTieu = $thongTin['muc_tieu'] ?? 'Chưa cung cấp';

        $prompt = "Bạn là chuyên gia tư vấn nghề nghiệp. Phân tích và gợi ý nghề nghiệp:

MBTI: {$kieuMbti}
E: {$phanTram['e']}% | I: {$phanTram['i']}%
S: {$phanTram['s']}% | N: {$phanTram['n']}%
T: {$phanTram['t']}% | F: {$phanTram['f']}%
J: {$phanTram['j']}% | P: {$phanTram['p']}%

Sở thích: {$soThich}
Kỹ năng: {$kyNang}
Trình độ: {$trinhDo}
Lĩnh vực quan tâm: {$linhVuc}
Kinh nghiệm: {$kinhNghiem}
Mục tiêu: {$mucTieu}

Trả về JSON thuần (không markdown):
{
    \"phan_tich_chung\": \"...\",
    \"diem_manh\": [\"...\"],
    \"linh_vuc_phu_hop\": [\"...\"],
    \"goi_y_nghe_nghiep\": [
        {\"ten_nghe\": \"...\", \"muc_do_phu_hop\": 95, \"ly_do\": \"...\", \"muc_luong_tham_khao\": \"...\"}
    ],
    \"loi_khuyen\": \"...\"
}

Gợi ý 5-8 nghề phù hợp thị trường Việt Nam, sắp xếp theo mức phù hợp giảm dần.";

        $ketQua = $this->guiPrompt($prompt);
        return $ketQua ? $this->parseJson($ketQua) : null;
    }

    /**
     * Phân tích CV
     */
    public function phanTichCv($noiDungCv, $kieuMbti, $thongTin = [])
    {
        $prompt = "Bạn là chuyên gia phân tích CV. Phân tích CV và đề xuất ngách nghề nghiệp.

MBTI: {$kieuMbti}
Sở thích: " . ($thongTin['so_thich'] ?? 'N/A') . "
Kỹ năng: " . ($thongTin['ky_nang'] ?? 'N/A') . "

CV:
{$noiDungCv}

Trả về JSON thuần (không markdown):
{
    \"tom_tat_cv\": \"...\",
    \"diem_manh_tu_cv\": [\"...\"],
    \"ngach_nghe_nghiep\": [
        {\"ten_ngach\": \"...\", \"ly_do\": \"...\", \"muc_do_phu_hop\": 90}
    ],
    \"lo_trinh_phat_trien\": {\"ngan_han\": \"...\", \"trung_han\": \"...\", \"dai_han\": \"...\"},
    \"loi_khuyen\": \"...\"
}

Đề xuất 3-5 ngách nghề nghiệp CỤ THỂ phù hợp thị trường Việt Nam.";

        $ketQua = $this->guiPrompt($prompt);
        return $ketQua ? $this->parseJson($ketQua) : null;
    }

    /**
     * Parse JSON từ response (loại bỏ markdown nếu có)
     */
    private function parseJson($response)
    {
        $response = trim($response);
        if (str_starts_with($response, '```json')) $response = substr($response, 7);
        elseif (str_starts_with($response, '```')) $response = substr($response, 3);
        if (str_ends_with($response, '```')) $response = substr($response, 0, -3);

        $data = json_decode(trim($response), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON Parse Error: ' . json_last_error_msg());
            return null;
        }
        return $data;
    }
}
