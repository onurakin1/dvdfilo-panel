<style>
    body{
        margin:0px!important;

    }
</style>

<div class="swiper-container">
    <div class="swiper-wrapper">
        @foreach($items as $item)
        <div class="swiper-slide color-1"><img src="{{$item->full_image}}" style="
    width: 100%;
    object-fit: fill;
    height: 100%;
"></div>
        @endforeach
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.css'>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js'></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        loop:true,
        parallax: true,
        loop:true,
  loopedSlides: 50,
         autoplay: {
                delay: 10000, // 4 seconds
            }
    });
</script>
