<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  //get data fron towns table
  $town = $conn->query("SELECT * FROM towns WHERE id='$id'");
  $town->execute();
  $singleTown = $town->fetch(PDO::FETCH_OBJ);

  // images for cities
  $citiesImages = $conn->query("SELECT * FROM cities WHERE town_id='$id'");
  $citiesImages->execute();

  $singleImage = $citiesImages->fetchAll(PDO::FETCH_OBJ);

  // cities with booking numbers

  $cities = $conn->query("SELECT cities.id AS id, 
  cities.name AS name, cities.image AS image,
  cities.trip_days AS trip_days, cities.price AS price, 
  COUNT(bookings.city_id) AS count_bookings FROM cities 
  LEFT JOIN bookings ON cities.id = bookings.city_id 
  WHERE cities.town_id = '$id'
  GROUP BY(bookings.city_id);");

  $cities->execute();
  $allCities = $cities->fetchAll(PDO::FETCH_OBJ);

  // cities of every country
  $cities_town = $conn->query("SELECT COUNT(town_id) AS num_city FROM cities
  WHERE town_id = '$id'");

  $cities_town->execute();
  $num_cities = $cities_town->fetch(PDO::FETCH_OBJ);

  //number of booking for every country
  $num_town = $conn->query("SELECT COUNT(bookings.city_id) 
  AS count_bookings FROM cities JOIN bookings ON cities.id 
  = bookings.city_id WHERE cities.town_id = '$id';");

    $num_town->execute();
    $num_bookings = $num_town->fetch(PDO::FETCH_OBJ);
} else {
  header("location: 404.php");
}
?>
  <!-- ***** Main Banner Area Start ***** -->
  <div class="about-main-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <div class="blur-bg"></div>
            <h4>EXPLORE OUR COUNTRY</h4>
            <div class="line-dec"></div>
            <h2>Welcome To <?php echo $singleTown->name; ?> </h2>
            <p>
            <?php echo $singleTown->description; ?> 
            </p>
            <div class="main-button">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Main Banner Area End ***** -->
  
  <div class="cities-town">
    <div class="container">
      <div class="row">
        <div class="slider-content">
          <div class="row">
            <div class="col-lg-12">
              <h2><?php echo $singleTown->name; ?>’s <em>Cities &amp; Towns</em></h2>
            </div>
            <div class="col-lg-12">
              <div class="owl-cites-town owl-carousel">

              <?php foreach($singleImage as $image) : ?>
                <div class="item">
                  <div class="thumb">
                    <img src="assets/images/<?php echo $image->image; ?>" alt="">
                    <h4><?php echo $image->name; ?></h4>
                  </div>
                </div>
              <?php endforeach; ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="weekly-offers">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h2>Best Weekly Offers In Each City</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-weekly-offers owl-carousel">

          <?php foreach($allCities as $c) : ?>
            <div class="item">
              <div class="thumb">
                <img src="assets/images/<?php echo $c->image; ?>" alt="">
                <div class="text">
                  <h4><?php echo $c->name; ?><br><span><i class="fa fa-users"></i> <?php echo $c->count_bookings; ?> Check Ins</span></h4>
                  <h6>Rs.<?php echo $c->price; ?><br><span>/person</span></h6>
                  <div class="line-dec"></div>
                  <ul>
                    <li>Deal Includes:</li>
                    <li><i class="fa fa-taxi"></i> <?php echo $c->trip_days; ?> Days Trip > Hotel Included</li>
                    <li><i class="fa fa-plane"></i> Airplane Bill Included</li>
                    <li><i class="fa fa-building"></i> Daily Places Visit</li>
                  </ul>
                  <?php if(isset($_SESSION['username'])) :?>
                  <div class="main-button">
                    <a href="reservation.php?id=<?php echo $c->id; ?>">Make a Reservation</a>
                  </div>
                  <?php else : ?>
                    <p>Log in plase for reserve !</p>
                  <?php endif ?>
                </div>
              </div>
            </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="more-about">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="left-image">
            <img src="assets/images/about-left-image.jpg" alt="">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="section-heading">
            <h2>Discover More About Our Country</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
          </div>
          <div class="row">
           
            <div class="col-lg-12">
              <div class="info-item">
                <div class="row">
                  <div class="col-lg-6">
                    <h4><?php echo $num_cities->num_city; ?></h4>
                    <span>Amazing Places</span>
                  </div>
                  <div class="col-lg-6">
                    <h4><?php echo $num_bookings->count_bookings; ?></h4>
                    <span>Different Check-ins</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
          
        </div>
      </div>
    </div>
  </div>

<?php require "includes/footer.php"; ?>
