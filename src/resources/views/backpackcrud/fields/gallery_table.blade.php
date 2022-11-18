<?php
    $item_name = strtolower( isset($field['entity_singular']) && !empty($field['entity_singular']) ? $field['entity_singular'] : $field['label']);

    $items = (isset($field['value']) ? ($field['value']) : (isset($field['default']) ? ($field['default']) : '' ));

    // make sure not matter the attribute casting
    // the $items variable contains a properly defined JSON
    if(is_array($items)) {
        $items = count($items) ? json_encode($items) : '[]';
    } elseif (is_string($items) && !is_array(json_decode($items))) {
        $items = '[]';
    }

    if (is_string($items)) {
        $items = json_decode($items, true);
    }
?>
<!-- set a hidden field so captions gets sent as a field -->
<input type="hidden" name="captions"/>
@if (isset($field['value']) && count($field['value']))
<div class="array-container form-group col-md-12">
    <label>{!! $field['label'] !!}</label>
    <table class="table table-bordered table-striped m-b-0" >
        <thead>
            <tr>
                <th style="font-weight: 600!important;">
                    Preview
                </th>
                <th style="font-weight: 600!important;">
                    Caption
                </th>
            </tr>
        </thead>
        <tbody class="table-striped">
            @foreach($items as $file => $caption)
            <tr class="array-row ui-state-default">
                <td class="col-xs-2">
                    <a target="_blank" href="/img/{{ $file }}">
                        <img src="/img/{{ $file.'?w=50&h=50&fit=fill' }}" width="50" height="50"/>
                    </a>
                </td>
                <td class="col-xs-8">
                    <input class="form-control input-sm" type="text" name="captions[{{ $file }}]" value="{{ isset($caption) ? $caption : '' }}">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
@endif
