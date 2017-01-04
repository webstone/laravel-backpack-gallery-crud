<?php
    $max = isset($field['max']) && (int) $field['max'] > 0 ? $field['max'] : -1;
    $min = isset($field['min']) && (int) $field['min'] > 0 ? $field['min'] : -1;
    $item_name = strtolower( isset($field['entity_singular']) && !empty($field['entity_singular']) ? $field['entity_singular'] : $field['label']);

    $items = old('images') ? (old('images')) : (isset($field['value']) ? ($field['value']) : (isset($field['default']) ? ($field['default']) : '' ));

    // make sure not matter the attribute casting
    // the $items variable contains a properly defined JSON
    if(is_array($items)) {
        if (count($items)) {
            $items = json_encode($items);
        }
        else
        {
            $items = '[]';
        }
    } elseif (is_string($items) && !is_array(json_decode($items))) {
        $items = '[]';
    }

    if (is_string($items)) {
        $items = json_decode($items, true);
    }
?>
<!-- upload multiple input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>

	{{-- Show the file name and a "Clear" button on EDIT form. --}}
	@if (isset($field['value']) && count($field['value']))
    <div class="well well-sm file-preview-container">
    	@foreach($items as $key => $item)
    		<div class="file-preview">
                <div class="row">
                    <div class="col-xs-2">
    	    		     <a target="_blank" href="{{ asset($item['image_path']) }}"><img src="{{ asset($item['thumbnail_path'].'.png') }}" width="50" height="50"/></a>
                    </div>
                    <div class="col-xs-8">
                        <input class="form-control input-sm" type="text" name="captions[{{ $item['image'] }}]" value="{{ isset($item['caption']) ? $item['caption'] : '' }}">
                    </div>
                    <div class="col-xs-2">
                        <label for="images[{{ $item['image'] }}]">
                            <input type="checkbox" name="images[{{ $item['image'] }}]" id="images[{{ $item['image'] }}]" value="1" @if($item['live'])checked="checked" @endif/> Include
                        </label>
                    </div>
                </div>
	    	</div>
    	@endforeach
    </div>
    @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
