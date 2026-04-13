<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content border-0 shadow-lg" style="background: rgb(0 0 0 / 40%);">
            <!-- Header with Download & Close -->
            <div class="modal-header bg-dark py-2">
                <h5 class="modal-title text-white" id="documentModalLabel">Document Preview</h5>
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
                <div id="imageControls" class="text-center d-none z-3" style="position: absolute; bottom: 2%; right:2%;">
                   <div class="btn-group" style="background: #000;">
                       <button type="button" class="btn btn-sm btn-outline-secondary zoom-out text-white"><i class="fa fa-minus"></i></button>
                       <span class="btn btn-sm btn-outline-secondary zoom-level disabled fw-bold">70%</span>
                       <button type="button" class="btn btn-sm btn-outline-secondary zoom-in text-white"><i class="fa fa-plus"></i></button>
                       <button type="button" class="btn btn-sm btn-outline-secondary btn-reset text-white">Fit / Reset</button>
                       <button type="button" class="btn btn-sm btn-outline-secondary rotate text-white"><i class="fa fa-redo"></i> Rotate</button>
                   </div>
               </div>
                

                <!-- Viewer area – centered + scrollable -->
            </div>
        </div>
    </div>
</div>