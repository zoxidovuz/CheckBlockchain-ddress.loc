<header>
    <div class="mycontainer header__wrapper">
        <a href="{{ route('default') }}">
            <div class="logo" itemscope itemtype="https://schema.org/Organization">
                <div class="logo__img" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                    <img src="{{ asset('/imgs/logo.png') }}" alt="logo" itemprop="contentUrl">
                </div>
                <div class="logo__text">
                    <div class="logo__title" itemprop="name">
                        CheckBlockchainАddress.com
                    </div>
                    <link itemprop="url" href="http://checkblockchainaddress.com">
                    <div class="logo__subtitle">
                        list of white and black addresses that includes all blockchains
                    </div>
                </div>
            </div>
        </a>
        <form action="{{ route('search') }}">
            <div class="search-panel">
                <input class="search-panel__input" name="q" type="text"
                       placeholder="Search Blockchain information, enter address"/>
                <div class="search-panel__icon" style="background: transparent">
                    <img src="{{ asset('/imgs/ic_outline-search.svg') }}" alt="search-icon">
                </div>

            </div>
        </form>
    </div>
</header>
