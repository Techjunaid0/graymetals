<?php

namespace App\Exports;

use App\ConsignmentDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ConsignmentDetailExport implements FromCollection, WithHeadings,WithTitle
{
	private $request;

    public function __construct($request)
    {
    	$this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$dataArray = [];
        $indexValue = 0;
        $details = ConsignmentDetail::where('container_no', $this->request->container_no)->get();
        foreach($details as $detail)
        {
            $dataArray[$indexValue] = array(['consignment_id' => $detail->consignment_id, 'seal_no' => $detail->seal_no, 'description' => $detail->description, 'item_weight' => $detail->item_weight, 'price' => $detail->price, 'total_price' => $detail->total_price]);
            $indexValue++;
        }
        return collect($dataArray);
    }
    public function headings(): array
    {
        return [
           ['Consignment id', 'Seal No', 'Description', 'Item Weight', 'Price', 'Total Price']
        ];
    }
    public function title() : string
    {
    	return "Container Reports";
    }
}
