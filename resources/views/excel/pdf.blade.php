<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body{
            font-family: 'XBRiyaz', sans-serif;
            direction: rtl;
        }
        @page {
            header: page-header;
            footer: page-footer;
            background: url('{{public_path('/asset/img/reportImage.png')}}') no-repeat 0 0;
            background-image-resize: 6;
        }

    </style>
</head>
<body>
    <h3 align="center">Customer Data</h3>
    <table align="center"  style="border-collapse: collapse; border: 0px;">
        <tr>
            <th style="border: 1px solid; padding:12px;" >رقم اليتيم</th>
            <th style="border: 1px solid; padding:12px;" >اسم اليتيم</th>
        </tr>
        @foreach($orphans as $orphan)
        <tr>
            <td style="border: 1px solid; padding:12px;">{{$orphan['orphanNumber']}}</td>
            <td style="border: 1px solid; padding:12px;">{{$orphan['firstName'].' '.$orphan['secondName'].' '.$orphan['thirdName'].' '.$orphan['lastName']}}</td>
        </tr>;
        @endforeach
       </table>
    </body>
</html>
