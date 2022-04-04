@foreach($reviews as $review)
    <div class="reviews__item" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
        <div class="reviews__header">
            <div class="link" itemprop="author" itemscope itemtype="http://schema.org/Person">
                <span itemprop="name">{{  Str::limit($review->Name, 30) }}</span>
            </div>
            <div class="reviews__stars" itemprop="aggregateRating" itemscope itemtype="http://schema.org/Rating">
                <meta itemprop="worstRating" content = "1">
                <meta itemprop="bestRating" content = "5">
                <meta itemprop="ratingValue" content = "{{ $review->Rating }}">
                @for($i = 1; $i <= 5; $i++)
                    @if($review->Rating >= $i)
                        <img src="{{ asset('/imgs/ic_baseline-star-rate.svg') }}" alt="star">
                    @else
                        <img src="{{ asset('/imgs/ic_baseline-star-outline.svg') }}" alt="star">
                    @endif
                @endfor
            </div>
        </div>
        <div class="latest-reviews__text" itemprop="text">{{ $review->Reviews_text }}</div>
        <div class="tags">
            @foreach($review->tags as $tag)
                <div class="tags__cloud">{{ $tag->Tag }}</div>
            @endforeach

        </div>
    </div>
@endforeach
