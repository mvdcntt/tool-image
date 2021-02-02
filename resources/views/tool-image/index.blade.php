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
    <style>
        p{
            font-style: italic;
        }
        .loader{
            height: 100px;
            width: 20%;
            text-align: center;
            margin: 0 auto 1em;
            display: inline-block;
            vertical-align: top;
        }

        /*
          Set the color of the icon
        */
        svg path,
        svg rect{
            fill: #FF6700;
        }
    </style>
</head>
<body>

<div id="app">
    <div class="container">
        <div class="mt-5">
            <h1>Tool extract png images</h1>
            <div class="form-group">
                <!-- 2 -->
                <div id="loading" class="loader loader--style2" title="1" style="display: none">
                    <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         width="40px" height="40px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
  <path fill="#000" d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z">
      <animateTransform attributeType="xml"
                        attributeName="transform"
                        type="rotate"
                        from="0 25 25"
                        to="360 25 25"
                        dur="0.6s"
                        repeatCount="indefinite"/>
  </path>
  </svg>
                </div>
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
