@extends('layouts.app')

@section('content')
    <main itemscope itemtype="https://schema.org/Article">
        <div class="mycontainer content-wrapper">
            <div class="main-content">
                <section class="block updates">
                    <h2 class="block__title">
                        Addresses:
                    </h2>
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
                    <div class="updates__load-btn">
                        <a href="#" class="my-btn">Load more ...</a>
                    </div>
                </section>
            </div>
        </div>

    </main>

@endsection
