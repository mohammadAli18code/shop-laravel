{{ $i = 1 }}
@foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $i++ }}</td>
        <td><img class="product-image" src="{{ asset($product->images) }}" alt=""></td>
        <td>{{ $product->title }}</td>
        <td>{{ $product->parent_name }}</td>
        <td>{{ $product->category_name }}</td>
        <td>{{ number_format($product->price) }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->comment_count }}</td>
        <td>{{ $product->stock > 0 ? 'هست' : 'نیست' }}</td>
        <td>در حال بروزرسانی</td>
        @if ($product->status == 'approved')
            <td class="text-success">منتشر شده</td>
        @elseif($product->status == 'seen')
            <td style="color:#ffc107">در صف انتشار<br>(منتظر تایید)</td>
        @elseif($product->status == 'unseen')
            <td class="text-error">بررسی نشده</td>
        @endif
        <td>
            <a href="#" class="item-delete mlg-15 btn-product-action" data-action="delete"
                data-id="{{ $product->id }}" title="حذف"></a>
            <a href="#" class="item-reject mlg-15 btn-product-action" data-action="not-active"
                data-id="{{ $product->id }}" title="رد"></a>
            <a href="{{ route('admin.products.edit', [$product->id]) }}" target="_blank" class="item-eye mlg-15"
                title="مشاهده"></a>
            <a href="#" class="item-confirm mlg-15 btn-product-action" data-action="active"
                data-id="{{ $product->id }}" title="تایید"></a>
            <a href="{{ route('admin.products.edit', [$product->id]) }}" class="item-edit" title="ویرایش"></a>
        </td>
    </tr>
@endforeach
