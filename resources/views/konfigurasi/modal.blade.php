<div class="modal fade text-left" id="modal-konfigurasi" tabindex="-1" role="dialog" aria-labelledby="modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="default-form" action="{{ route('roles.store') }}" function-callback="afterAction">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Role Name:</label>
                            <input type="text" placeholder="Role Name" name="name" id="name" required class="form-control" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <h5 class="my-3">Assign Permissions</h5>
                        <div class="form-check form-check-primary">
                            <input class="form-check-input all_checked" type="checkbox" id="select-all">
                            <label class="form-check-label" style="font-size: 10pt;" for="select-all">Select All</label>
                        </div>
                        <div class='form-group'>
                            <div class="row">
                                @php
                                    $i = 0;
                                    
                                    foreach ($permissions as $p) {
                                        $temp = [];
                                        $temp = explode('.', $p->name);
                                    
                                        $permissions_list['group'][$i] = $temp[0];
                                        $permissions_list['function'][$temp[0]][] = ['name' => $temp[1], 'id' => $p->uuid];
                                        $permissions_list['id'][$temp[0]][] = $p->name;
                                    
                                        $i++;
                                    }
                                    
                                    $permissions_list['group'] = array_unique($permissions_list['group']);
                                    $chunk = array_chunk($permissions_list['group'], 4);

                                    $listIdCheckbox = '';
                                @endphp
                                @foreach ($chunk as $k => $item)
                                    @foreach ($item as $key => $val)
                                        @if ($key == 0)<div class="row">@endif
                                        <div class="col-sm-3 my-auto">
                                            <span class="badge text-wrap text-start bg-label-primary my-1" style="font-size: 10pt;">{{ ucwords(str_replace('_', ' ', $val)) }}</span>
                                        </div>
                                        @if (count($item) == ($key + 1))</div>@endif
                                    @endforeach
                                    @foreach ($item as $key => $val)
                                        @if ($key == 0)<div class="row">@endif
                                        <div class="col-sm-3 my-2">
                                            @foreach ($permissions_list['function'][$val] as $index => $value)
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input checkbox check-all" name="permission_id[]" type="checkbox" value="{{ $value['id'] }}" id="{{ $permissions_list['function'][$val][$index]['name'] . $i }}">
                                                    <label class="form-check-label" style="font-size: 10pt;" for="{{ $permissions_list['function'][$val][$index]['name'] . $i }}">{{ ucwords(str_replace('_', ' ', $value['name'])) }}</label>
                                                </div>
                                                @php
                                                    $listIdCheckbox = strval($permissions_list['function'][$val][$index]['name'] . $i) . '|' . $listIdCheckbox;
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </div>
                                        @if (count($item) == ($key + 1))</div>@endif
                                    @endforeach

                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>