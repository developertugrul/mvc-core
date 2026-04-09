<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Services\DocumentHelper;
use App\Core\Request;
use App\Core\Response;

final class FileController
{
    public function __construct(private DocumentHelper $documents)
    {
    }

    public function exportPdf(Request $request): Response
    {
        $path = BASE_PATH . '/storage/cache/sample.pdf';
        $this->documents->exportPdf('<h1>Sample PDF</h1>', $path);
        return Response::download($path, 'sample.pdf', 'application/pdf');
    }

    public function exportXlsx(Request $request): Response
    {
        $path = BASE_PATH . '/storage/cache/sample.xlsx';
        $this->documents->exportXlsx([['id', 'name'], [1, 'demo']], $path);
        return Response::download($path, 'sample.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function exportCsv(Request $request): Response
    {
        $path = BASE_PATH . '/storage/cache/sample.csv';
        $this->documents->exportCsv([['id', 'name'], [1, 'demo']], $path);
        return Response::download($path, 'sample.csv', 'text/csv; charset=UTF-8');
    }

    public function importCsv(Request $request): Response
    {
        $upload = $_FILES['file']['tmp_name'] ?? null;
        if ($upload === null) {
            return Response::json(['message' => 'file is required'], 422);
        }

        $rows = $this->documents->importSpreadsheet($upload);
        return Response::json(['rows' => $rows]);
    }
}
