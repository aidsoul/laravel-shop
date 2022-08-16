@php($level++)
@foreach ($items->where('parent_id', $parent) as $item)
    <tr>
        <td>
        @if ($item->image)
                        @php($url = url('storage/catalog/category/image/' . $item->image))                        
                        @else
                        @php($url = "https://via.placeholder.com/600x300")
                        @endif
                        <img src="{{ $url }}" alt="" class="img-fluid">
        </td>
        <td>
            @if ($level)
                {{ str_repeat('—', $level) }}
            @endif
            <a href="{{ route('admin.category.show', ['category' => $item->id]) }}"
               style="font-weight:@if($level) normal @else bold @endif">
                {{ $item->name }}
            </a>
        </td>
        <td>{{ iconv_substr($item->content, 0, 150) }}</td>
        @canany(['admin','operator'])
        <td>
            <a href="{{ route('admin.category.edit', ['category' => $item->id]) }}">
                <i class="far fa-edit"></i>
            </a>
        </td>
        <td>
            <form action="{{ route('admin.category.destroy', ['category' => $item->id]) }}"
                  method="post" onsubmit="return confirm('Удалить эту категорию?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                    <i class="far fa-trash-alt text-danger"></i>
                </button>
            </form>
        </td>
        @endcanany
    </tr>
    @if (count($items->where('parent_id', $parent)))
        @include('admin.category.part.tree', ['level' => $level, 'parent' => $item->id])
    @endif
@endforeach
