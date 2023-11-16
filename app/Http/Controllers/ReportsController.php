<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\PoInvoiceReceiptReport;
use App\Services\MakeExcelService;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\OperatingUnit;
use App\PoNumber;
use App\PoReceiptReport;
use App\ReportType;
use App\UnInvoicedPoReport;
use App\VendorNumber;
use App\Services\ReportService;

class ReportsController extends Controller
{
    protected $makeExcelService;
    protected $reportService;

    public function __construct(ReportService $reportService, MakeExcelService $makeExcelService)
    {
        $this->makeExcelService = $makeExcelService;
        $this->reportService = $reportService;
    }

    /*
     * Show report main page.
     * */
    public function index()
    {
        $operatingUnits = OperatingUnit::pluck('name', 'id');
        $reportTypes = ReportType::pluck('name', 'id');
        $breadCrumb = '';

        return view('reports.reports', compact('operatingUnits', 'reportTypes', 'breadCrumb'));
    }

    /*
     * Get Po Numbers and vendor numbers for operating unit.
     * @param: $operatingUnitId
     * @return json
     * */
    public function getVendorAndPo($operatingUnitId)
    {
        $vendorNumber = VendorNumber::where('operating_unit_id', $operatingUnitId)->pluck('name', 'id');
        $poNumbers = PoNumber::where('operating_unit_id', $operatingUnitId)->pluck('name', 'id');

        return response()->json([
            ['status' => 'SUCCESS', 'vendorNumbers' => $vendorNumber, 'poNumbers' => $poNumbers],
        ]);
    }

    /*
     * Show Reports as per report type.
     * @param: request()->all()
     * @return Array;
     * */
    public function getReportData(){
        $param = request()->all();
        $reportType = $param['report_type'];
        $operatingUnits = OperatingUnit::pluck('name', 'id');
        $data = [];
        $reportTypes = ReportType::pluck('name', 'id');
        if(isset($param['report_type']) && $param['report_type'] == $this->reportService::PO_INVOICE_RECEIPT_REPORT){
            $data = $this->reportService->getReportsData(PoInvoiceReceiptReport::class);
            $breadCrumb = 'Po Invoice Receipt Report';
        }elseif(isset($param['report_type']) && $param['report_type'] == $this->reportService::RECEIPT_REPORT){
            $data = $this->reportService->getReportsData(PoReceiptReport::class);
            $breadCrumb = 'Po Receipt Report';
        }elseif(isset($param['report_type']) && $param['report_type'] == $this->reportService::UN_INVOICED_PO_REPORT){
            $data = $this->reportService->getReportsData(UnInvoicedPoReport::class);
            $breadCrumb = 'Un-Invoiced Po Report';
        }else{
            $breadCrumb = 'FA Report';
        }

        return view('reports.reports', compact('data', 'operatingUnits','reportTypes', 'reportType', 'breadCrumb', 'param'));
    }

    /**
     * fileExport
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function fileExport(Request $request)
    {
        $page = !empty($request->get('pages')) ? $request->get('pages'): 1;
        $reportType = $request->get('report_type_value');

        //get selected data and pass the object
        $dataObject = new ReportExport($page, $reportType);
        //pass the random file name
        $fileName = $reportType.'-'.mt_rand();

        return $this->makeExcelService->fileExport($dataObject, $fileName);

    }
}
