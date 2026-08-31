<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="card border-0 shadow-sm">
        <div class="card-body py-3">
            <div class="d-flex align-items-center">

                <div class="icon-circle mr-3">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <small class="text-muted d-block font-weight-bold">
                        Total productos
                    </small>

                    <h3 class="mb-0 font-weight-bold">
                        {{ $products->count() }}
                    </h3>

                    <small class="text-muted">
                        Todos los productos
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="card border-0 shadow-sm">
        <div class="card-body py-3">
            <div class="d-flex align-items-center">

                <div class="icon-circle mr-3">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <small class="text-muted d-block font-weight-bold">
                        Total productos
                    </small>

                    <h3 class="mb-0 font-weight-bold">
                        {{ $products->count() }}
                    </h3>

                    <small class="text-muted">
                        Todos los productos
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="card border-0 shadow-sm">
        <div class="card-body py-3">
            <div class="d-flex align-items-center">

                <div class="icon-circle mr-3">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <small class="text-muted d-block font-weight-bold">
                        Total productos
                    </small>

                    <h3 class="mb-0 font-weight-bold">
                        {{ $products->count() }}
                    </h3>

                    <small class="text-muted">
                        Todos los productos
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="card border-0 shadow-sm">
        <div class="card-body py-3">
            <div class="d-flex align-items-center">

                <div class="icon-circle mr-3">
                    <i class="fas fa-tag"></i>
                </div>
                <div>
                    <small class="text-muted d-block font-weight-bold">
                        Total productos
                    </small>

                    <h3 class="mb-0 font-weight-bold">
                        {{ $products->count() }}
                    </h3>

                    <small class="text-muted">
                        Todos los productos
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #eef4ff;
        color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .card {
        border-radius: 16px;
    }
</style>
