@extends('layout.admin', ['title' => 'Комментарии'])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            @if($comments->count()>0)
            @foreach($comments as $comment)
            @include('admin.product.part.comment')       
            @endforeach
        {{$comments->links()}}     
        @else
Пусто
@endif 
    </div>
        </div>
    </div>
</div>


@endsection

