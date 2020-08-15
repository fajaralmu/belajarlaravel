 
<div class="footer">
	
	<p align="center" id="footer-p"  >{{$profile->name}} {{$year}}</p>

	<script type="text/javascript">
		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})

		_byId('footer-p').style.color = '{{$profile->font_color}}';
	</script>
</div>
 