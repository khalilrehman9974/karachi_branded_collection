<?php

namespace App\Services;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ReportService
{
    const PER_PAGE = 10;
    const PO_INVOICE_RECEIPT_REPORT = 'po_invoice_receipt_reports';
    const RECEIPT_REPORT = 'po_receipt_reports';
    const UN_INVOICED_PO_REPORT = 'uninvoiced_po_reports';


    /*
    * Pagination for list of packages.
    * @param: $data
    * @param: $perPage
    * @param: $page
    * @param: $options
    * */
    public function paginate($items, $perPage = Self::PER_PAGE, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: Self::CURRENT_PAGE);
        $items = $items instanceof Collection ? $items : Collection::make($items)->sortByDesc('id');

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /*
     * Generic function to get reports data.
     * @param: $model
     * @return Array
     * */
    public function getReportsData($model){
        $data = $model::all();
        return Self::paginate($data);
    }
}
