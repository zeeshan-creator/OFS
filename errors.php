<?php if (count($errors) > 0) : ?>
   <div class="error col-lg-12 mt-2 p-0">
      <?php foreach ($errors as $error) : ?>
         <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong><?php echo $error ?></strong>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span>
            </button>
         </div>
      <?php endforeach ?>
   </div>
<?php endif ?>