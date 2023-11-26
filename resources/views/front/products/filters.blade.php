<?php
    use App\Models\ProductsFilter;
    $productFilters = ProductsFilter::productFilters();

?>

<div class="col-lg-3 col-md-3 col-sm-12">

    <!-- Filter-Size -->
    <?php
        $getSizes = ProductsFilter::getSizes($url);

    ?>

    <div class="facet-filter-associates">
        <h3 class="title-name">Size</h3>
        <form class="facet-form" action="#" method="post">
            <div class="associate-wrapper">
                @foreach ($getSizes as $key=>$size)
                    <input type="checkbox" value="{{ $size }}" class="check-box size" name="size[]"  id="size{{ $key }}">
                    <label class="label-text" for="size{{ $key }}">{{ $size }}

                    </label>
                @endforeach
            </div>
        </form>
    </div>
    <!-- Filter-Size -->
    <?php
        $getProductColors = ProductsFilter::getColors($url);
    ?>
    <!-- Filter-Color -->
    <div class="facet-filter-associates">
        <h3 class="title-name">Color</h3>
        <form class="facet-form" action="#" method="post">
            <div class="associate-wrapper">

                @foreach ($getProductColors as $key=>$color)
                <input type="checkbox" value="{{ $color }}" class="check-box color" name="color[]" id="color{{ $key }}">
                <label class="label-text" for="color{{ $key }}">{{ $color }}

                </label>
                @endforeach
            </div>
        </form>
    </div>
    <!-- Filter-Color /- -->

    <!-- Filter-Brand -->
    <?php
        $getProductBrands = ProductsFilter::getBrands($url);

    ?>
    <div class="facet-filter-associates">
        <h3 class="title-name">Brand</h3>
        <form class="facet-form" action="#" method="post">
            <div class="associate-wrapper">
                @foreach ($getProductBrands as $key => $brand)

                <input type="checkbox" value="{{ $brand['id'] }}" class="check-box brand" name="brand[]" id="brand{{ $key }}">
                <label class="label-text" for="brand{{ $key }}">{{ $brand['name'] }}

                </label>
                @endforeach
            </div>
        </form>
    </div>
    <!-- Filter-Brand /- -->

    <!-- Filter -->
    @foreach ($productFilters as $filter)

    <?php
        $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$categoryDetails['categoryDetails']['id']);
    ?>
        @if($filterAvailable == "Yes")
        @if(count($filter['filter_values']) > 0)
        <div class="facet-filter-associates">
            <h3 class="title-name">{{ $filter['filter_name'] }}</h3> Hi
            <form class="facet-form" action="#" method="post">
                <div class="associate-wrapper">
                    @foreach ($filter['filter_values'] as $value)

                        <input type="checkbox" class="check-box {{  $filter['filter_column'] }}" id="{{ $value['filter_value'] }}" name="{{ $filter['filter_column'] }}[]" value="{{ ucwords($value['filter_value']) }}">
                        <label class="label-text" for="{{ $value['filter_value'] }}">{{ ucwords($value['filter_value']) }}
                        </label>
                    @endforeach
                </div>
            </form>
        </div>
        @endif
        @endif
    @endforeach
    <!-- Filter /- -->

    <!-- Filter-Price -->
    <div class="facet-filter-associates">
        <h3 class="title-name">Price</h3>
        <form class="facet-form" action="#" method="post">
            <div class="associate-wrapper">
                <?php
                    $prices = array('0 - 100000','100000 - 300000','300000 - 500000','500000 - 10000000')
                ?>
                @foreach ($prices as $key => $price)
                   <input type="checkbox" value="{{ $price }}" class="check-box price" name="price[]" id="price{{ $key }}">
                    <label class="label-text" for="price{{ $key }}"> {{ $price }} MMK

                    </label>
                @endforeach
            </div>
        </form>
    </div>
    <!-- Filter-Price /- -->

    <?php
    /*
    <!-- Filter-Price -->
    <div class="facet-filter-by-price">
        <h3 class="title-name">Price</h3>
        <form class="facet-form" action="#" method="post">
            <!-- Final-Result -->
            <div class="amount-result clearfix">
                <div class="price-from">$0</div>
                <div class="price-to">$3000</div>
            </div>
            <!-- Final-Result /- -->
            <!-- Range-Slider  -->
            <div class="price-filter"></div>
            <!-- Range-Slider /- -->
            <!-- Range-Manipulator -->
            <div class="price-slider-range" data-min="0" data-max="5000" data-default-low="0" data-default-high="3000" data-currency="$"></div>
            <!-- Range-Manipulator /- -->
            <button type="submit" class="button button-primary">Filter</button>
        </form>
    </div>
    <!-- Filter-Price /- -->

    <!-- Filter-Free-Shipping -->
    <div class="facet-filter-by-shipping">
        <h3 class="title-name">Shipping</h3>
        <form class="facet-form" action="#" method="post">
            <input type="checkbox" class="check-box" id="cb-free-ship">
            <label class="label-text" for="cb-free-ship">Free Shipping</label>
        </form>
    </div>
    <!-- Filter-Free-Shipping /- -->
    <!-- Filter-Rating -->
    <div class="facet-filter-by-rating">
        <h3 class="title-name">Rating</h3>
        <div class="facet-form">
            <!-- 5 Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:76px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">(0)</span>
            </div>
            <!-- 5 Stars /- -->
            <!-- 4 & Up Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:60px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">& Up (5)</span>
            </div>
            <!-- 4 & Up Stars /- -->
            <!-- 3 & Up Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:45px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">& Up (0)</span>
            </div>
            <!-- 3 & Up Stars /- -->
            <!-- 2 & Up Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:30px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">& Up (0)</span>
            </div>
            <!-- 2 & Up Stars /- -->
            <!-- 1 & Up Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:15px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">& Up (0)</span>
            </div>
            <!-- 1 & Up Stars /- -->
        </div>
    </div>
    <!-- Filter-Rating -->
    <!-- Filters /- -->
    */ ?>
</div>
