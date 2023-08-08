  
<?php /* plantilla utilizada para mostrar fecha y categoria de las noticias */ ?>
<style> 
.info1 { 
	
    font-size: 15px;
    /* margin-bottom: 20px; */
    /* margin-top: 57px; */
    float: right;
   
}
</style>
<div class="info1">
<span class="glyphicon glyphicon-time"></span>
    <span class="fecha"><?php the_time('j/ m/ Y H:m:s'); ?></span>
    </div>