{{-- Cards --}}
@include('admin.partials.includes.card')

{{-- Son On Müsteri --}}
@include('admin.partials.includes.customers')

<div class="row">
    <div class="col-xl-7">
        {{-- Son on Görüşmelerim --}}
        @include('admin.partials.includes.meeting')
    </div>
    <div class="col-xl-5">
        {{-- Yaklaşan Görüşmelerim --}}
        @include('admin.partials.includes.next-meeting')
    </div>
</div>
