    @if (session('success'))
        <div class="card bg-success ">
            <div class="card-header "  style="padding-top: 5px;padding-bottom: 5px;">
                <h3 class="card-title">Message:</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body"  style="padding-top: 5px;padding-bottom: 5px;">
                {{ session('success') }}
            </div>
        </div>
    @endif
        @if (session('failed'))
            <div class="card bg-danger ">
                <div class="card-header "  style="padding-top: 5px;padding-bottom: 5px;">
                    <h3 class="card-title">Message:</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body"  style="padding-top: 5px;padding-bottom: 5px;">
                    {{ session('failed') }}
                </div>
            </div>
        @endif
    @if ($errors->any())
        <div class="card bg-danger ">
            <div class="card-header ">
                <h3 class="card-title">Errors:</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @foreach ($errors->all() as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        </div>
    @endif
