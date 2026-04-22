@extends('layouts.client')

@section('content')
<div class="container">
    <form action="{{ route('home') }}" method="GET" id="masterFilterForm">
        @if(request('keyword')) 
            <input type="hidden" name="keyword" value="{{ request('keyword') }}"> 
        @endif

        <div class="row">
            <div class="col-md-3">
                <div class="sidebar-filter">
                    
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 border-bottom px-4 rounded-top-4">
                            <h6 class="fw-bold m-0 text-primary d-flex align-items-center">
                                <i class="bi bi-grid-fill me-2 fs-5"></i> DANH MỤC
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush rounded-bottom-4">
                                <a href="{{ route('home', request()->only(['keyword', 'sort', 'min_price', 'max_price'])) }}" class="list-group-item list-group-item-action py-3 px-4 d-flex justify-content-between align-items-center border-0 {{ !isset($current_category) && !request('keyword') ? 'active' : '' }}">
                                    <span class="fw-medium">Tất cả sản phẩm</span>
                                    <i class="bi bi-chevron-right small"></i>
                                </a>
                                
                                @foreach($categories as $cat)
                                    @php $isActive = isset($current_category) && $current_category->id == $cat->id; @endphp
                                    <a href="{{ route('category.show', $cat->id) . (request()->query() ? '?' . http_build_query(request()->query()) : '') }}" class="list-group-item list-group-item-action py-3 px-4 d-flex justify-content-between align-items-center border-0 {{ $isActive ? 'active' : '' }}">
                                        <span class="fw-medium {{ $isActive ? '' : 'text-secondary' }}">{{ $cat->name }}</span>
                                        <i class="bi bi-chevron-right small {{ $isActive ? '' : 'text-muted' }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 border-bottom px-4 rounded-top-4">
                            <h6 class="fw-bold m-0 text-primary d-flex align-items-center">
                                <i class="bi bi-filter-square-fill me-2 fs-5"></i> LỌC THEO GIÁ
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="form-check mb-3 custom-radio">
                                <input class="form-check-input shadow-none" type="radio" name="price_suggest" id="price1" onchange="setPrice(0, 500000)">
                                <label class="form-check-label text-dark fw-medium ms-1" style="cursor: pointer;" for="price1">Dưới 500.000đ</label>
                            </div>
                            <div class="form-check mb-3 custom-radio">
                                <input class="form-check-input shadow-none" type="radio" name="price_suggest" id="price2" onchange="setPrice(500000, 2000000)">
                                <label class="form-check-label text-dark fw-medium ms-1" style="cursor: pointer;" for="price2">500.000đ - 2 Triệu</label>
                            </div>
                            <div class="form-check mb-4 custom-radio">
                                <input class="form-check-input shadow-none" type="radio" name="price_suggest" id="price3" onchange="setPrice(2000000, '')">
                                <label class="form-check-label text-dark fw-medium ms-1" style="cursor: pointer;" for="price3">Trên 2 Triệu</label>
                            </div>

                            <div class="row g-2 mb-4 align-items-center">
                                <div class="col">
                                    <input type="number" class="form-control text-center shadow-none border-secondary-subtle" id="min_price" name="min_price" placeholder="TỪ (đ)" value="{{ request('min_price') }}" min="0">
                                </div>
                                <div class="col-auto text-muted fw-bold">-</div>
                                <div class="col">
                                    <input type="number" class="form-control text-center shadow-none border-secondary-subtle" id="max_price" name="max_price" placeholder="ĐẾN (đ)" value="{{ request('max_price') }}" min="0">
                                </div>
                            </div>

                            <button type="button" onclick="document.getElementById('masterFilterForm').submit()" class="btn btn-primary w-100 fw-bold rounded-3 py-2 shadow-sm d-flex justify-content-center align-items-center">
                                ÁP DỤNG MỨC GIÁ
                            </button>
                            
                            @if(request('min_price') || request('max_price'))
                                <a href="{{ route('home', ['keyword' => request('keyword'), 'sort' => request('sort')]) }}" class="btn btn-light border text-secondary w-100 fw-bold rounded-3 py-2 mt-2 shadow-sm">
                                    Xóa bộ lọc
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-9">
                <div class="rounded-3 overflow-hidden mb-4 shadow-sm position-relative">
                    <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=80" 
     class="w-100" style="height: 250px; object-fit: cover;" alt="Màn hình điện thoại EAUT">
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    @if(request('keyword'))
                        <h4 class="fw-bold text-uppercase mb-0 text-primary">
                            <i class="bi bi-search"></i> Kết quả cho: "{{ request('keyword') }}"
                        </h4>
                    @elseif(isset($current_category))
                        <h4 class="fw-bold text-uppercase mb-0 text-primary">
                            {{ $current_category->name }}
                        </h4>
                    @else
                        <h4 class="fw-bold text-uppercase mb-0">Sản phẩm nổi bật</h4>
                    @endif
                    
                    <div class="w-25">
                        <select name="sort" class="form-select shadow-sm border-0 border-primary border-start border-4" onchange="document.getElementById('masterFilterForm').submit()">
                            <option value="new" {{ request('sort') == 'new' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                        </select>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse($products as $product)
                    <div class="col-md-4 col-sm-6">
                        <div class="card h-100 product-card border-0 shadow-sm p-2">
                            <div class="position-relative text-center">
                                <img src="{{ asset('storage/' . ($product->image ?? 'default.jpg')) }}" 
                                     class="card-img-top mt-2" 
                                     style="width: 100%; height: 180px; object-fit: contain;" 
                                     alt="{{ $product->name }}">
                            </div>
                            
                            <div class="card-body px-2 pb-2 text-center d-flex flex-column">
                                <p class="text-primary small fw-semibold mb-1">{{ $product->category->name ?? 'Chưa phân loại' }}</p>
                                <h6 class="card-title fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h6>
                                <p class="price mb-3 text-danger fw-bold fs-5">{{ number_format($product->price) }}đ</p>
                                
                                <div class="mt-auto d-grid gap-2">
                                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Chi tiết
                                    </a>
                                    <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="alert alert-warning border-0 shadow-sm text-dark">
                                Không tìm thấy sản phẩm nào phù hợp với bộ lọc.
                            </div>
                        </div>
                    @endforelse
                </div>

                @if(isset($products) && method_exists($products, 'links'))
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
                @endif

            </div>
        </div>
    </form>
</div>

<script>
    function setPrice(min, max) {
        document.getElementById('min_price').value = min;
        document.getElementById('max_price').value = max;
    }
</script>

<style>
    .product-card { transition: all 0.3s ease; border: none; border-radius: 10px; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important; }
</style>
@endsection