<?php
    use App\Models\ProductsFilter;
    $productFilters = ProductsFilter::productFilters();
?>

<script>
    $(document).ready(function(){
        // Sort By Filter
        $('#sort').on("change",function(){

            var sort = $("#sort").val();
            var url = $("#url").val();
            var color = get_filter('color');
            var size = get_filter('size');
            var price = get_filter('price');
            var brand = get_filter('brand');
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url : url,
                method : 'POST',
                data: {
                    sort ,
                    @foreach ($productFilters as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach

                    url,
                    price,
                    color,
                    size,
                    brand
                },
                success:function(data){
                    $('.filter_products').html(data);
                    console.log(data);
                },error:function(error){
                    console.log(error)
                }
            });
        });

        // Size Filter
        $('.size').on("change",function(){
            var sort = $("#sort").val();
            var url = $("#url").val();
            var size = get_filter('size');
            var price = get_filter('price');
            var brand = get_filter('brand');
            var color = get_filter('color');
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url : url,
                method : 'POST',
                data: {
                    sort : sort ,
                    @foreach ($productFilters as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach

                    url : url,
                    size : size,
                    color : color,
                    price : price,
                    brand : brand
                },
                success:function(data){
                    $('.filter_products').html(data);
                    console.log(data);
                },error:function(error){
                    console.log(error)
                }
            });
        });

        // color filter
        $('.color').on("change",function(){
            var sort = $("#sort").val();
            var url = $("#url").val();
            var color = get_filter('color');
            var price = get_filter('price');
            var brand = get_filter('brand');
            var size = get_filter('size');
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url : url,
                method : 'POST',
                data: {
                    sort : sort ,
                    @foreach ($productFilters as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach

                    url : url,
                    color : color,
                    size : size,
                    price : price,
                    brand : brand
                },
                success:function(data){
                    $('.filter_products').html(data);
                    console.log(data);
                },error:function(error){
                    console.log(error)
                }
            });
        });

         // price filter
         $('.price').on("change",function(){
            var sort = $("#sort").val();
            var url = $("#url").val();
            var price = get_filter('price');
            var color = get_filter('color');
            var size = get_filter('size');
            var brand = get_filter('brand');
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url : url,
                method : 'POST',
                data: {
                    sort : sort ,
                    @foreach ($productFilters as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach

                    url : url,
                    price : price,
                    size : size,
                    color : color,
                    brand : brand
                },
                success:function(data){
                    $('.filter_products').html(data);
                    console.log(data);
                },error:function(error){
                    console.log(error)
                }
            });
        });

          // brand filter
          $('.brand').on("change",function(){
            var sort = $("#sort").val();
            var url = $("#url").val();
            var price = get_filter('price');
            var brand = get_filter('brand');
            var color = get_filter('color');
            var size = get_filter('size');
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url : url,
                method : 'POST',
                data: {
                    sort : sort ,
                    @foreach ($productFilters as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach

                    url : url,
                    price : price,
                    size : size,
                    color : color,
                    brand : brand
                },
                success:function(data){
                    $('.filter_products').html(data);
                    console.log(data);
                },error:function(error){
                    console.log(error)
                }
            });
        });

        // Dynamic Filter
        @foreach ($productFilters as $filter)
            $('.{{ $filter['filter_column'] }}').on('click',function(){
                var url = $('#url').val();
                var sort = $("#sort option:selected").val();
                @foreach ($productFilters as $filters)
                    var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
                @endforeach
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    url : url,
                    method: "Post",
                    data: {
                        sort ,
                            @foreach ($productFilters as $filters)
                            {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                            @endforeach

                        url
                    },
                    success:function(data){
                        $('.filter_products').html(data);
                    },error:function(error){
                        console.log(error);
                    }
                });
            });
        @endforeach
    });


</script>
