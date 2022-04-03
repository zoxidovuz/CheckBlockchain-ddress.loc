<section class="block communication">
    <div class="communication__mycontainer">
        <div class="feedback">
            <form action="{{ route('feedback') }}" method="POST" id="feedback">
                @csrf
                <input type="hidden" value="{{ $addressBlock->ID_address }}" name="address">
                <h2 class="block__title">
                    Leave feedback
                </h2>

                <div class="feedback__mycontainer">
                    <div class="feedback__form-el">
                        <div class="feedback__desc">
                            Your name:
                        </div>
                        <div class="input-group mb-3">
                            <img class="feedback__user-icon" src="{{ asset('/imgs/ic_baseline-person-outline.svg') }}" alt="user icon">
                            <input type="text" class="form-control feedback__name" placeholder="Ivanov Ivan"
                                   name="name"
                                   aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>
                    </div>
                    <div class="feedback__form-el">
                        <div class="feedback__desc">
                            Type of tags:
                        </div>
                        <select name="tags[]" title="Chose tags:" class="form-control" id="example-multiple-selected"
                                multiple="multiple" required>
                            <option value="Scam">Scam</option>
                            <option value="Binance exchange">Binance exchange</option>
                            <option value="Existing StarAtlas account">Existing StarAtlas account</option>
                            <option value="Scam2">Scam2</option>
                        </select>
                    </div>
                    <div class="feedback__form-el feedback__rating">
                        <div class="feedback__desc ">
                            Rating:
                        </div>
                        <input type="hidden" name="rating">
                        <div class="feedback__stars mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <a href="#" class="set_rating" id="{{ $i }}">
                                    <img src="{{ asset('/imgs/ic_baseline-star-outline.svg') }}" alt="star">
                                </a>
                            @endfor
                        </div>
                    </div>
                    <div class="feedback__form-el">
                        <div class="feedback__desc">
                            Your reviev:
                        </div>
                        <div class="input-group mb-3">
								<textarea placeholder="Enter your text:..." class="form-control feedback__textarea"
                                          name="message"
                                                  aria-label="With textarea" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="feedback__captcha mb-3 feedback__form-el">
                    <div class="recaptcha__block">5+8=?</div>
                    <div class="input-group mb-3">
                        <input type="text" class=" mb-3 form-control recaptcha__input" placeholder="Enter capcha"
                               name="recapcha"
                               aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                </div>
                <button type="submit" class="my-btn">Send the rewiev</button>
            </form>
        </div>
        <div class="reviews">
            <h2 class="block__title">
                USER REVIEWS
            </h2>
            <div class="reviews__content">
                @if($reviews->items())
                    @include('addresses.review_content')
                    @if($reviews->hasMorePages())
                        <a href="{{ $reviews->nextPageUrl() }}" class="btn mt-4 load_more">Load more review</a>
                    @endif
                @else
                    No reviews. Be first, leave review now
                @endif
            </div>
        </div>

    </div>

</section>
