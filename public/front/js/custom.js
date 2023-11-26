
$(document).ready(function () {
    $("#getPrice").change(function () {
        var size = $(this).val();
        var product_id = $(this).attr("product-id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/get-product-price',
            data: {
                size,
                product_id
            },
            type: 'POST',
            success: function (resp) {
                if (resp['discount'] > 0) {
                    $(".getAttributePrice").html("");
                } else {

                    $(".getAttributePrice").html("<div class='price'><h4> " + resp['final_price'] + " MMK</h4></div><div class='original-price'><span>Original Price:</span><span> " + resp['product_price'] + " MMK</span></div>");
                }

            }, error: function (error) {
                console.log(error);
            }
        });
    });

    //dynamic quantity x per product price
    $(document).on('click', '.updateCartItem', function () {

        if ($(this).hasClass('plus-a')) {
            //get quantity
            var quantity = $(this).data('quantity');
            // increase the quantity by 1
            new_quantity = quantity + 1;

        }
        if ($(this).hasClass('minus-a')) {
            //get quantity
            var quantity = $(this).data('quantity');
            //check qty is at least 1
            if (quantity <= 1) {
                $("#error").html("<font color='red'>Quantity must be 1 or greater !</font>");
                return false;
            }
            // increase the quantity by 1
            new_quantity = parseInt(quantity) - 1;

        }

        var cartid = $(this).data('cartid');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            data: {
                cartid: cartid,
                quantity: new_quantity
            },
            url: 'cart/update',
            success: function (resp) {
                if (resp.status == false) {
                    var message = resp.message;

                }
                $("#appendCartItems").html(resp.view);
            }, error: function (error) {
                alert(error)
            }
        })
    })

    $(document).on('click', '.deleteCartItem', function () {
        var cart_id = $(this).data('cartid');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )

            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                data: {
                    cartid: cart_id,
                },
                url: 'cart/delete',
                success: function (resp) {
                    if (resp.status == false) {
                        var message = resp.message;
                    }
                    $("#appendCartItems").html(resp.view);
                }, error: function (error) {
                    alert(error)
                }
            })
          })


    });

    $("#userRegisterForm").submit(function(){

        if ($('#accept').is(":checked"))
        {
            var userAccept = "on"
        }else{

        }

        var userName = $("#userName").val();
        var userMobile = $("#userMobile").val();
        var userEmail = $("#userEmail").val();
        var userPassword = $(".userpassword").val();
        var userPasswordConfirmation = $(".user_password_confirmation").val();
        var userAccept = userAccept;
        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            type : 'POST',
            url : 'http://127.0.0.1:8000/user/register',
            data: {
                name :userName,
                mobile :userMobile,
                email :userEmail,
                password :userPassword,

                password_confirmation :userPasswordConfirmation,
                accept :userAccept
            },
            success: function(data){

                if(data.url) {
                    window.location.herf = data.url;
                }else{
                    $.each(data.errors, function(prefix, val){
                        $("#"+prefix+'_error').text(val[0]);
                    });
                }

            },error: function(error){
                console.log(error);
            }
        });
    })

});


function get_filter(class_name) {
    var filter = [];
    $('.' + class_name + ':checked').each(function () {
        filter.push($(this).val());
    });

    return filter;
}

// $("#vendorRegisterForm").submit(function(e){
//     e.preventDefault();

//     var vendorName = $("#vendorName").val();
//     var vendorMobile = $("#vendorMobile").val();
//     var vendorEmail = $("#vendorEmail").val();
//     var vendorPassword = $("#vendorPassword").val();
//     var vendorPasswordConfirmation = $("#vendorPasswordConfirmation").val();
//     var vendorAccept = $("#accept").val();

//     $.ajax({
//         headers : {
//             'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
//         },
//         type : 'POST',
//         url : 'http://127.0.0.1:8000/vendor/register',
//         data: {
//             name : vendorName,
//             mobile : vendorMobile,
//             email : vendorEmail,
//             password : vendorPassword,
//             accept : vendorAccept,
//             password_confirmation : vendorPasswordConfirmation
//         },
//         success: function(data){
//             if(data.error) {
//                 $.each(data.error, function(prefix, val){
//                     $('span.'+prefix+'_error').text(val[0]);
//                 });
//             }else{
//                location.reload();
//             }

//         },error: function(){
//             console.log('error');
//         }
//     });
// })

function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function myFunction_log_password() {
    var x = document.getElementById("myInput_log_password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function myFunction_log_password_con() {
    var x = document.getElementById("myInput_log_password_con");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}


$(document).ready(function () {

    $('.register-form').show();
    $('#login-form').hide();

    $('.register').click(function () {
        $('.register-form').show();
        $('#login-form').hide();
    });
    $('.login').click(function () {
        $('.register-form').hide();
        $('#login-form').show();
    });
});





