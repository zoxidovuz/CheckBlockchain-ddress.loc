<div class="latest-reviews__item">
    <div class="latest-reviews__item-header">
        <a href="{{ route('address-blockchain', [$review->Addresses, $review->Blockchain]) }}" class="link">
            {{ $review->Addresses }}
        </a>
        <div class="latest-reviews__comments">
            <img src="{{ asset('/imgs/ic_outline-chat.svg') }}" alt="comment icon">
            <div class="latest-review__count">{{ $review->reviews_count }}</div>
        </div>
    </div>
    <div class="latest-reviews__text">
        {{ $review->Reviews_text }}
    </div>
    <div class="tags">
        <div class="tags__cloud">{{ $review->Tag }}</div>
    </div>
</div>
