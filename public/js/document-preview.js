
    $(document).on('click', '.openDocument', function () {
        const id  = $(this).data('id');
        const type = $(this).data('type');
        const token = $(this).data('token');
        const documentId = $(this).data('document-id');
        const url = $(this).data('url');
        const fileName   = $(this).text().trim();

        $('#documentModalLabel').text(fileName || 'Document Preview');
        const $container = $('#viewerContainer').html(`
                <div class="text-center py-5 my-5">
                    <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-4 fs-5 fw-medium text-muted">Loading document, please wait...</p>
                </div>
            `);
        const modal = new bootstrap.Modal('#documentModal');
                modal.show();
        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: token,
                type: type,
                id: id,
                document_id: documentId
            },
            xhrFields: { responseType: 'blob' },
            success: function (blob, status, xhr) {
                const contentType = xhr.getResponseHeader('Content-Type') || '';
                const blobUrl     = URL.createObjectURL(blob);

                // $('#documentModal').on('shown.bs.modal', function() {
                    $container.empty();
                    $('#imageControls').addClass('d-none');

                    window.currentBlobUrl = blobUrl;   // for download
                    window.currentFileName = fileName;

                    if (contentType.includes('pdf') || fileName.toLowerCase().endsWith('.pdf')) {
                        // PDF - native viewer + default ~65-70% scale feel
                        $container.html(`
                            <iframe src="${blobUrl}#zoom=70" 
                                    class="border shadow-lg" 
                                    style="width:90vw; max-width:1200px; height:90vh; border-radius:8px;">
                            </iframe>
                        `);
                    } else if (contentType.includes('image') || /\.(jpg|jpeg|png|gif)$/i.test(fileName)) {
                        // Image - custom zoom/pan with default ~70%
                        renderImageViewer($container, blobUrl);
                    } else {
                        $container.html('<div class="alert alert-info text-center p-5 fs-4">Preview not supported for this file type</div>');
                    }
                // });
                

                // Cleanup
                $('#documentModal').one('hidden.bs.modal', function () {
                    URL.revokeObjectURL(blobUrl);
                    $container.empty();
                });
            },
            error: function (xhr, status, error) {
                console.log('Error details:', xhr.status, xhr.responseText, status, error); // ← add this for debugging

                let msg = 'Failed to load document. Please try again.';
                // if (xhr.status === 419) msg = 'CSRF error - refresh page';
                if (xhr.status === 404 || xhr.status === 400) msg = 'Document not found';
                if (xhr.status >= 500) msg = 'Server error';

                $('#viewerContainer').html(`
                    <div class="text-center py-5 my-5">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 4rem;"></i>
                        <p class="mt-4 fs-5 fw-medium text-danger">${msg}</p>
                        <small>Error code: ${xhr.status}</small>
                    </div>
                `);
            }
        });
    });

    $(document).on('click', '.viewEwayBill', function () {
        const url = $(this).data('url');
        const fileName   = $(this).text().trim();

        $('#documentModalLabel').text(fileName || 'Document Preview');
        const $container = $('#viewerContainer').html(`
                <div class="text-center py-5 my-5">
                    <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-4 fs-5 fw-medium text-muted">Loading Ewaybill, please wait...</p>
                </div>
            `);
        const modal = new bootstrap.Modal('#documentModal');
                modal.show();
        $.ajax({
            url: url,
            method: "GET",
            xhrFields: { responseType: 'blob' },
            success: function (blob, status, xhr) {
                const blobUrl     = URL.createObjectURL(blob);
                $container.empty();

                window.currentBlobUrl = blobUrl;   // for download
                window.currentFileName = fileName;

                $container.html(`
                    <iframe src="${blobUrl}#zoom=70" 
                            class="border shadow-lg" 
                            style="width:90vw; max-width:1200px; height:90vh; border-radius:8px;">
                    </iframe>
                `);

                // Cleanup
                $('#documentModal').one('hidden.bs.modal', function () {
                    URL.revokeObjectURL(blobUrl);
                    $container.empty();
                });
            },
            error: function (xhr, status, error) {
                console.log('Error details:', xhr.status, xhr.responseText, status, error); // ← add this for debugging

                let msg = 'Failed to load document. Please try again.';
                if (xhr.status === 419) msg = 'CSRF error - refresh page';
                if (xhr.status === 404 || xhr.status === 404) msg = 'Document not found';
                if (xhr.status >= 500) msg = 'Server error';

                $('#viewerContainer').html(`
                    <div class="text-center py-5 my-5">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 4rem;"></i>
                        <p class="mt-4 fs-5 fw-medium text-danger">${msg}</p>
                        <small>Error code: ${xhr.status}</small>
                    </div>
                `);
            }
        });
    });

    // Download handler
    $(document).on('click', '#btnDownload', function () {
        if (window.currentBlobUrl) {
            const a = document.createElement('a');
            a.href = window.currentBlobUrl;
            a.download = window.currentFileName || 'document';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });

    // ──────────────────────────────────────────────
    //   Image viewer - zoom/pan/rotate/default 70%
    // ──────────────────────────────────────────────
    function renderImageViewer(container, url) {
        let scale = 0.7;          // default ~70%
        let rotation = 0;
        let tx = 0, ty = 0;
        let isDragging = false;
        let startX, startY;

        container.html(`
            <img id="docImg" src="${url}" alt="Document" 
                style="max-width:none; transform-origin: center; box-shadow: 0 10px 30px rgba(0,0,0,0.2); border-radius:6px; cursor:grab;">
        `);

        $('#imageControls').removeClass('d-none');
        const $img = $('#docImg');
        const $zoomDisplay = $('.zoom-level');

        function updateView() {
            $img.css('transform', `translate(${tx}px, ${ty}px) rotate(${rotation}deg) scale(${scale})`);
            $zoomDisplay.text(Math.round(scale * 100) + '%');
        }

        // Controls
        $('.zoom-in').on('click', () => { scale = Math.min(scale + 0.15, 5); updateView(); });
        $('.zoom-out').on('click', () => { scale = Math.max(scale - 0.15, 0.3); updateView(); });
        $('.btn-reset').on('click', () => { scale = 0.7; rotation = 0; tx = ty = 0; updateView(); });
        $('.rotate').on('click', () => { rotation = (rotation + 90) % 360; updateView(); });

        // Wheel zoom (centered on cursor)
        $img.on('wheel', e => {
            e.preventDefault();
            const delta = e.originalEvent.deltaY < 0 ? 0.12 : -0.12;
            const oldScale = scale;
            scale = Math.max(0.3, Math.min(5, scale + delta));

            const rect = $img[0].getBoundingClientRect();
            const mx = e.clientX - rect.left;
            const my = e.clientY - rect.top;

            tx -= (mx / oldScale) * (scale - oldScale);
            ty -= (my / oldScale) * (scale - oldScale);

            updateView();
        });

        // Drag to pan
        $img.on('mousedown', e => {
            if (scale <= 1) return;
            isDragging = true;
            startX = e.clientX - tx;
            startY = e.clientY - ty;
            $img.css('cursor', 'grabbing');
        });

        $(document).on('mousemove.docview', e => {
            if (!isDragging) return;
            tx = e.clientX - startX;
            ty = e.clientY - startY;
            updateView();
        }).on('mouseup.docview mouseleave.docview', () => {
            isDragging = false;
            $img.css('cursor', scale > 1 ? 'grab' : 'default');
        });

        updateView(); // initial render at 70%
    }