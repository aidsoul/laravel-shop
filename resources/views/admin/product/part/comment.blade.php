<div class="card alert-primary " style="width: 100%">
<div class="d-flex mb-2 justify-content-between container-fluid">
<div class="p-2">
    <a href="{{ route('admin.product.comment.edit', ['id' => $comment->id]) }}">
                        <i class="far fa-edit"></i>
                    </a>
    </div>
    <div class="p-2">
    <form action="{{ route('admin.product.comment.delete', ['id' => $comment->id]) }}"
                        method="get" onsubmit="return confirm('Удалить этот комментарий?')">
                        @csrf
                        <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                            <i class="far fa-trash-alt text-danger"></i>
                        </button>
                    </form>
    </div>
</div>
<div class="card-body">
<h4>{{$comment->product->name}}</h4>
<h5 class="card-title">{{$comment->user->last_name}} {{$comment->user->first_name}} {{$comment->user->middle_name}}</h5>
<h6 class="card-subtitle mb-2 text-muted">{{$comment->created_at}}</h6>
    <hr>
    <p class="card-text">{{$comment->text}}</p>
</div>
</div>
<br>