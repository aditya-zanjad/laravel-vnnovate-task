<!-- Begin: Content Header (Page Header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    Dashboard
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach ($breadcrumb as $itemName => $itemRoute)
                        <li class="breadcrumb-item">
                            <a href="{{ $itemRoute }}">
                                {{ $itemName }}
                            </a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- End: Content Header (Page Header) -->
