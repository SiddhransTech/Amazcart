<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @php
           $value = [
            "name" => $category->name,
            "slug" => $category->slug,
            "icon" => $category->icon,
            "searchable" => $category->searchable,
            "status" => $category->status,
            "commission_rate" => $category->commission_rate,
            'image' => $category->categoryImage->image
           ];
        @endphp
        <a data-value="{{ json_encode($value) }}" class="dropdown-item show_category">{{ __('common.show') }}</a>
        <a data-id="{{$category->id}}" class="dropdown-item copy_id">{{ __('product.Copy ID') }}</a>
        @if (permissionCheck('product.category.edit'))
            <a class="dropdown-item edit_category" data-id="{{$category->id}}">{{__('common.edit')}}</a>
        @endif
        @if (permissionCheck('product.category.delete'))
            <a class="dropdown-item delete_brand" data-id="{{$category->id}}">{{__('common.delete')}}</a>
        @endif
    </div>
</div>
