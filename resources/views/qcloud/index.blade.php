@extends('qcloud::layout')

@section('content')
<div>
  <list-contents route="{{ config('qcloud.ui_url') }}"></list-contents>
</div>
@endsection
