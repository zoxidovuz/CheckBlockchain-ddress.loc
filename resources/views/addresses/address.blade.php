@extends('layouts.app')
@section('title') {{ $addressBlock->Addresses . ", " . $addressBlock->Blockchain . " - " . config('app.name') }} @endsection
@section('meta')
    @include('components.meta')
@endsection

@section('page-head')
    {!! htmlScriptTagJsApi() !!}
@endsection
@section('content')
    <main itemscope itemtype="https://schema.org/Article">
        @include('components.alert')
        <div class="mycontainer content-wrapper">
            <div class="main-content">
                @include('addresses.card')
                @include('addresses.tag-updates')
                @include('addresses.sales')
                @include('addresses.feedback')
                @include('addresses.coming')

            </div>

            @include('addresses.reviews')
        </div>
    </main>

@endsection
@section('page-script')
    <script>
        var star = "{{ asset('/imgs/ic_baseline-star-rate.svg') }}";
        var noneStar = "{{ asset('/imgs/ic_baseline-star-outline.svg') }}";

        $('.set_rating').on("click", function(event){
            event.preventDefault();
            const rating = parseInt($(this).attr('id'));
            for (let i = 1; i <= 5; i++){
                if(i <= rating){
                    $("#" + i + " img").attr('src', star);
                }else{
                    $("#" + i + " img").attr('src', noneStar);
                }
            }

            $('input[name="rating"]').val(rating);
        });

        $('#feedback').submit(function(event){
            if(!$('input[name="rating"]').val()){
                alert("Please set rating!");
                event.preventDefault();
            }
        });

        $(".load_more").on("click", function(event){
            event.preventDefault();
            const url = $(this).attr('href');
            const this_selector = $(this);

            $.ajax({
                url,
                type: "GET",
                success: function(data){
                    this_selector.prev().append(data.html);
                    if(data.next){
                        this_selector.attr('href', data.next_page);
                    }else{
                        this_selector.remove();
                    }
                }
            })
        });

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
