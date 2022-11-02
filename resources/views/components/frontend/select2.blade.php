@props([
    'optionLabel' => 'label',
    'optionValue' => 'id',
    'options' => []

])

<div>
    <label for="" class="text-brand-link">Marke</label>
    <select {{ $attributes->wire('model') }} class="form-select appearance-none
              w-full
              px-2
              py-3
              mr-6
              text-base
              font-normal
              text-gray-700
              bg-blue xbg-clip-padding bg-no-repeat
              border border-solid border-gray-300
              transition
              ease-in-out
              m-0
              hover:border-brand
              focus:text-gray-700 focus:bg-white focus:border focus:border-brand  focus:outline-none"
                >
        <option disabled>-Select-</option>
        @foreach($options as $option)
            <option class="appearance-none p-3" value="{{$option[$optionValue]}}">{{$option[$optionLabel]}}</option>
        @endforeach
    </select>
</div>

@pushOnce('styles')
<style>
    .form-select {
        -moz-padding-start: calc(.75rem - 3px);
        background-position: right .75rem center;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='193.336px' height='96.668px' viewBox='0 0 193.336 96.668' enable-background='new 0 0 193.336 96.668' xml:space='preserve'%3E%3Cpolygon fill='%23737373' points='96.668,96.668 0,0 193.336,0 '/%3E%3C/svg%3E");
        background-size: 12px 12px
    }

    .form-select:focus {
        background-image: url("data:image/svg+xml,%3Csvg transform='rotate(180)' xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='193.336px' height='96.668px' viewBox='0 0 193.336 96.668' enable-background='new 0 0 193.336 96.668' xml:space='preserve'%3E%3Cpolygon fill='%23737373' points='96.668,96.668 0,0 193.336,0 '/%3E%3C/svg%3E");
    }
</style>
@endPushOnce
