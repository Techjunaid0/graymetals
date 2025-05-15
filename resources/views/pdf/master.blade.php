<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{{ $title ?? "GrayMetals" }}</title>
	@stack('css')
</head>
<body>
	@yield('content')
</body>
</html>
