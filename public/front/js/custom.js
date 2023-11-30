
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

    $(".userLoginForm").submit(function(){

        var userEmail = $("#useremail").val();
        var userPassword = $(".userPassword").val();

        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            type : 'POST',
            url : 'http://127.0.0.1:8000/user/login',
            data: {
                email :userEmail,
                password :userPassword,
            },
            success: function(data){
                if(data.status == true) {
                    let timerInterval;
                    Swal.fire({
                    title: data.message,
                    html: "I will close in <b></b> seconds.",
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                    }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location = data.url;
                    }
                    });

                }else if(data.status == false){
                    $("#error_message").html(data.message);
                }else if(data.type == 'incorrect'){
                    $("#error_message").html(data.message);
                }else{
                    $.each(data.errors, function(prefix, val){
                        $("#"+'log_'+prefix+'_error').text(val[0]);
                    });
                }

            },error: function(error){
                console.log(error);
            }
        });
    })


    $("#userRegisterForm").submit(function(){
        if ($('#accept').is(":checked"))
        {
            var userAccept = "on"
        }else{

        }
        $('.fa').addClass('fa-refresh fa-spin');

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
                if(data.status == true) {
                    $('.fa').removeClass('fa-refresh fa-spin');
                    $("#success_message").html(data.message);

                }else{
                    $('.fa').removeClass('fa-refresh fa-spin');
                    $.each(data.errors, function(prefix, val){
                        $("#"+prefix+'_error').text(val[0]);
                    });
                }

            },error: function(error){
                console.log(error);
            }
        });
    })

    //forgot password
    $("#forgotForm").submit(function(){
        $('.fa').addClass('fa-refresh fa-spin');


        var userEmail = $("#forgot_email").val();

        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            type : 'POST',
            url : '/user/forgot-password',
            data: {
                email :userEmail,
            },
            success: function(data){
                if(data.status == true) {
                    $('.fa').removeClass('fa-refresh fa-spin');

                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.onmouseenter = Swal.stopTimer;
                          toast.onmouseleave = Swal.resumeTimer;
                        }
                      });
                      Toast.fire({
                        icon: "success",
                        title: data.message
                      });
                      $("#forgot_email").val("");

                }else if(data.status == false){
                    $("#error_message").html(data.message);
                }else{
                    $('.fa').removeClass('fa-refresh fa-spin');
                    $.each(data.errors, function(prefix, val){
                        $("#"+prefix+'_error').text(val[0]);
                    });
                }

            },error: function(error){
                console.log(error);
            }
        });
    })

    //user account details update
    $(".userAccountDetails").submit(function(){

        $('.fa').addClass('fa-refresh fa-spin');

        var userName = $("#user-name").val();
        var userAddress = $("#user-address").val();
        var userCity = $("#user-city").val();
        var userState = $("#user-state").val();
        var userCountry = $("#user-country").val();
        var userPincode = $("#user-pincode").val();
        var userMobile = $("#user-mobile").val();

        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            type : 'POST',
            url : '/user/account',
            data: {
               name : userName,
               address : userAddress,
               city : userCity,
               state : userState,
               country : userCountry,
               pincode : userPincode,
               mobile : userMobile
            },
            success: function(data){
                if(data.status == true) {
                    $('.fa').removeClass('fa-refresh fa-spin');

                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.onmouseenter = Swal.stopTimer;
                          toast.onmouseleave = Swal.resumeTimer;
                        }
                      });
                      Toast.fire({
                        icon: "success",
                        title: data.message
                      });

                }else{
                    $('.fa').removeClass('fa-refresh fa-spin');
                    $.each(data.errors, function(prefix, val){
                        $("#"+prefix+'_error').text(val[0]);
                    });
                }

            },error: function(error){
                console.log(error);
            }
        });
    })

    //user password change
     $("#passwordForm").keyup(function(){
        var current_password = $("#user-current-password").val();

        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            type : 'POST',
            url : '/user/check-current-password',
            data: {current_password: current_password},
            success: function(resp){
                if(resp.status == false){

                    $("#check_password").html("<font color='red'>Current Password is Incorrect ! Make correct Current Password first ! </font>");
                }else if(resp.status == true){

                    $("#check_password").html("<font color='green'>Current Password is Correct !</font>");
                }
            },error: function(){
                console.log('error');
            }
        });

    })

    $("#passwordForm").submit(function(){
            var current_password = $("#user-current-password").val();
            var new_password = $("#user-new-password").val();
            var confirm_password = $("#user-confirm-password").val();

            $('.fa').addClass('fa-refresh fa-spin');


            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                type : 'POST',
                url : '/user/update/password',
                data: { current_password , new_password , confirm_password},
                success: function(resp){
                    if(resp.status == false){
                        $('.fa').removeClass('fa-refresh fa-spin');

                        $.each(resp.errors,function(prefix,val){
                            $("#"+prefix+"_error").text(val[0]);
                        })
                    }else if(resp.status == true){
                        $('.fa').removeClass('fa-refresh fa-spin');
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                              toast.onmouseenter = Swal.stopTimer;
                              toast.onmouseleave = Swal.resumeTimer;
                            }
                          });
                          Toast.fire({
                            icon: "success",
                            title: resp.message
                          });

                        $("#user-current-password").val("");
                        $("#user-new-password").val("");
                        $("#user-confirm-password").val("");

                    }
                },error: function(){
                    console.log('error');
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



// $(document).ready(function () {

//     $('.register-form').show();
//     $('#login-form').hide();

//     $('.register').click(function () {
//         $('.register-form').show();
//         $('#login-form').hide();
//     });
//     $('.login').click(function () {
//         $('.register-form').hide();
//         $('#login-form').show();
//     });
// });





