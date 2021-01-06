<div class="ibox float-e-margins">

    <div class="ibox-title">
        <h5><?php echo $panel_title; ?></h5>

        <div class="ibox-tools">
            <span class="badge label-warning-light">
            	Total : <?php echo $total_count; ?>
           	</span>

        </div>
    </div>
			    
    <div class="ibox-content">
        
        <div>

			<?php if ( ! empty( $data )): ?>

				<?php 
					
					foreach($data as $d){

					$cat_images = $this->Image->get_all_by( array( 'img_type' => 'category', 'img_parent_id' => $d->cat_id ))->result();
					
					
					if(count($cat_images)<1){
						$cat_image = "feedDefault.png";
					} else {
						$cat_image = $cat_images[0]->img_path; 
					}
					
					
					echo "<div class='feed-element'>".
						 	"<img class='pull-left' style='border-radius: 10%; width:50; height:40px;' src='".base_url('uploads/thumbnail/'.$cat_image)."'>".
					    	"<div class='media-body '>".
					    		 "<strong>".$d->cat_name."</strong><br>".
					     		 
					     	"</div>".
					     "</div>";

					    
					  
				}  
				
			?>

			<?php endif; ?>

         </div>
         
    </div>
</div>


