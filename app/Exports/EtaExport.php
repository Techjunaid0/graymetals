<?php

namespace App\Exports;

use App\Consignment;
use App\Contract;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use DateTime;

class EtaExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $dataArray = [];
        $indexValue = 0;


        $eta_from = $this->request->eta == null ? null : DateTime::createFromFormat('d-m-Y', substr($this->request->eta, '0', '10'));
        $eta_to = $this->request->eta == null ? null : DateTime::createFromFormat('d-m-Y', substr($this->request->eta, '13'));
        $contract_date_from = $this->request->contract_date == null ? null : DateTime::createFromFormat('d-m-Y', substr($this->request->contract_date, '0', '10'));
        $contract_date_to = $this->request->contract_date == null ? null : DateTime::createFromFormat('d-m-Y', substr($this->request->contract_date, '13'));

        $request = $this->request;
        $details = Contract::where(function ($query) use ($request, $eta_to, $eta_from, $contract_date_from, $contract_date_to) {
            if (!is_null($request->eta)) {
                $query->whereBetween('eta', [$eta_from->format('Y-m-d'), $eta_to->format('Y-m-d')]);
            }
            if (!is_null($request->contract_date)) {
                $query->whereBetween('contract_date', [$contract_date_from->format('Y-m-d'), $contract_date_to->format('Y-m-d')]);
            }
            if (!is_null($request->shipping_line)) {
                $query->where('shipping_line', $request->shipping_line);
            }
            if (!is_null($request->supplier_name)) {
                $query->where('supplier_name', $request->supplier_name);
            }
            if (!is_null($request->container_no)) {
                $query->where('container_no', $request->container_no);
            }
            if (!is_null($request->status)) {
                $query->where('status', $request->status);
            }
            if (!is_null($request->payment_status)) {
                $query->where('payment_status', $request->payment_status);
            }
        })->get();
//        $details = Consignment::where(['eta' => $this->request->eta])->get();
        foreach ($details as $detail) {
            if(!is_null($detail->eta)){
                $eta = Carbon::parse($detail->eta);
            }else{
                $eta = null;
            }
            if(!is_null($detail->contract_date)){
                $contract_date = Carbon::parse($detail->contract_date);
            }else{
                $contract_date = null;
            }
            $dataArray[$indexValue] = array(
                [
                    'invoice_no'             => $detail->invoice_no ?? '-',
                    'contract_no'            => $detail->contract_no ?? '-',
                    'contract_date'          => (!is_null($contract_date)) ? $contract_date->format('d-m-Y')  : '-',
                    'supplier_name'          => $detail->supplier_name ?? '-',
                    'no_of_containers'       => $detail->no_of_containers ?? '-',
                    'rate'                   => $detail->rate ?? '-',
                    'status'                 => ucfirst(str_replace('_',' ',$detail->status)) ?? '-',
                    'shipping_line'          => $detail->shipping_line ?? '-',
                    'eta'                    => (!is_null($eta)) ? $eta->format('d-m-Y')  : '-',
                    'weight'                 => $detail->weight ?? '-',
                    'invoice_value'          => $detail->invoice_value ?? '-',
                    'container_no'           => $detail->container_no ?? '-',
                    'comments'               => $detail->comments ?? '-',
                    'other_info'             => $detail->other_info ?? '-',
                    'cu'                     => $detail->cu ?? '-',
                    'steal'                  => $detail->steal ?? '-',
                    'lme'                    => $detail->lme ?? '-',
                    'payment_status'         => ucfirst(str_replace('_',' ',$detail->payment_status)) ?? '-',
                ]);
            $indexValue++;
        }
        return collect($dataArray);
    }

    public function headings(): array
    {
        return [
            [
                'Invoice No',
                'Contract No',
                'Contract Date',
                'Supplier Name',
                'No of Container',
                'Rate',
                'Status',
                'Shipping Line',
                'ETA',
                'Weight',
                'Invoice Value',
                'Container No',
                'Comments',
                'Other Info',
                'CU',
                'Steal',
                'LME',
                'Payment Status',
            ]
        ];
    }

    public function title(): string
    {
        return "Contract Reports";
    }
}
