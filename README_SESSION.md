# Hướng dẫn sử dụng Session trong Laravel

## 1. Cách lưu dữ liệu vào Session

```php
// Lưu một giá trị vào session
session(['key' => 'value']);

// Hoặc sử dụng helper
Session::put('key', 'value');

// Lưu nhiều giá trị cùng lúc
Session::put([
    'key1' => 'value1',
    'key2' => 'value2'
]);
```

## 2. Ví dụ với Product

### 2.1 Lưu sản phẩm vào giỏ hàng sử dụng Session

```php
// Trong ProductController
public function addToCart($productId)
{
    $product = Product::find($productId);
    $cart = session()->get('cart', []);
    
    if(isset($cart[$productId])) {
        $cart[$productId]['quantity']++;
    } else {
        $cart[$productId] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->featured_image
        ];
    }
    
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
}
```

### 2.2 Lấy dữ liệu từ Session

```php
// Lấy tất cả sản phẩm trong giỏ hàng
$cart = session()->get('cart', []);

// Lấy một sản phẩm cụ thể
$product = session()->get('cart.' . $productId);

// Kiểm tra sản phẩm có tồn tại trong giỏ hàng
if(session()->has('cart.' . $productId)) {
    // Xử lý logic
}
```

### 2.3 Cập nhật Session

```php
// Cập nhật số lượng sản phẩm
public function updateCart(Request $request)
{
    if($request->id && $request->quantity){
        $cart = session()->get('cart');
        $cart[$request->id]["quantity"] = $request->quantity;
        session()->put('cart', $cart);
    }
}
```

### 2.4 Xóa dữ liệu khỏi Session

```php
// Xóa một sản phẩm khỏi giỏ hàng
public function removeFromCart($productId)
{
    $cart = session()->get('cart');
    if(isset($cart[$productId])) {
        unset($cart[$productId]);
        session()->put('cart', $cart);
    }
}

// Xóa toàn bộ giỏ hàng
session()->forget('cart');

// Xóa tất cả session
session()->flush();
```

## 3. Flash Session

Flash session chỉ tồn tại trong một request tiếp theo:

```php
// Lưu thông báo flash
return redirect()->route('products.index')->with('success', 'Sản phẩm đã được tạo thành công!');

// Trong view, hiển thị thông báo
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
```

## 4. Session trong Middleware

```php
// Kiểm tra giỏ hàng trong middleware
public function handle($request, Closure $next)
{
    if(!session()->has('cart')) {
        return redirect()->route('products.index')->with('error', 'Giỏ hàng trống!');
    }
    return $next($request);
}
```

## 5. Lưu ý quan trọng

- Session mặc định được lưu trong file, có thể cấu hình trong `config/session.php`
- Đảm bảo đã chạy `php artisan session:table` nếu sử dụng database driver
- Không lưu quá nhiều dữ liệu vào session
- Xóa session khi không cần thiết để tránh tràn bộ nhớ
- Sử dụng `session()->regenerate()` sau khi đăng nhập để tránh session fixation
``` 