<section class="block owner">
    <div class="owner__header" itemprop="name">
        <div class="owner__header-description">
            Who's the owner of address:
        </div>
        <div class="owner__header-address">
            <h1>{{ $addressBlock->Addresses }}</h1>
        </div>
    </div>
    <div class="owner__descr" itemprop="description">
        <div>
            We've collected full information on address
        </div>
        <a href="#" class="link">
            {{ $addressBlock->Addresses }}
        </a>
        <ul class="block__ulist">
            <li class="block__uitem">
                opinion in crypto industies
            </li>
            <li class="block__uitem">
                type of activity
            </li>
            <li class="block__uitem">
                links with other wallets
            </li>
            <li class="block__uitem">
                tags
            </li>
            <li class="block__uitem">
                name of blockchain network
            </li>
        </ul>
    </div>
    <div class="owner__main-info">
        <table>
            <tbody>
            <tr>
                <td>
                    <div class="owner__key">
                        BlockChain:
                    </div>
                </td>
                <td>
                    {{ $addressBlock->Blockchain }}
                </td>
            </tr>
            <tr>
                <td>
                    <div class="owner__key">
                        Address rating:
                    </div>
                </td>
                <td>
                    <div class="owner__tag-mycontainer" itemprop="aggregateRating" itemscope
                         itemtype="https://schema.org/Rating">
                        <meta itemprop="worstRating" content="1">
                        <div class="owner__tag red">
                            <span itemprop="ratingValue">{{ $addressBlock->reviews_avg_rating ? round($addressBlock->reviews_avg_rating, 1) : '-' }}</span> / <span
                                itemprop="bestRating">5</span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="owner__key">
                        Number of page views:
                    </div>
                </td>
                <td>
                    <div class="owner__tag-mycontainer">
                        <div class="owner__tag">
                            {{ $addressBlock->analytic_count }}
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="owner__key">Feedbacks:</div>
                </td>
                <td>
                    <div class="owner__tag-mycontainer">
                        <div class="owner__tag">{{ $addressBlock->reviews_count }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="owner__key">
                        Tags:
                    </div>
                </td>
                <td>
                    <div class="owner__tag-mycontainer">
                        @foreach($addressBlock->tags as $tag)
                            @if(isset($tag->Tag))
                            <div class="owner__tag"><a href="{{ route('tags', str_replace(' ', '_', $tag->Tag)) }}">{{ $tag['Tag'] }}</a></div>
                            @endif
                        @endforeach

                        @foreach($tags_in_reviews as $tag)
                            @if(isset($tag->Tag))
                            <div class="owner__tag"><a href="{{ route('tags', str_replace(' ', '_', $tag->Tag)) }}">{{ $tag['Tag'] }}</a></div>
                            @endif
                        @endforeach
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="owner__view-all">
        <h3 class="owner__view-all-header block__title">
            View all transactions on
            <a href="{{ $explorer ? $explorer->Link_to_explorer . $addressBlock->Addresses: '#' }}" class="link" target="_blank">{{ $addressBlock->Blockchain }}</a>
        </h3>
        <div>
            How can I:
        </div>
        <ul class="block__ulist">
            <li class="block__uitem">
                Trace a {{ $addressBlock->Blockchain }} wallet owner using their wallet address?
            </li>
            <li class="block__uitem">
                Find out who owns a {{ $addressBlock->Blockchain }} address?
            </li>
            <li class="block__uitem">
                How to investigate a {{ $addressBlock->Blockchain }} address?
            </li>
            <li class="block__uitem">
                Is there any way to find the scammers via their {{ $addressBlock->Blockchain }} address?
            </li>
            <li class="block__uitem">
                How to black-list a {{ $addressBlock->Blockchain }} address to get money back?
            </li>
        </ul>
    </div>

</section>
