<div class="latest-reviews">
    <div class="latest-reviews__title">
        Latest Reviews
    </div>
    <div class="latest-reviews__mycontainer">
        @foreach($last_reviews as $review)
            @include('components.review')
        @endforeach
    </div>
</div>
