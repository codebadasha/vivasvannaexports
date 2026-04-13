<div class="modal fade" id="ewayBillModal" tabindex="-1" aria-labelledby="ewayBillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content border-0 shadow-lg" style="background: rgb(0 0 0 / 40%);">
            <!-- Header with Download & Close -->
            <div class="modal-header bg-dark py-2">
                <h5 class="modal-title text-white" id="ewayBillModalLabel">Document Preview</h5>
                <div class="d-flex align-items-center gap-3">
                    <button id="btnDownload" class="btn btn-sm btn-outline-light text-white" title="Download">
                        <i class="fa fa-download"></i>
                    </button>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body p-0 position-relative" style="overflow-y: hidden;">
                <!-- Image-only toolbar (sticky) -->
                <div id="viewerContainer" class="d-flex justify-content-center align-items-center overflow-auto h-100 p-4">
                    <!-- Image or iframe injected here -->
                </div>
                <!-- Viewer area – centered + scrollable -->
            </div>
        </div>
    </div>
</div>