  {{-- foreach form card --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row intergration_row">
                                                @foreach($intergrations_data as $intergration)
                                                <div class="col-md-4">
                                                    <div class="card text-center p-3 @if($item_intergration->type == $intergration['type']) active @endif" data-type="{{$intergration['type']}}" data-name="{{$intergration['name']}}">
                                                        <div class="card-block">
                                                            @if($intergration['type'] == "none")
                                                            <h4 class="text-danger"><i class="fas fa-times fa-2x"></i></h4>
                                                            @else
                                                            <img src="{{ asset('img')."/".$intergration['logo'] }}">
                                                            @endif
                                                        </div>
                                                        <div class="mt-3 no-gutters">
                                                            <h6 class="card-title">{{$intergration['name']}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @foreach($intergrations_data as $intergration)
                                            
                                                @if($intergration['type'] != "none")
                                                <div class="form-intergration @if($item_intergration->type != $intergration['type']) d-none @endif" id="formIntergration{{$intergration['type']}}">
                                                    
                                                    <h4>{{$intergration['name']}}</h4>
                                                    <div class="alert alert-warning" role="alert">
                                                        {{$intergration['alert']}}
                                                    </div>
                                                    <div class="alert d-none" id="alert{{$intergration['type']}}" role="alert">
                                                        
                                                    </div>
                                                    <div class="d-none" id="spinner{{$intergration['type']}}">
                                                         <div class="d-flex align-items-center" >
                                                          <strong>Loading...</strong>
                                                          <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                                                        </div>
                                                    </div>
                                                    @foreach($intergration['fields'] as $field)

                                                        <div class="form-group">
                                                            <label class="form-label">@lang($field['label']) @if($field['required']) <span class="text-danger">*</span>@endif</label>
                                                            @php 
                                                                $field_value = $item_intergration->settings[$field['name']];
                                                            @endphp
                                                            @if (in_array($field['type'], ['text','number','email']))
                                                            <input type="{{$field['type']}}" name="{{$intergration['type']."[". $field['name']."]"}}" 
                                                            value="{{$field_value}}" 
                                                            placeholder="{{$field['placeholder']}}" class="form-control">
                                                            
                                                            @elseif($field['type'] == 'select')
                                                            <select name="{{$intergration['type']."[". $field['name']."]"}}" class="form-control" @if($field['required']) required @endif>
                                                                @foreach($field['options'] as $option)
                                                                    <option value="{{$option['value']}}">
                                                                        @lang($option['name'])
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
