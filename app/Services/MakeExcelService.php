<?php


namespace App\Services;

use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class MakeExcelService
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileExport($dataObject, $fileName)
    {
        ob_end_clean();
        return Excel::download($dataObject, $fileName.'.xlsx');
    }

}
