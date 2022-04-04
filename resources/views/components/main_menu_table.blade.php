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
