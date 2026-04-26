<?php
// app/Services/FileReaderService.php
// Service đọc nội dung file CV (PDF, DOC, DOCX, TXT)
// Sử dụng smalot/pdfparser cho PDF (theo cv.php mẫu)

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class FileReaderService
{
    /**
     * Đọc nội dung text từ file upload
     */
    public function docFile($file): ?string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        try {
            $text = match ($extension) {
                'txt' => $this->docTxt($file->getRealPath()),
                'docx' => $this->docDocx($file->getRealPath()),
                'doc' => $this->docDoc($file->getRealPath()),
                'pdf' => $this->docPdf($file->getRealPath()),
                default => null,
            };

            if ($text) {
                $text = $this->cleanExtractedText($text);
            }

            return $text;
        } catch (\Exception $e) {
            Log::error('FileReader Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Đọc file TXT
     */
    private function docTxt(string $path): ?string
    {
        $content = file_get_contents($path);
        $content = mb_convert_encoding($content, 'UTF-8', 'auto');
        return $content;
    }

    /**
     * Đọc file PDF bằng smalot/pdfparser (theo cv.php mẫu)
     */
    private function docPdf(string $path): ?string
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($path);
            $text = $pdf->getText();

            if (empty(trim($text))) {
                Log::warning('PDF trống hoặc dạng ảnh, không trích xuất được text');
                return null;
            }

            return trim($text);
        } catch (\Exception $e) {
            Log::error('PDF Parse Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Đọc file DOCX (ZIP chứa XML)
     */
    private function docDocx(string $path): ?string
    {
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) return null;

        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xml) return null;

        $dom = new \DOMDocument();
        $dom->loadXML($xml, LIBXML_NOERROR | LIBXML_NOWARNING);
        $paragraphs = $dom->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'p');

        $text = '';
        foreach ($paragraphs as $p) {
            $line = '';
            $runs = $p->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 't');
            foreach ($runs as $run) {
                $line .= $run->textContent;
            }
            $text .= $line . "\n";
        }

        return trim($text);
    }

    /**
     * Đọc file DOC cũ (binary format)
     */
    private function docDoc(string $path): ?string
    {
        $content = file_get_contents($path);
        if (!$content) return null;

        $text = '';
        $len = strlen($content);
        for ($i = 0; $i < $len; $i++) {
            $char = ord($content[$i]);
            if ($char == 0x0D || $char == 0x0A) {
                $text .= "\n";
            } elseif ($char >= 0x20 && $char < 0x80) {
                $text .= $content[$i];
            } elseif ($char >= 0xC0) {
                $text .= $content[$i];
            }
        }

        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $text = trim($text);

        return strlen($text) > 50 ? $text : null;
    }

    /**
     * Làm sạch text trích xuất — theo logic cv.php mẫu
     */
    private function cleanExtractedText(string $text): string
    {
        // Fix encoding
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

        // Remove non-printable and symbol unicode blocks (PDF parsers break these)
        $text = preg_replace('/[\x{FFFD}\x{FFFE}\x{FFFF}]/u', '', $text);
        $text = preg_replace('/[\x{2500}-\x{257F}]/u', '', $text); // Box drawing
        $text = preg_replace('/[\x{25A0}-\x{25FF}]/u', '', $text); // Geometric shapes
        $text = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $text); // Misc symbols
        $text = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $text); // Dingbats
        $text = preg_replace('/[\x{2300}-\x{23FF}]/u', '', $text); // Misc technical
        $text = preg_replace('/[\x{2190}-\x{21FF}]/u', '', $text); // Arrows
        $text = preg_replace('/[\x{E000}-\x{F8FF}]/u', '', $text); // Private use area
        $text = preg_replace('/[\x{FE00}-\x{FE0F}]/u', '', $text); // Variation selectors
        $text = preg_replace('/[\x{1F000}-\x{1FFFF}]/u', '', $text); // Emojis
        $text = preg_replace('/[\x{20000}-\x{2FFFF}]/u', '', $text); // CJK extensions
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $text); // Control chars

        // Remove broken icons (become ?????? in PDF)
        $text = preg_replace('/\?{2,}\s*/', '', $text);
        $text = preg_replace('/^\?\s*/m', '', $text);

        // Normalize bullet points
        $text = preg_replace('/^[•\-\*]\s*/m', '• ', $text);

        // Normalize whitespace
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/^\s+$/m', '', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        // Trim each line
        $lines = array_map('trim', explode("\n", $text));
        while (!empty($lines) && empty($lines[0])) {
            array_shift($lines);
        }
        $text = implode("\n", $lines);

        return trim($text);
    }
}
