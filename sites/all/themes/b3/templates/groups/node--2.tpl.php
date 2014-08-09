
<div id="carousel" class="carousel slide" data-ride="carousel">
    <!-- Menu -->
    <ol class="carousel-indicators">
        <li data-target="#carousel" data-slide-to="0" class="active"></li>
        <li data-target="#carousel" data-slide-to="1"></li>
        <li data-target="#carousel" data-slide-to="2"></li>
    </ol>

    <!-- Items -->
    <div class="carousel-inner">
        
        <div class="item active first">
            <img src="<?php echo base_path().drupal_get_path('theme', 'b3');?>/images/family_2.png">
		      	<div class="carousel-caption">
					    <h3>因此，人要离开父母与妻子联合，二人成为一体。『<b>圣经</b>』</h3>
					  </div>	
        </div>
        <div class="item">
            <img src="<?php echo base_path().drupal_get_path('theme', 'b3');?>/images/family_3.png">
		      	<div class="carousel-caption">
					    <h3>耶和华神说，那人独居不好，<br/>我要为他造一个配偶帮助他。『<b>圣经</b>』</h3>
					    
					  </div>	
        </div>
		    <div class="item">
		      	<img src="<?php echo base_path().drupal_get_path('theme', 'b3');?>/images/family_1.png">
		      	<div class="carousel-caption">
					    <h3>然而你们各人都当爱妻子，如同爱自己一样。<br/>妻子也当敬重她的丈夫。『<b>圣经</b>』</h3>
					  </div>		    	
		    </div>
    </div> 
    <a href="javascript:void(0);" class="left carousel-control" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a href="javascript:void(0);" class="right carousel-control" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
<script type="text/javascript">
			  jQuery(function(){
			  	jQuery('.carousel-control').click(function(){
			  		jQuery('#carousel').carousel(jQuery(this).attr("data-slide"));
			  	});
					    
					});
</script>