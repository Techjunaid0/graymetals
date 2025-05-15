<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{{ $title ?? "GrayMetals" }}</title>
<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
<style type="text/css">
  body
  {
    font-family: 'Lato', sans-serif;
  }
  .wrapper{
    /*width: 60%;*/
    margin: 0  auto;
  }
  .logo
  {
    text-align: center;
  }
  .topCont{
    width: 100%;
    margin-top: 10px;
  }
  .topCont p
  {
    margin: 0;
    line-height: 22px;
  }
  .topLeft
  {
    width: 50%;
    float: left;
    text-align: left;
  }
  .topRight
  {
    width: 50%;
    float: right;
    text-align: right;
  }
  .clearfix
  {
    clear: both;
  }
  table
  {
    text-align: left;
  }
  .topCont2 h4
  {
    margin: 0;
    line-height: 22px;
  }
  .topCont2 p
  {
    margin: 15px 0;
  }
</style>
</head>

<body>
<div class="wrapper">
  <div class="logo"><img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('images/lg-logo.png'))) }}" alt="GrayMetals" width="250px"></div>
  <div class="topCont">
    <div class="topLeft">
      <p>8 Melbourne Road Birmingham B34 7LT</p>
{{--      <p>Email:<a href="mailto:graymetalsltd@gmail.com"> graymetalsltd@gmail.com</a></p>--}}
      <p>Email:<a href="mailto:admin@graymetalsltd.co.uk"> admin@graymetalsltd.co.uk</a></p>
      <p>VAT No: 235 6900 06</p>
    </div>
    <div class="topRight">
      <p><a href="tel:+44 121 6476 774">Tel:+44 121 6476 774</a></p>
{{--      <p><a href="tel:+44 796 9176 161">Tel:+44 796 9176 161</a></p>--}}
      <p><a href="tel:+44 777 5160 666">Tel:+44 777 5160 666</a></p>
      <p><a href="http://graymetalsltd.co.uk">www.graymetalsltd.co.uk</a></p>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="topCont">
    <div class="topLeft">
      @if(isset($instruction->consignment->consignee->name))
        <h2>Bill To:</h2>
        <p>{{ $instruction->consignment->consignee->name }}</p>
        <p>{{ $instruction->consignment->consignee->address }}</p>
        <p>{{ $instruction->consignment->consignee->city->name ?? '-' }}</p>
        <p>{{ $instruction->consignment->consignee->country->name ?? '-' }}</p>
      @endif
    </div>
    <div class="topRight">
      <h4>Dated: {{ date('d/m/Y') }}</h4>
      <h4>Proforma Invoice No: {{ $instruction->id }}</h4>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="topCont">
    <table cellpadding="15" cellspacing="0" border="1" width="100%" align="center">
      <tr>
        <th>S.NO</th>
        <th>Item Desc.</th>
        <th>Total Qty. (Weight)</th>
        <th>Price/Ton</th>
        <th>Total Price</th>
      </tr>
      @foreach($instruction->consignment->consignmentDetails as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->description }}</td>
{{--          <td>{{ number_format($item->item_weight / 1000, 2, '.', '') }}(approx.)</td>--}}
          <td>{{ number_format($item->item_weight, 2, '.', '') }}</td>
          <td>{{ $instruction->consignment->currency->symbol . number_format($item->price, 2, '.', '') }}</td>
{{--          <td>{{ $instruction->consignment->currency->symbol . number_format($item->price * 1000, 2, '.', '') }}</td>--}}
          <td>{{ $instruction->consignment->currency->symbol . number_format($item->total_price, 2, '.', '') }}</td>
        </tr>
      @endforeach
      <tr>
        <th colspan="4">Total Amount Payable</th>
        <th>{{ $instruction->consignment->currency->symbol . number_format($instruction->consignment->consignmentDetails->pluck('total_price')->sum(), 2, '.', '') }}</th>
      </tr>
    </table>
  </div>
  <div class="topCont">

  </div>
  <div class="topCont topCont2">
  <p>Thank You for your order please make all payments to following Account</p>
    <h4>Account Details: Gray Metals Ltd</h4>
    <h4>Sort Code: 30 80 77</h4>
    <h4>Account Number: 17016960</h4>
    <h4>IBAN: GB05LOYD30807717016960</h4>
    <h4>Branch Identifier Code/Swift Code: LOYDGB21733</h4>
    <p>If you have any concerns about the invoice please contact on the details above.</p>
  </div>
</div>
</body>
</html>
