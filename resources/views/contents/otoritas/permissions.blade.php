@extends('layouts.app')

@php
$plugins = ['swal'];
@endphp

@section('contents')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('otoritas.submit.permission') }}" method="post">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="role_id" value="{{ $role->id }}">
                    <div class="form-group">
                        <label for="role_name">Nama Otoritas</label>
                        <input type="text" name="role_name" id="role_name" class="form-control"
                            value="{{ Str::title($role->name) }}" readonly>
                    </div>
                    <div class="row">
                        @foreach ($menus as $menu)
                        <div class="col-12 form-group">
                            <label for="">{{ $menu->name }}</label>
                            <div class="form-group row">
                                @if (count($menu->child) == 0)
                                @foreach ($actions as $action)
                                <div class="col-1">
                                    <div class="custom-control custom-checkbox  mr-1">
                                        <input type="checkbox" value="1" class="custom-control-input"
                                            id="{{ $menu->id.'_'.$role->id.'_'.$action->id }}"
                                            name="{{ $menu->id.'_'.$role->id.'_'.$action->id }}" {{
                                            in_array($action->id,
                                        $menu->actions) ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                            for="{{ $menu->id.'_'.$role->id.'_'.$action->id }}">{{
                                            Str::ucfirst($action->name) }}</label>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                @php
                                $first_action = $actions[0];
                                @endphp
                                <div class="col-1 mb-3">
                                    <div class="custom-control custom-checkbox  mr-1">
                                        <input type="checkbox" value="1" class="custom-control-input"
                                            id="{{ $menu->id.'_'.$role->id.'_'.$first_action->id }}"
                                            name="{{ $menu->id.'_'.$role->id.'_'.$first_action->id }}" {{
                                            in_array($first_action->id,
                                        $menu->actions) ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                            for="{{ $menu->id.'_'.$role->id.'_'.$first_action->id }}">{{
                                            Str::ucfirst($first_action->name)
                                            }}</label>
                                    </div>
                                </div>
                                <div class="col-12 row ml-3">
                                    @foreach ($menu->child as $child)
                                    <div class="col-12 form-group">
                                        <label for="">{{ $child->name }}</label>
                                        <div class="form-group row">
                                            @foreach ($actions as $action)
                                            <div class="col-1">
                                                <div class="custom-control custom-checkbox  mr-1">
                                                    <input type="checkbox" value="1" class="custom-control-input"
                                                        id="{{ $child->id.'_'.$role->id.'_'.$action->id }}"
                                                        name="{{ $child->id.'_'.$role->id.'_'.$action->id }}" {{
                                                        in_array($action->id,
                                                    $child->actions) ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $child->id.'_'.$role->id.'_'.$action->id }}">{{
                                                        Str::ucfirst($action->name) }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
