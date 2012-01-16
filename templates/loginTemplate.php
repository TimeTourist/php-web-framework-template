    
    <h2>Logga in</h2>
      
    <p>
      <div class="alert">
        <?php 
        foreach ($messages as $message) { 
          echo ($message.' <br/>'); 
        } 
        ?>
      </div>

    </p>
    <form action="?c=index&a=login" method="POST">
    <input type="text" name="username" id="username">
    <input type="password" name="password" id="password">
    <input type="submit" name="login" value="Logga in!">
    </form>