<div class="modal fade" id="logOutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <span class="modal-close" data-bs-dismiss="modal"><img src="{{ asset('app/images/close.svg') }}" alt=""></span>
            <div class="modal-body account-delete has-btns">
                <div class="body-content">
                    <div class="title-block mob-mb0">
                        <em class="icon">
                            <img src="{{ asset('app/images/warning.svg') }}" alt="">
                        </em>
                        <h4 class="fixed-width">Are You Sure You Want To Logout?</h4>
                    </div>
                    <div class="modal-btn-block">
                        <a href="#" class="orange-btn is-bordered" title="Yes">Yes</a>
                        <a href="#" class="orange-btn" title="Cancel" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog msm-modal modal-dialog-centered">
        <div class="modal-content">
            <span class="modal-close" data-bs-dismiss="modal"><img src="{{ asset('app/images/close.svg') }}" alt=""></span>
            <div class="modal-body has-modal-title has-btns">
                <div class="modal-title">Review</div>
                <div class="modal-body-content">
                    <div class="review-block">
                        <form method="post">
                            <input type="hidden" name=""
                            <div class="ratings">
                                <select name="rating" id="star_rating" class="rating">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="review-form">
                                <textarea class="form-control" name="review" placeholder="What do you think about this product?"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-btn-block full-width">
                    <a href="#" class="orange-btn" title="Save & Continue" data-bs-dismiss="modal">Save & Continue</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="merchantApplicationSuccessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <span class="modal-close" data-bs-dismiss="modal"><img src="{{ asset('app/images/close.svg') }}" alt=""></span>
                <div class="modal-body account-delete is-success">
                    <div class="body-content">
                        <div class="title-block">
                            <em class="icon">
                                <img src="{{ asset('app/images/success-thumb.svg') }}" alt="">
                            </em>
                            <h4 class="fixed-width">Application Submitted Successfully!</h4>
                            <p>We will get back to you within 24 hours for the verification purpose. Thank you for showing your interest to sell your jewellery on our platform.</p>
                        </div>
                    </div><br/>
                    <div class="modal-btn-block full-width">
                        <a href="https://jmarkt.com" class="orange-btn" title="Save & Continue">Ok</a>
                    </div>
                </div>
            </div>
        </div>
    </div>