<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة غير موجودة</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- رابط للملف CSS -->
</head>
<body>
    <div style="text-align: center; padding: 50px;">
        <h1 style="font-size: 72px;">404</h1>
        <h2>آسف، الصفحة التي تبحث عنها غير موجودة.</h2>
        <p>يمكنك العودة إلى <a href="{{ url('/') }}">الصفحة الرئيسية</a> أو استخدام القائمة للبحث عن المحتوى.</p>
        <img src="{{ asset('../storage/images/error404.jpeg') }}" alt="404" style="width: 400px; margin-top: 10px;">
    </div>
</body>
</html>
