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
        @foreach($tags as $tag)
            <tr>
                <td>
                    <div class="updates__descr">
                        Date
                    </div>
                    {{ \Carbon\Carbon::parse($tag->Date_Tag)->format('d.m.Y') }}
                </td>
                <td>
                    <div class="updates__descr">
                        Tags
                    </div>
                    {{ $tag->Tag }}
                </td>
                <td>
                    <div class="updates__descr">
                        Address
                    </div>
                    {{ $tag->Addresses }}
                </td>
                <td>
                    <div class="updates__descr">
                        Description
                    </div>
                    {{ $tag->Tag_description }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="updates__load-btn">
        <a href="#" class="my-btn">Load more ...</a>
    </div>
</section>
