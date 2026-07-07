<?php 

$border_radius = get_sub_field('border_radius');
$media_type = get_sub_field('media_type');
$image = get_sub_field('image');
$inline_video_placeholder = get_sub_field('inline_video_placeholder');
$inline_video = get_sub_field('inline_video');
$embed_video = get_sub_field('embed_video');
$lottie_json = get_sub_field('lottie_json');

?>

<?php if($media_type == 'image'):?>

<div class="media-block media-block__image relative" <?php if($border_radius):?> style="border-radius: <?= $border_radius;?>px;" <?php endif;?>>
	<?php echo wp_get_attachment_image( $image['id'] , 'full', '', array('loading' => 'lazy'));?>
</div>

<?php elseif($media_type == 'inline-video'):?>

<div class="media-block" <?php if($border_radius):?> style="border-radius: <?= $border_radius;?>px;" <?php endif;?>>
	<video playsinline autoplay loop muted <?php if($inline_video_placeholder):?> poster="<?php echo $inline_video_placeholder['url'];?>" <?php endif;?>>
		<source src="<?php echo $inline_video;?>" format="video/mp4" />
	</video>
</div>

<?php elseif($media_type == 'embed-video'):?>

<div class="media-block " <?php if($border_radius):?> style="border-radius: <?= $border_radius;?>px;" <?php endif;?>>
	<div class="video-container">
		<?php echo $embed_video;?>
	</div>
</div>

<?php elseif($media_type == 'lottie-animation'):?>

<?php $videoid = uniqid();?>
<div class="lottie-animation" id="<?php echo $lottie_json['title'];?>"></div>
<script>
	document.addEventListener('DOMContentLoaded', function () {
    const lottieElement = document.getElementById('<?php echo $lottie_json['title']; ?>');
    const lottieInstance = bodymovin.loadAnimation({
        container: lottieElement,
        renderer: 'svg',
        name: '<?php echo $lottie_json['title']; ?>',
        autoplay: false,
        loop: true,
        path: '<?php echo $lottie_json['url']; ?>',
        rendererSettings: {
            preserveAspectRatio: 'xMinYMin slice',
            progressiveLoad: true,
        },
    });

    function lottieAnimation() {
        const rect = lottieElement.getBoundingClientRect();
        const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

        if (isVisible) {
            lottieInstance.play();
        } else {
            lottieInstance.pause();
        }
    }

    // Debounce function to limit function execution rate
    function debounce(func, delay) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    // Initial check
    lottieAnimation();

    // Attach optimized event listeners
    const debouncedLottieAnimation = debounce(lottieAnimation, 100);
    document.addEventListener('scroll', debouncedLottieAnimation);
    window.addEventListener('resize', debouncedLottieAnimation);
});


	
</script>


<?php endif;?>


