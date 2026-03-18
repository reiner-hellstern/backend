<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        canvas {
            width: 45%;
            aspect-ratio: 476/673;
            border: 2px solid black;
        }

        .top {
            display: flex;
            justify-content: center;
            /* background: red; */
        }

        .middle {
            display: flex;
            justify-content: center;
            align-items: center;
            /* background: lime; */
        }

        .loading {
            z-index: -100;
            position: absolute;
        }

        .bottom {
            display: flex;
            justify-content: center;
            /* background: yellow; */
        }
    </style>
</head>

<body>

    <div class="top">
        <select name="templates" id="templates">
            <option value="Template A">Template A</option>
            <option value="Template B">Template B</option>
        </select>
    </div>

    <div class="middle">
        <canvas id="the-canvas"></canvas>
        <span class="loading">PDF lädt...</span>
        <div class="data">
            <h1>Data</h1>
        </div>
    </div>

    <div class="bottom">
        <button id="prev">Previous</button>
        <button id="next">Next</button>
        &nbsp; &nbsp;
        <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.11.338/build/pdf.min.js"></script>
    <script>
        // If absolute URL from the remote server is provided, configure the CORS
        // header on that server.
        // var url = 'https://raw.githubusercontent.com/mozilla/pdf.js/ba2edeae/examples/learning/helloworld.pdf';
        var url = 'http://127.0.0.1:8000/dokumente/antrag-zuchtbuchuebernahme';

        // Loaded via <script> tag, create shortcut to access PDF.js exports.
        var { pdfjsLib } = globalThis;

        // The workerSrc property shall be specified.
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@2.11.338/build/pdf.worker.js';

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 3,
            canvas = document.getElementById('the-canvas'),
            ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function (page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').textContent = num;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Asynchronously downloads PDF.
         */
        pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;

            // Initial/first page rendering
            renderPage(pageNum);
        });
    </script>
</body>

</html>