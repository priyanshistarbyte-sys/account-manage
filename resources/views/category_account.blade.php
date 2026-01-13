<div class="modal-body">

    @if($accounts->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">Id</th>
                        <th width="30%">Email</th>
                        <th width="25%">Password</th>
                        <th width="40%">Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $index => $account)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                <span >{{ $account->email }}</span>
                            </td>

                            <td>
                                <span>
                                    {{ $account->password }}
                                </span>
                            </td>

                            <td>
                                {{ $account->note ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-4">
            <i class="fa fa-folder-open fa-2x text-muted mb-2"></i>
            <p class="text-muted mb-0">No accounts found in this category.</p>
        </div>
    @endif

</div>
