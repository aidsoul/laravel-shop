@extends('layout.site', ['title' => 'Комментарии'])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body"style="width: 100%">
            @if($comments->count() == 0)
            <h4>Нет комментариев</h4>
            @endif
            @foreach($comments as $comment)
            @include('catalog.part.comment')       
            @endforeach

            @isset($user_status)
            <br>
            <div class="d-flex flex-column p-0 container-fluid " >
                <form method="post" action="{{ route('catalog.product.comment.create') }}" enctype="multipart/form-data">
                    <input type="text" name="slug" value="{{$product->slug}}" hidden>
                    @csrf
                    <div class="form-group">
                        <label data-help></label>
                        <textarea type="text" class="form-control" tag-remove-some name="comment" placeholder="Ваш комментарий"
                        required maxlength="500"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </form>
            </div>
            @endisset
            </div>
    </div>
    {{$comments->links()}}
</div>
</div>
<script src="{{ asset('js/validation/sometag.js') }}"></script>
@endsection

