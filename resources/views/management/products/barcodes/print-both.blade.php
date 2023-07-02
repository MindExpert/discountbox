<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <title>{{ $item->sku }}</title>
    <style>
        div.barcode-wrapper {
            max-width: 8cm;
            max-height: 8cm;
            text-align: center;
        }
        div .qrCode {
            width: 3cm;
            height: 3cm;
        }
        div .barcode {
            width: 8cm;
            height: 1.5cm;
        }
        div.barcode-wrapper span {
            font-size: 30px;
        }
    </style>
</head>
<body>
<div class="barcode-wrapper">
    <img class="qrCode" src="{!! $qrCode !!}" alt="{{ $item->sku }}">
    <br/><br/>
    <img class="barcode" src="data:image/png;base64,{!! base64_encode($barcode) !!}" alt="{{ $item->sku }}">
    <br/><br/>
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