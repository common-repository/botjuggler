<div class="wrap">
  <h2><?php _e( 'Botjuggler - Settings', 'botjuggler'); ?> <a class="add-new-h2" target="_blank" href="<?php echo esc_url( "https://player.vimeo.com/video/384975216" ); ?>"><?php _e( 'Watch Tutorial', 'botjuggler'); ?></a></h2>

  <hr />
  <div id="poststuff">
  <div id="post-body" class="metabox-holder columns-2" style="width:100%">
    <div id="post-body-content">
      <div class="postbox" >
        <div class="inside">

          <form name="dofollow" action="options.php" method="post">

           
           <?php 
            settings_fields( 'botjuggler-settings-group' ); 
            $settings = get_option( 'botjuggler-plugin-settings' );          
            $script = (array_key_exists('script', $settings) ? $settings['script'] : '');
            $showOn = (array_key_exists('showOn', $settings) ? $settings['showOn'] : 'all');

            ?>

            <h3 class="botjuggler-labels"><?php _e( 'Instructions: ', 'botjuggler'); ?></h3>

            <p>1. <?php _e( 'If you are not an existing botjuggler user, <a href="https://dashboard.botjuggler.com/signup" target="_blank">Click here to register</a>', 'botjuggler'); ?></p>

            <p>2. <?php _e( 'Design your Chatbot using <a href="https://dashboard.botjuggler.com/home" target="_blank">Drag & Drop Dashboard</a>', 'botjuggler'); ?></p>

            <p>3. <?php _e( 'Copy the code snippet from Dashboard > Publish and paste it here', 'botjuggler'); ?></p>
            <h3 class="botjuggler-labels" for="script"><?php _e( 'Chatbot Snippet:', 'botjuggler'); ?></h3>

            <textarea style="width:98%;" rows="10" cols="57" id="script" name="botjuggler-plugin-settings[script]"><?php echo esc_html( $script ); ?></textarea>

            <p>
              <h3>Show Above Chatbot On: </h3>
              <input type="radio" name="botjuggler-plugin-settings[showOn]" value="all" id="all" <?php checked('all', $showOn); ?>> <label for="all"><?php _e( 'All Pages', 'botjuggler'); ?> </label> 
              <input type="radio" name="botjuggler-plugin-settings[showOn]" value="home" id="home" <?php checked('home', $showOn); ?>> <label for="home"><?php _e( 'Homepage Only', 'botjuggler'); ?> </label> 
              <input type="radio" name="botjuggler-plugin-settings[showOn]" value="nothome" id="nothome" <?php checked('nothome', $showOn); ?>> <label for="nothome"><?php _e( 'All Pages except Homepage', 'botjuggler'); ?> </label>
              <input type="radio" name="botjuggler-plugin-settings[showOn]" value="none" id="none" <?php checked('none', $showOn); ?>> <label for="none"><?php _e( 'No Pages', 'botjuggler'); ?> </label>
            </p>

            <p class="submit">
              <input class="button button-primary" type="submit" name="Submit" value="<?php _e( 'Save settings', 'botjuggler'); ?>" />
            </p>
          

          </form>
        </div>
    </div>
    </div>

   
    </div>
  </div>
</div>
