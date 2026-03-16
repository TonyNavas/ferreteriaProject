@props(['item' => null, 'width' => '50', 'height' => '50', 'position' => '', 'class' => '', 'style' => ''])

<img src="{{ $item->image ? $item->imageProduct : asset('noimage.jpg') }}"
    class="rounded {{ $position }} {{ $class }}" width="{{ $width }}" height="{{ $height }}"
    style="{{ $style }}">
