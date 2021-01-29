<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tool Slice Image</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div id="app">
    <div class="container">
        <div class="mt-5">
            <h1>Tool extract png images</h1>
            <div class="form-group">
                <button class="btn btn-primary" type="button" onclick="selectFolder(this)">Choose image directory</button>
                <input type="file" webkitdirectory directory multiple id="dirLoader" style="display: none">
                <small class="form-text text-danger"></small>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/function.js') }}"></script>
</body>
</html>
