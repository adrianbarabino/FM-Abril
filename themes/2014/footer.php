		<footer>
			<span>FM Abril &copy; <?php echo date("Y"); ?></span>
		</footer>
	</section>
  <!-- Now we load all JS files ! -->
  <script type="text/javascript" src="<?php printf("/themes/%s", $config['theme']); ?>/js/vendors/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="<?php printf("/themes/%s", $config['theme']); ?>/js/vendors/jquery.jplayer.min.js"> </script>
  <script type="text/javascript" src="<?php printf("/themes/%s", $config['theme']); ?>/js/vendors/pgwslider.min.js"> </script>
  <script type="text/javascript" src="<?php printf("/themes/%s", $config['theme']); ?>/js/vendors/underscore.min.js"></script>
  <script type="text/javascript" src="<?php printf("/themes/%s", $config['theme']); ?>/js/vendors/backbone.min.js"></script>
    <script src="<?php printf("/themes/%s", $config['theme']); ?>/js/init.js"></script>    
   <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36574161-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
    <script src="<?php printf("/themes/%s", $config['theme']); ?>/js/backbone/models/article.js"></script>    
    <script src="<?php printf("/themes/%s", $config['theme']); ?>/js/backbone/collections/articles.js"></script>    
    <script src="<?php printf("/themes/%s", $config['theme']); ?>/js/backbone/views/article.js"></script>    
    <script src="<?php printf("/themes/%s", $config['theme']); ?>/js/backbone/routers/base.js"></script> 
  <script type="text/javascript" src="<?php printf("/themes/%s", $config['theme']); ?>/js/main.js"></script>
</body>
</html>