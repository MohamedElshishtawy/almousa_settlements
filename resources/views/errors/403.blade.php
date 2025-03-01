<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .centered {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
<div class="centered">
    <div class="text-center">
        <h1></h1>
        <!-- Laravel Message -->
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <!-- Arabic Message -->
        <div class="alert alert-info" role="alert">
            <span class="fas fa-lock"></span> لا يسمح لك فتح تلك الصفحة إرجع لأدمن الموقع
        </div>
        {{--home bottom--}}
        <a class="btn btn-success btn-sm" href="{{url('/')}}">
            الرجوع للصفحة الرئيسية
        </a>

    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
