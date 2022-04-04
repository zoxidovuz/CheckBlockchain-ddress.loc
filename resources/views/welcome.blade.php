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
                            @include('components.main_menu_table')
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
@section('page-script')
    <script>
        $(".updates__load-btn a").on("click", function(event){
            event.preventDefault();
            const url = $(this).attr('href');
            const this_selector = $(this);

            $.ajax({
                url,
                type: "GET",
                success: function(data){
                    $('tbody').append(data.html);
                    if(data.next){
                        this_selector.attr('href', data.next_page);
                    }else{
                        this_selector.remove();
                    }
                }
            })
        });
    </script>
@endsection
