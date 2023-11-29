<!-- Add loader css -->

<style>
    .loader
    {
        background: rgba(255, 255, 255, 0.8);
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    .loader img{
        left: 50%;
        margin-left: -32px;
        margin-top: -32px;
        position: absolute;
        top: 50%;
    }
</style>

<div class="loader">
    <img src="loader.gif" alt="loading...">
</div>

<!-- Call loader class in query like below -->
<script>

$(document).ready(function(){
    $("#formid").on("submit",function(){
        $(".loader").show();
    })
})

</script>
