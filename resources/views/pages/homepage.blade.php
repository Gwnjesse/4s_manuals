<x-layouts.app>

    <x-slot:introduction_text>
        <p><img src="img/afbl_logo.png" align="right" width="100" height="100">{{ __('introduction_texts.homepage_line_1') }}</p>
        <p>{{ __('introduction_texts.homepage_line_2') }}</p>
        <p>{{ __('introduction_texts.homepage_line_3') }}</p>
    </x-slot:introduction_text>

    <h1>
        <x-slot:title>
            {{ __('misc.all_brands') }}
        </x-slot:title>
    </h1>

    @php
        $size = count($brands);
        $columns = 3;
        $chunk_size = ceil($size / $columns);
        $letters = [];
    @endphp

    <div class="letter-navigation">
        @foreach($brands as $brand)
            @php
                $first_letter = strtoupper(substr($brand->name, 0, 1));
            @endphp

            @if(!in_array($first_letter, $letters))
                <a href="#{{ $first_letter }}">{{ $first_letter }}</a>
                @php $letters[] = $first_letter; @endphp
            @endif
        @endforeach
    </div>

    <div class="container">
        <div class="top10">
            <h2>top 10 manuals hoi:</h2>
            <ul>
                @foreach($topManuals as $manual)
                @if($manual->brand)
                <li>
                    <a href="{{ route('manual.redirect', $manual->id) }}">{{ $manual->name }}</a>
                </li>
            @else
                <li>
                    <p>{{ $manual->name }} (No brand available)</p>
                </li>
            @endif
                @endforeach
            </ul>
        </div>
        <div class="row">
            @foreach($brands->chunk($chunk_size) as $chunk)
                <div class="col-md-4">
                    <ul>
                        @php $header_first_letter = null; @endphp

                        @foreach($chunk as $brand)
                            @php
                                $current_first_letter = strtoupper(substr($brand->name, 0, 1));
                            @endphp

                            @if ($current_first_letter !== $header_first_letter)
                                @if (!is_null($header_first_letter))
                                    </ul>
                                @endif
                                <h2 id="{{ $current_first_letter }}">{{ $current_first_letter }}</h2>
                                <ul>
                            @endif

                            <li>
                                <a href="/{{ $brand->id }}/{{ $brand->getNameUrlEncodedAttribute() }}/">{{ $brand->name }}</a>
                            </li>

                            @php $header_first_letter = $current_first_letter; @endphp
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
    <button onclick="scrollToTop()" id="scrollTopBtn" title="Ga naar boven">⬆</button>
</x-layouts.app>
