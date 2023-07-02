<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <title>{{ $item->sku }}</title>
    <style>
        div.barcode-container {
            max-width: 8cm;
            max-height: 3cm;
            text-align: center;
        }
        div.barcode-container img {
            width: 8cm;
            height: 1.5cm;
        }
        div.barcode-container span {
            font-size: 30px;
        }
    </style>
</head>
<body>
<div class="barcode-container">
    <img src="data:image/png;base64,{!! base64_encode($barcode) !!}" alt="{{ $item->sku }}"><br>
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
