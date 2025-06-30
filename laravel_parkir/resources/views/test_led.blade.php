<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
</head>
<body>
    <h1>Kontrol LED dari Laravel</h1>

    @if(session('status'))
        <p><strong>{{ session('status') }}</strong></p>
    @endif

    <form method="POST" action="/led">
        @csrf
        <button type="submit" name="state" value="on">Nyalakan LED</button>
        <button type="submit" name="state" value="off">Matikan LED</button>
    </form>
</body>
</html>