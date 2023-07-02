<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <title>{{ $item->sku }}</title>
    <style>
        div.qr-container {
            max-width: 6cm;
            max-height: 4cm;
            text-align: center;
        }
        div.qr-container img {
            width: 3cm;
            height: 3cm;
        }
        div.qr-container span {
            font-size: 20px;
        }
    </style>
</head>
<body>
<div class="qr-container">
    <img src="{!! $qrCode !!}" alt="{{ $item->sku }}"><br>
    <span>{{ $item->sku }}</span>
</div>
<script type="text/javascript">
    (function() {
        let beforePrint = function() {
            //
        };

        let afterPrint = function() {
            window.close();
        };

        if (window.matchMedia) {
            let mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function(mql) {
                if (mql.matches) {
                    beforePrint();
                } else {
                    afterPrint();
                }
            });
        } else {
            window.onbeforeprint = beforePrint;
            window.onafterprint = afterPrint;
        }

        window.print();
    }());
</script>
</body>
</html>
