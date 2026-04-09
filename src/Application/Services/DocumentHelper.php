<?php

declare(strict_types=1);

namespace App\Application\Services;

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

final class DocumentHelper
{
    public function exportPdf(string $html, string $targetPath): string
    {
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        file_put_contents($targetPath, $pdf->output());
        return $targetPath;
    }

    /** @param array<int, array<int, string|int|float>> $rows */
    public function exportXlsx(array $rows, string $targetPath): string
    {
        $sheet = (new Spreadsheet())->getActiveSheet();
        foreach ($rows as $r => $row) {
            foreach ($row as $c => $value) {
                $sheet->setCellValueByColumnAndRow($c + 1, $r + 1, $value);
            }
        }
        (new Xlsx($sheet->getParent()))->save($targetPath);
        return $targetPath;
    }

    /** @param array<int, array<int, string|int|float>> $rows */
    public function exportCsv(array $rows, string $targetPath): string
    {
        $sheet = (new Spreadsheet())->getActiveSheet();
        foreach ($rows as $r => $row) {
            foreach ($row as $c => $value) {
                $sheet->setCellValueByColumnAndRow($c + 1, $r + 1, $value);
            }
        }
        (new Csv($sheet->getParent()))->save($targetPath);
        return $targetPath;
    }

    /** @return array<int, array<int, mixed>> */
    public function importSpreadsheet(string $sourcePath): array
    {
        $spreadsheet = IOFactory::load($sourcePath);
        return $spreadsheet->getActiveSheet()->toArray();
    }
}
