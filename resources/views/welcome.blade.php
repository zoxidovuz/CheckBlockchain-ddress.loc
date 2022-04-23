@extends('layouts.app')
@section('title') Collected information about crypto addreses and social comments about addresses owner - Checkblockchainaddress.Com  @endsection

@section('meta')
    <meta name="description" content="We collect information about  addresses throw web.2.0 and web 3.0 and get it public. White and black list crypto addresses. Want more information" />
    <meta name="og:title" content="Collected information about crypto addreses and social comments about addresses owner - Checkblockchainaddress.Com " />
    <meta name="og:image" content="https://checkblockchainaddress.com/imgs/ogimage.jpg" />
    <meta name="og:description" content="We collect information about addresses throw web.2.0 and web 3.0 and get it public. White and black list crypto addresses. Want more information" />
    <meta name="og:url" content="https://checkblockchainaddress.com/" />
    <meta name="og:locale" content="{{ app()->getLocale() }}" />
    <meta name="og:site_name" content="Collected information about crypto addreses and social comments about addresses owner" />
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
                            @include('components.main_menu_table')
                        </tbody>
                    </table>
                    @if($addresses->hasMorePages())
                        <div class="updates__load-btn">
                            {{ $addresses->links() }}
                        </div>
                    @endif
                </section>
            </div>
        </div>

    </main>

@endsection

