<div class="card alert-primary " style="width: 100%">
<div class="d-flex mb-2 justify-content-between container-fluid">
<div class="card-body">
<h5 class="card-title">{{$comment->user->last_name}} {{$comment->user->first_name}} {{$comment->user->middle_name}}</h5>
<h6 class="card-subtitle mb-2 text-muted">{{$comment->created_at}}</h6>
    <hr>
    <p class="card-text">{{$comment->text}}</p>
</div>
</div>
</div>
<br>