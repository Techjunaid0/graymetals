<?php

namespace App\Exports;

use App\ConsignmentDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;


class ItemExport implements FromCollection, WithHeadings, WithTitle
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
    	$indexVal = 0;
        $details =  ConsignmentDetail::where(['description' => $this->request->description])->get();
        foreach($details as $detail)
        {
        	$dataArray[$indexVal] = array([ 'description' => $detail->description,'consignment_id' => $detail->consignment_id, 'seal_no' => $detail->seal_no, 'item_weight' => $detail->item_weight, 'price' => $detail->price, 'total_price' => $detail->total_price]);
            $indexVal++;
        }
        return collect($dataArray);
    }
     public function headings(): array
    {
        return [
           ['Description','Consignment id', 'Seal No', 'Item Weight', 'Price', 'Total Price']
        ];
    }
    public function title() : string
    {
    	return "Item Reports";
    }
}
