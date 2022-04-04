@foreach($tags as $tag)
    <tr>
        <td>
            <div class="updates__descr">
                Date
            </div>
            {{ $tag->Date_tag->format('d.m.Y') }}
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
