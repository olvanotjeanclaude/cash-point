<div class="col-12">
    <div class="card directory-card">
        <div class="p-3 bg-transparent card-header d-flex justify-content-between">
            <h6 class="mt-1 text-uppercase">ŞÜBE BİLGİLERİ</h6>
            <div>
                <a class="btn btn-primary"
                    href="{{ route('admin.user.create_branch', ['user_type' => 'customer', 'id' => $customer->id]) }}">
                    <i class="fas fa-plus"></i>
                    Ekle
                </a>

            </div>
        </div>


        <div class="card-body">
            <x-branch.user-branch :branchs="$customer->branchs" />
        </div>
    </div>
</div>
