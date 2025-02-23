<div class="modal fade deleteForm" id="deleteItemModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.delete') {{ $row->title }} </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('common.are_you_sure_to_delete_?')</h4>
                </div>
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                    <form action="{{ route('page_builder.pages.destroy') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $row->id }}">
                        <input  type="submit" class="primary-btn tr-bg" value="Delete"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
