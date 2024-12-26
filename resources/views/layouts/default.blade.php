<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title","E-com")</title>
    <link href="{{asset("assets/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/css/app.css")}}" rel="stylesheet"> <!-- Add this line -->
    @yield("style")
</head>

<body>
    @include("includes.header")
    
    <!-- Wrap the content with the <main> tag to ensure proper layout -->
    <main>
        @yield("content")
    </main>
    
    @include("includes.footer")

    <script src="{{asset("assets/js/bootstrap.min.js")}}"></script>
    @yield("script")
</body>
</html>

















