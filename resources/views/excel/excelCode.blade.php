<!DOCTYPE html>
<html>
<head>
    <title>import excel </title>
</head>
<body>
<form action="{{ url('/import') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    @if(session('errors'))
        @foreach ($errors as $error)
            <li>{{ $error }}</li>
        @endforeach
    @endif
    @if(session('success'))
        {{session('success')}}
    @endif
    <br><br>
    Select excel file to upload
    <br><br>
    <input type="file" name="file" id="file">
    <br><br>
    <button type="submit">Upload File</button>
    <br><br><br>
    <a href="{{ url('/sample/orphans.xlsx') }}">Download Sample</a>
    <a href="{{route('pdf')}}">Download PDF </a>
</form>
<br /> <br />
@isset($orphans)
     <table border="2" style="justify-content: center">
         <thead>
             <tr>
                 <th style="text-align: center">id number</th>
                 <th style="text-align: center">orphan name</th>
             </tr>
         </thead>
         <tbody>
         @foreach($orphans as $orphan)
             <tr>
                 <td style="text-align: center"> {{$orphan->orphanNumber}}</td>
                 <td style="text-align: center">  {{$orphan->firstName.' '.$orphan->secondName.' '.$orphan->thirdName.' '.$orphan->lastName }}</td>
             </tr>
         @endforeach
         </tbody>

     </table>
@endisset
</body>
</html>

