<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            <span><i class="ti ti-playstation-circle me-2"></i>{{ __('Đăng') }}</span>
        </div>
        <div class="card-body d-flex justify-content-between p-2">
            <x-button.submit :title="__('Cập nhật')" />
        </div>
    </div>

</div>
<script>
    const currentUser = {
        isAdmin: {{ auth()->user()->isSuperAdmin ? 'true' : 'false' }},
        id: {{ auth()->id() }}
    };
</script>
