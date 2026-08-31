<div class="d-flex justify-content-between mb-3">
    <div>
        <select class="form-control" wire:model.live = 'pagination'>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>

</div>

<div class="table-responsive">
    <table class="table table-sm table-hover text-center rounded overflow-hidden">
        <thead class="thead-light">
            <tr>
                {{$thead}}
            </tr>
        </thead>
        <tbody>
            {{$slot}}
        </tbody>
    </table>
</div>

<style>
    .thead-theme{
        background: #3b6ada !important;
        color: #ffff;
    }
</style>
