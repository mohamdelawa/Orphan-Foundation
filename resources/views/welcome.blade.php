<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
    <p>Php Laravel 9</p>
    <a href="{{route('import')}}">import excel</a>
    <a href="{{route('pdf')}}">pdf report</a>
    <form action="{{ url('/import') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        Type Folder Name:<input type="text" name="foldername" /><br/><br/>
        Select Folder to Upload: <input type="file" name="files[]" id="files" multiple directory="" webkitdirectory="" moxdirectory="" /><br/><br/>
        <input type="Submit" value="Upload" name="upload" />
    </form>

    </body>
</html>
