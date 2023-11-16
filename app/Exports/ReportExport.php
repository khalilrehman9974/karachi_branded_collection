<?php

namespace App\Exports;

use App\PoInvoiceReceiptReport;
use App\PoReceiptReport;
use App\UnInvoicedPoReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection,  WithHeadings
{
    /**
     * @var int
     */
    protected $page;
    /**
     * @var string
     */
    protected $report_type;

    /**
     * PoInvoiceReceiptReportExport constructor.
     * @param $page
     * @param string $report_type
     */
    public function __construct($page, string $report_type)
    {
        $this->page = $page;
        $this->report_type = $report_type;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function collection()
    {
        if ($this->report_type == 'po_invoice_receipt_reports') {
            $query = PoInvoiceReceiptReport::query();
        } else if ($this->report_type == 'po_receipt_reports') {
            $query = PoReceiptReport::query();
        } else if ($this->report_type == 'uninvoiced_po_reports') {
            $query = UnInvoicedPoReport::query();
        }

        //Set limit and offset for page
        $query = $this->getRecordsByPage($query, $this->page);

        return $query;
    }

    /**
     * getRecordsByPage
     * @param $query
     * @param $page
     * @return mixed
     */
    public function getRecordsByPage($query, $page)
    {
        if (!empty($page) && $page == 'all'){
            $query = $query->get();
        } elseif (!empty($page) && $page != 'all'){
            //Set limit as per requirement
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $query = $query->limit($limit)->offset($offset)->cursor();
        }

        return $query;
    }


    /**
     * @return string[]
     */
    public function headings(): array
    {
        if ($this->report_type == 'po_invoice_receipt_reports') {
            return $this->poInvoiceReceiptHeadings();
        } else if ($this->report_type == 'po_receipt_reports') {
            return $this->poReceiptHeadings();
        } else if ($this->report_type == 'uninvoiced_po_reports') {
            return $this->unInvoicePoHeadings();
        }
    }

    /**
     * poInvoiceReceiptHeadings
     * @return string[]
     */
    public function poInvoiceReceiptHeadings(): array
    {
        return ['Id',
            'Invoice Number',
            'Invoice Date',
            'Accounting_date',
            'Paid Status',
            'Approval Status',
            'PO Number',
            'PO Creation_date',
            'Vendor Name',
            'PO Line',
            'Received Quantity',
            'Invoiced Quantity',
            'Operating Unit',
            'Invoice Line Description',
            'Receipt Number',
            'Charge Detail',
            'Invoice Code Details',
            'Line Type',
            'Invoice Line Amount',
            'Invoice Currency Code',
            'Invoice Rate',
            'Functional Value invoice Rate',
            'Receipt Rate',
            'Functional Value Receipt Rate',
            'PO Currency Code',
            'Created at',
            'updated at'
        ];
    }

    /**
     * poReceiptHeadings
     * @return string[]
     */
    public function poReceiptHeadings(): array
    {
        return ['Id',
            'po_number',
            'po_creation_date',
            'po_line_description',
            'po_approval_date',
            'po_status',
            'vendor_name',
            'po_currency_code',
            'po_need_date',
            'po_line_number',
            'po_line_quantity',
            'line_unit_price',
            'receipt_number',
            'receipt_date',
            'receipt_creation_date',
            'receipt_charge_account',
            'receiver',
            'quantity_received',
            'receipt_transaction_type',
            'amount',
            'receipt_accounting_date',
            'quantity_involved',
            'receipt_exchange_rate',
            'amount_pkr',
            'tax',
            'created_at',
            'updated_at'];
    }

    /**
     * unInvoicePoHeadings
     * @return string[]
     */
    public function unInvoicePoHeadings(): array
    {
        return ['Id',
            'receipt_number',
            'receipt_date',
            'po_number',
            'po_line_number',
            'po_line_description',
            'po_currency_code',
            'vendor_name',
            'line_unit_price',
            'po_line_quantity',
            'quantity_received',
            'invoiced_quantity',
            'un-invoiced_quantity',
            'receipt_rate',
            'un-invoiced_cost',
            'text',
            'code',
            'receipt_creation_date',
            'receipt_charge_account',
            'receiver',
            'receipt_transaction_type',
            'amount',
            'receipt_accounting_date',
            'quantity_involved',
            'amount_pkr',
            'tax',
            'created_at',
            'updated_at'
        ];
    }
}
