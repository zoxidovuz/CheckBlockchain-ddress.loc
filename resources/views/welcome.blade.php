@extends('layouts.app')
@section('title') COLLECTED INFORMATION ABOUT CRYPTO ADDRESES AND SOCIAL COMMENTS ABOUT ADDRESSES OWNER - CHECKBLOCKCHAINADDRESS.COM  @endsection

@section('meta')
    <meta name="description" content="WE COLLECT INFORMATION ABOUT  ADDRESSES THROW WEB.2.0 AND WEB 3.0 AND GET IT PUBLIC. WHITE AND BLACK LIST CRYPTO ADDRESSES. WANT MORE INFORMATION" />
    <meta name="og:title" content="COLLECTED INFORMATION ABOUT CRYPTO ADDRESES AND SOCIAL COMMENTS ABOUT ADDRESSES OWNER - CHECKBLOCKCHAINADDRESS.COM " />
    <meta name="og:image" content="http://checkblockchainaddress.com/imgs/ogimage.jpg" />
    <meta name="og:description" content="WE COLLECT INFORMATION ABOUT ADDRESSES THROW WEB.2.0 AND WEB 3.0 AND GET IT PUBLIC. WHITE AND BLACK LIST CRYPTO ADDRESSES. WANT MORE INFORMATION" />
    <meta name="og:url" content="http://checkblockchainaddress.com/" />
    <meta name="og:locale" content="{{ app()->getLocale() }}" />
    <meta name="og:site_name" content="COLLECTED INFORMATION ABOUT CRYPTO ADDRESES AND SOCIAL COMMENTS ABOUT ADDRESSES OWNER" />
    <meta name="og:type" content="website" />

@endsection
@section('content')
    <main itemscope itemtype="https://schema.org/Article">
        <div class="mycontainer content-wrapper">
            <div class="main-content">
                <section class="block updates">
                    <h1 class="block__title">
                        Addresses:
                    </h1>
                    <table class="updates__table">
                        <thead>
                        <tr>
                            <td>Blockchain</td>
                            <td>Address</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($addresses as $address)
                            <tr>
                                <td>
                                    <div class="updates__descr">
                                        Blockchain
                                    </div>
                                    {{ $address->Blockchain }}
                                </td>
                                <td>
                                    <div class="updates__descr">
                                        Address
                                    </div>
                                    <a href="{{ route('address-blockchain', [$address->Addresses, $address->Blockchain]) }}">{{ $address->Addresses }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($addresses->hasMorePages())
                        <div class="updates__load-btn">
                            <a href="{{ $addresses->nextPageUrl() }}" class="my-btn">Load more ...</a>
                        </div>
                    @endif
                </section>
            </div>
        </div>

    </main>

@endsection
