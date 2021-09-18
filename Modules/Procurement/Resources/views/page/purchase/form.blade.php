<div class="form-group">
    
    {!! Form::label('name', 'Date', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('procurement_purchase_date_order') ? 'has-error' : ''}}">
        {!! Form::text('procurement_purchase_date_order', !empty($model->procurement_purchase_date_order) ? $model->procurement_purchase_date_order : date('Y-m-d'), ['class' =>
        'form-control date']) !!}
        {!! $errors->first('procurement_purchase_date_order', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', __('Supplier'), ['class' => 'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-md-4 col-sm-4 {{ $errors->has('procurement_purchase_to_id') ? 'has-error' : ''}}">
        {{ Form::select('procurement_purchase_to_id', $supplier, null, ['class'=> 'form-control ']) }}
        {!! $errors->first('procurement_purchase_to_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', __('Internal Notes'), ['class' => 'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-md-4 col-sm-4">
        {!! Form::textarea('procurement_purchase_notes_internal', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

    {!! Form::label('name', __('External Notes'), ['class' => 'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-md-4 col-sm-4">
        {!! Form::textarea('procurement_purchase_notes_external', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', __('Branch'), ['class' => 'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-md-4 col-sm-4 {{ $errors->has('procurement_purchase_branch_id') ? 'has-error' : ''}}">
        {{ Form::select('procurement_purchase_branch_id', $branch, $model->procurement_purchase_branch_id ?? 1, ['class'=> 'form-control ']) }}
        {!! $errors->first('procurement_purchase_branch_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', __('Status'), ['class' => 'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-md-4 col-sm-4 {{ $errors->has('procurement_purchase_status') ? 'has-error' : ''}}">
        {{ Form::select('procurement_purchase_status', $status, null, ['class'=> 'form-control ']) }}
        {!! $errors->first('procurement_purchase_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<hr>

@include($folder.'::page.'.$template.'.detail')
@include($folder.'::page.'.$template.'.script')