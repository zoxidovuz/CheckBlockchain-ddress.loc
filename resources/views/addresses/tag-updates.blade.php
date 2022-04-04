<section class="block updates">
    <h2 class="block__title">
        Latest updates:
    </h2>
    <table class="updates__table">
        <thead>
        <tr>
            <td>Date</td>
            <td>Tags</td>
            <td>Address</td>
            <td>Description</td>
        </tr>
        </thead>
        <tbody>
            @include('addresses.tag_component')
        </tbody>
    </table>
    @if($tags->hasMorePages())
        <div class="updates__load-btn">
            <a href="{{ $tags->nextPageUrl() }}" class="my-btn">Load more ...</a>
        </div>
    @endif

</section>
