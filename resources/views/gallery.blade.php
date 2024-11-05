<style>
    body{
        margin:0px!important;

    }
</style>

<div class="swiper-container">
    <div class="swiper-wrapper">
        @foreach($items as $item)
        @if(pathinfo($item['image_url'], PATHINFO_EXTENSION) == 'mp4')
        <video controls style="width: 100%; height: 100%;" autoplay>
            <source src="{{$item['image_url']}}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    @else
        <img src="{{$item['image_url']}}" style="width: 100%; object-fit: fill; height: 100%;">
    @endif
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
