@extends('layout.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <form method="post" enctype="multipart/form-data" action="{{ route('admin.product.comment.update',['id'=>$comment->id]) }}">
                        @csrf
                        <h4>{{$comment->product->name}}</h4>
                        <h5 class="card-title">{{$comment->user->last_name}} {{$comment->user->first_name}} {{$comment->user->middle_name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{$comment->created_at}}</h6>
                        <br>
                        <div class="form-group">
                        <textarea class="form-control" name="comment" placeholder="Текст комментария" rows="4">{{$comment->text}}</textarea>
                        </div>
                        <div class="form-check form-check-inline">
                        <input type="checkbox" name="status" class="form-check-input" id="new-product" value="Ога">
                        <label class="form-check-label" for="new-product">Одобрить комментарий?</label>
                    </div>
                        <div class="form-group">
                        <button type="submit" class="btn btn-primary">Обновить</button>
                        </div>
                        

                    </form>     
    </div>

</div>

@endsection

