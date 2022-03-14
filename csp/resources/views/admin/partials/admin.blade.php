{{-- Cards --}}
@include('admin.partials.includes.card')

{{-- Son On Müsteri --}}
@include('admin.partials.includes.transaction')

<div class="row">
    <div class="col-md-6">
        {{-- Son on Görüşmelerim --}}
        @include('admin.partials.includes.deposit')
    </div>
    <div class="col-md-6">
        {{-- Yaklaşan Görüşmelerim --}}
        @include('admin.partials.includes.retrait')
    </div>
</div>
