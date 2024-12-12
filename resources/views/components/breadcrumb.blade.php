<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h4 class="page-title">{{ $title }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $li_1 }}</a></li>
                        @if(isset($li_2))
                            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $li_2 }}</a></li>
                        @endif
                        @if(isset($li_3))
                            <li class="breadcrumb-item active">{{ $li_3 }}</li>
                        @endif
                    </ol>
                </div><!--end col-->
                @if(isset($btn_create))
                <div class="col-auto align-self-center">
                    <a class=" btn btn-sm btn-soft-primary btn-create" href="{{ $btn_create }}" role="button"><i class="fas fa-plus me-2"></i>Create</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

