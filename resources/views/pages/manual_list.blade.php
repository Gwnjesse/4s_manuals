<x-layouts.app>

    <x-slot:head>
        <meta name="robots" content="index, nofollow">
    </x-slot:head>

    <x-slot:breadcrumb>
        <li><a href="/{{ $brand->id }}/{{ $brand->getNameUrlEncodedAttribute() }}/" alt="Manuals for '{{$brand->name}}'" title="Manuals for '{{$brand->name}}'">{{ $brand->name }}</a></li>
    </x-slot:breadcrumb>


    <h1>{{ $brand->name }}</h1>

    <p>{{ __('introduction_texts.type_list', ['brand'=>$brand->name]) }}</p>

    <table>
        <tr>
           @foreach ($manuals as $manual)
                    <td style="border: black solid 3px;">
                        <a href="{{ route('manual.redirect', $manual->id) }}" alt="{{ $manual->name }}" title="{{ $manual->name }}" target="{{ $manual->locally_available ? '_self' : '_blank' }}">
                            {{ $manual->name }}
                        </a>
                        ({{$manual->filesize_human_readable}})
                    </td>
                <br />
            @endforeach

        </tr>
    </table>
</x-layouts.app>
