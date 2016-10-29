<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Code Pro printing barcodes System</title>
    <link href="labels.css" rel="stylesheet" type="text/css" >
    <style>
    body {
        width: 12.5in;
        margin: .2in .1875in;
        }
        /*  Code39Azalea Copyright 2012 Jerry Whiting (CC BY-ND 3.0) azalea.com/web-fonts/  */
    @font-face{
        font-family:barcode;
        src:url('public/layout/css/Code39Azalea.eot') format('embedded-opentype'),
        url('public/layout/css/Code39Azalea.woff') format('woff'),
        url('public/layout/css/Code39Azalea.ttf') format('truetype'),
        url('public/layout/css/Code39Azalea.svg#Code39Azalea') format('svg');
        font-weight:normal;
        font-style:normal
    }   

    .label{
        /* Avery 5160 labels -- CSS and HTML by MM at Boulder Information Services */
        /*width: 2.025in;  plus .6 inches from padding */
        height: .175in; /* plus .125 inches from padding */
        text-align: center;
        overflow: hidden;

        /*outline: 1px dotted;  outline doesn't occupy space like border does */
        }
    .holder{
        height: .775in; /* plus .125 inches from padding */
        padding: .130in .3in 0;
        margin-right: .125in; /* the gutter */
        float: left;
        text-align: center;
        overflow: hidden;
/*        outline-style:dotted;
        outline-width: 1px;*/
        width: 10%;
        margin-bottom: 0.5%;
    }

    p {
        font-size: 70%;
        padding-bottom: 0px !important;
        margin-bottom: 0px !important;
        padding-top: 0px !important;
        margin-top: 0px !important;
        text-align: center;
    }
    .page-break  {
        clear: left;
        display:block;
        page-break-after:always;
    }

    .label{
        font-family: barcode;
        font-size:47px;
        font-weight: lighter;
    }

    </style>

</head>
<body>

{{--*/ $key = 0 /*--}}
@foreach ($getData as $data)
            @for($index=0; $index<$data->quantity;$index++)
        	   <div class="holder">
                    <p>Myzoo clinic</p>
                    <div class="label">*{{$data->item_code}}*</div>
                    <p>{{substr(trim($data->item_name),0,25)}}</p>
                    <p>{{substr(trim($data->item_name),25,100)}}</p>
                    <p>(Code : {{$data->item_code}} ) {{$data->sell_dist_price}} LE</p>
                </div>
                {{-- <div class="page-break"></div> --}}
            @endfor
    {{--*/ $key++ /*--}}
@endforeach

{{HTML::Script($public_path."js/jquery.min.js")}}
<script type="text/javascript">
    $(function(){
        window.setTimeout(function(){
            window.print();
        }, 500)
    });
</script>
</body>
</html>