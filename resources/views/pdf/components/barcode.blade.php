<div class="x-barcode">
    <table>
        <tr>
            <td class="border-tl x-barcode-corner"></td>
            <td></td>
            <td class="border-tr x-barcode-corner"></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="constrain">
                    @php
                        // Make Barcode object of Code128 encoding.
                        $barcode = (new Picqer\Barcode\Types\TypeCode128())->getBarcode(($slot != "" && $slot != null ? $slot : "000000000000000"));

                        // Output the barcode as HTML in the browser with a HTML Renderer
                        //$renderer = new Picqer\Barcode\Renderers\HtmlRenderer();
                        $renderer = new Picqer\Barcode\Renderers\DynamicHtmlRenderer();
                        echo $renderer->render($barcode);
                    @endphp
                </div>
                <div class="x-barcode-blockout">
                    <p class="copy-bold line-height-100">
                        {{$slot}}
                    </p>
                </div>
            </td>
        </tr>
        <tr>
            <td class="border-bl x-barcode-corner"></td>
            <td></td>
            <td class="border-rb x-barcode-corner"></td>
        </tr>
    </table>
</div>