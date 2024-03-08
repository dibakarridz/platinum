
<table id="dataTable" class="table table-striped table-responsive-sm" style="min-width: 845px">
    <thead>
        <tr>
            <th class="checkbox_custom_style text-center">
                <input name="multi_check" type="checkbox" id="multi_check"
                    class="chk-col-cyan" onclick="checkall()"/>
                <label for="multi_check"></label>
            </th>
            <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">
                # <i id="id_icon"></i>
            </th>
            <th class="sorting" data-sorting_type="asc" data-column_name="unique_id" style="cursor: pointer">
                Unique ID <i id="unique_id_icon"></i>
            </th>
            <th>Domain</th>
            <th>Status </th>
            <th>Action </th>
        </tr>
    </thead>
    <tbody>
        @forelse($domains as $key =>$value)
            <tr>
                <th class="text-center">
                    <input name="single_check" value="{{ $value->id }}"
                            type="checkbox" id="single_check_{{ $key+1 }}"
                            class="chk-col-cyan selects single_check "/>
                    <label for="single_check_{{ $key+1 }}"></label>
                </th>
                <td>{{ $key + 1 }}</td>
                <td>{{ $value->unique_id }}</td>
                <td>{{ $value->domain_name }}</td>
                <td>
                    @if($value->status == 1)
                        <span class="badge light badge-success">Active</span>
                    @else
                        <span class="badge light badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="dropdown ms-auto text-right" style="cursor: pointer;">
                        <div class="btn-link" data-bs-toggle="dropdown">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{route('admin.domains.edit',['domain' => $value->id])}}" title="Edit"><i class="fas fa-pencil-alt" style="color: blue;"></i> Edit</a>
                            
                            <a class="dropdown-item" data-bs-target="#deleteConfirm" href="javascript:void(0);" 
                                data-bs-toggle="modal" title="Delete" 
                                onclick="deleteConfirm('{{ route('admin.domains.destroy',['domain' => $value->id])}}','Are you sure you, want to delete?')"><i class="fa fa-trash" style="color: red;"></i> Delete</a>
                            
                            <a class="dropdown-item" data-bs-target="#statusChange"
                                href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                onclick="statusChange('{{ route('admin.domain.status', $value->id) }}')">
                                <i class="fas fa-toggle-on pr-1" style="color: green;"></i> Status
                            </a>
                            
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-red">No data available in table</td></tr>
        @endforelse
    </tbody>
</table>
<div class="col-sm-12 d-flex flex-row-reverse align-items-center">
    {!! $domains->links() !!}
</div>