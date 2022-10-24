  
  <!DOCTYPE html>
  <html>
  <!-- to get styles form extenal css -->
  <?php include("..\advertQueries.php") ?>
  <?php include("header.php")?>

  <body>

      <div class="slideshow-container">

      <?php
     $result = ViewAdverts();
     $i = 0;  
     if (mysqli_num_rows($result) > 0) {  
     while($row = $result->fetch_assoc()){    
     $i++;
?>
        <div class="mySlides fade">
          <div class="numbertext"><?php echo $i; ?> / 3</div>
          <img src="..\images\<?php echo $row["imgName"]; ?>" style="width: 100%" />
          <h2 class="text"><?php echo $row["title"]; ?></h2>
          <!-- <h2 class="text">KEEP GOING.</h2> -->

          <h2 class="text2"> <?php echo $row["advertDesc"]; ?></h2>
          <!-- <h2 class="text2">KEEP GROWING.</h2> -->
        </div>
<?php }
}
 ?>
 <!-- slider-01-final,jpg -->
 <!-- slider-final-ffffff.jpg -->
        <!-- <div class="mySlides fade">
          <div class="numbertext">2 / 3</div>
          <img src="..\images\slider-trial.jpg" style="width: 100%" />
          <h2 class="text" style="font-size: 50px">Sorry,</h2>
          <h2 class="text2" style="font-size: 50px">
            I have plants this weekend
          </h2>
        </div>

        <div class="mySlides fade">
          <div class="numbertext">3 / 3</div>
          <img src="..\images\slider-03-FINAL.jpg" style="width: 100%" />
          <h2 class="text" style="font-size: 60px">
            FLOWERS are for TINDER DATES.
          </h2>
          <h2 class="text2" style="font-size: 50px">
            PLANTS are for SOUL MATES.
          </h2>
        </div>
      </div> -->
      <br />

      <div style="text-align: center">
        <?php
        for($j=0;$j<$i;$j++){
         ?>
           <span class="dot"></span>
        <?php   
        }
        ?>
      </div>
  <div id="main">
      <div id="welcome">
        <h2>Welcome</h2>
        <p>
          Cacti Cacti-Succulent Kuching is a local homegrown business specialized
          in selling various type and size of succulent plants. Apart from selling
          succulents plants, they also sell different types of gardening tools,
          soils and fertilizers at an affordable cost.
        </p>
      </div>

      <div id="advantages">
          <h2>Advantages of Online Plant shopping: </h2>
        <h3>It offers convenience: </h3>
        <p>
          Thanks to online plant shopping, now you can embrace the whole urban
          jungle appeal and shop on your laptop or smartphone for gorgeous species
          of houseplants with fantastic foliage and/or fragrant flowers. If you
          got massive plant envy from browsing too many drool-worthy photos of
          living spaces spruced up with frondy and ferny plants on Instagram, you
          can order online in the early morning and have them delivered to your
          doorstep the same day or the next day.
        </p>
        <h3>It brings you closer to nature </h3>
        <p>
          Shopping for plants online empowers you to immediately act upon your
          yearning for a pocket paradise by creating one within the corners of
          your own home. These days, it does not matter if you have a garden or
          backyard, as long as you have a balcony or even large north-facing
          windows to shower your flowering plants with bright light in the
          morning.
        </p>
      </div>
      <!-- <div class="card" style="width: 20rem;">
          <img src="./images/bookAppointment.png" alt="Avatar" >
          <div class="container">
            <h4><b>Book an appointment now</b></h4> 
            <a href="#Booking">Click here for booking!</a>
          </div>
        </div> -->
      <div class="card" style="width: 20rem">
        <img src="..\images\services-img-02.jpg" alt="Avatar" />
        <div class="containerHome">
          <h4 >Catalogue</h4>
          <a href="#Catalogue">Take care of the plants you sow.</a>
        </div>
      </div>
    </div>
      <!-- <h2>MEET OUR TEAM</h2>
      <div class="row">
        <div id="team1">
          <img src="./images/bookAppointment.png" />
          <h4><b>Hamza Ahmed</b></h4>
        </div> -->

        <!-- <div id="team2">
          <img src="./images/bookAppointment.png" alt="Avatar" />

          <h4><b>Murtadha Rashid</b></h4>
        </div>

        <div id="team3">
          <img src="./images/bookAppointment.png" alt="Avatar" />

          <h4><b>Andy Sejati</b></h4>
        </div>
      </div>
      
      <div id="team4" style="width: 20rem">
        <img src="./images/bookAppointment.png" alt="Avatar" />
        <div class="container">
          <h4><b>Munamullah Khan</b></h4>
        </div>
      </div>
      <div id="team5" style="width: 20rem">
        <img src="./images/bookAppointment.png" alt="Avatar" />
        <div class="container">
          <h4><b>Mariny Binti Mohamad</b></h4>
        </div>
      </div>
      <div id="team6" style="width: 20rem">
        <img src="./images/bookAppointment.png" alt="Avatar" />
        <div class="container">
          <h4><b>Sana Tajmahamad</b></h4>
        </div> -->

      <!-- <div class="card" style="width: 20rem;">
          <img src="./images/card-img-plant.jpg" alt="Avatar" >
          <div class="container">
            <h4><b>Catalogue</b></h4> 
            <a href="#Catalogue">Take care of the plants.</a>
          </div>
        </div> -->


      <!-- </div> -->
    </body>
      

    <?php include("footer.php")?>



        
      <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
          let i;
          let slides = document.getElementsByClassName("mySlides");
          let dots = document.getElementsByClassName("dot");
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
          }
          slideIndex++;
          if (slideIndex > slides.length) {
            slideIndex = 1;
          }
          for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex - 1].style.display = "block";
          dots[slideIndex - 1].className += " active";
          setTimeout(showSlides, 5000); // Change image every 2 seconds
        }
      </script>

  </html>
