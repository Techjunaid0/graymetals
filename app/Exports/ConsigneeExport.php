<?php

namespace App\Exports;

use App\Consignee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ConsigneeExport implements FromCollection, WithHeadings,WithTitle
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
        $details = Consignee::find($this->request->consignee_id)->consignment;
        foreach($details as $detail)
        {
            $dataArray[$indexValue] = array(['name' => $detail->consignee->name, 'loading_port' => $detail->loadingPort->name, 'discharge_port' => $detail->dischargePort->name, 'final_destination' => $detail->final_destination, 'confirmation_date' => $detail->confirmation_date, 'carrier' => $detail->carrier, 'reference' => $detail->reference, 'line_reference' => $detail->line_reference, 'vessel' => $detail->vessel, 'ucr' => $detail->ucr, 'ets' => $detail->ets, 'eta' => $detail->eta, 'weight' => $detail->weight, 'price' => $detail->price]);
            $indexValue++;
        }
        return collect($dataArray);
    }
    public function headings(): array
    {
        return [
           ['Name', 'Loading Port', 'Discharge Port', 'Final Destin3ation', 'Confirmation Date', 'Carrier', 'Reference', 'Line Reference', 'Vessel', 'Ucr', 'Ets', 'Eta', 'Weight', 'Price']
        ];
    }
    public function title() : string
    {
    	return "ETA Reports";
    }
}
