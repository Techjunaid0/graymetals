<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>@yield('title', "GrayMetals")</title>
<style>
	body{
		background: #ecf0f5;
	}
</style>
</head>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="600px" align="center">
	<tr>
		<td style="background: #222d32; padding: 30px 20px; box-sizing: border-box; text-align: center;"><img src="{{ asset('images/lg-logo.png') }}" alt="GrayMetals" width="200px;"></td>
	</tr>
	<tr style="background: #fff; padding: 30px 20px; box-sizing: border-box; text-align: center;">
		<td>
			<h2 style="font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial,' sans-serif'; padding: 10px 20px; box-sizing: border-box;">@yield('heading')</h2>
			<p style="font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial,' sans-serif'; padding: 0 20px; line-height: 26px; box-sizing: border-box;">
				@yield('content')
			</p>
			<p style="border: #ccc dotted 1px; width: 80%; margin: 0 auto; margin-bottom: 20px;"></p>
			<p style="font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial,' sans-serif'; text-align: left; padding: 0 40px; margin: 0;">8 Melbourne Road Birmingham B34 7LT</p>
			<p style="font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial,' sans-serif'; text-align: left; padding: 0 40px; margin: 0;"><a href="tel:+44 121 6476 774">Tel:+44 121 6476 774</a></p>
			<p style="font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial,' sans-serif'; text-align: left; padding: 0 40px; margin: 0;"><a href="mailto:admin@graymetalsltd.co.uk">admin@graymetalsltd.co.uk</a></p>
			<p style="font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial,' sans-serif'; text-align: left; padding: 0 40px; margin: 0;"><a href="http://www.graymetalsltd.co.uk" target="_blank">www.graymetalsltd.co.uk</a></p>
			<p></p>
		</td>
	</tr>
	<tr>
		<td style="background: #222d32; padding: 15px 20px; box-sizing: border-box; text-align: center;">
			<p style="font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial,' sans-serif'; color: #fff; text-align: center; margin: 0;">Copyright © {{ date('Y') }} GrayMetals UK, Inc. All rights reserved.</p>
		</td>
	</tr>
</table>
</body>
</html>