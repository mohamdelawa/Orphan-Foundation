<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body{
            font-family: 'XBRiyaz', sans-serif;

        }
        span{
            font-size: 16px;
        }

        body {
            background: url('{{public_path('/asset/img/reportImage.png')}}') no-repeat 0 0;
            background-image-resize: 6;
        }
        </style>
</head>
<body>
<div>
    <img class="image"  src="{{public_path('asset/img/profile2.jpg')}}" width="190" height="260" style="position: fixed; margin-left: 250px; margin-top: 230px">
</div>
<div >
    <div style="position: fixed; margin-left: 570px; margin-top: -145px;text-align: center;margin-bottom: 180px">
        <span style="font-size: 27px; color: white" ><b>2022</b></span>
    </div>
    <div style="position: fixed;  margin-top: 190px;text-align: right; width: 220px;">
        <span ><b>{{$orphanName}}ة</b></span>
    </div>
    <div style="position: fixed;margin-left: 360px;  margin-top: -30px;text-align: center;width: 220px">
        <span ><b>{{$orphanNumber}}</b></span>
    </div>
    <div style="position: fixed;  margin-top: 40px;text-align: right;width: 215px; height:50px;">
        <span ><b>{{$breadwinnerName}}</b></span>
    </div>
    <div style="position: fixed;margin-left: 360px;  margin-top: -40px;text-align: center;width: 220px;">
        <span ><b>{{$dob}}</b></span>
    </div>
    <div style="position: fixed;  margin-top: 60px;width: 200px; text-align: center">
        <span style="font-size: 18px"><b>{{$healthStatus}}</b></span>
    </div>
    <div style="position: fixed;margin-left: 360px;height: 45px;width: 215px;  margin-top: -35px;text-align: right;">
        <span style="font-size: 15px"><b>حفظ القرأن والعب على الحاسوب</b></span>
    </div>
    <div style="position: fixed;  margin-top: 20px;  width: 575px; height: 45px; text-align: right">
        <span style="font-size: 20px; margin: auto"><b>{{$address}}ر</b></span>
    </div>
    <div style="position: fixed;  margin-top: 25px;  width: 575px; height: 70px; text-align: right;">
        <span style="font-size: 20px; margin: auto"><b>هذا اليتبم بحاجة ماسة للكفالة وإن وضعه الاجتماعي سيء للغاية</b></span>
    </div>

    <div style="position: fixed; margin-left: 250px; margin-top: 15px; ">
        <span ><b>{{$date}}</b></span>
    </div>

</div>

</body>
</html>
