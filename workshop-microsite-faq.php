<?php
/**
 * Template Name: Workshop Microsite FAQ
 *
 * Description: Workshop Microsite FAQ
 *
 *
 */
get_header('workshop'); ?>


<style>
  .btn-orange.element-inline
  {
    /*max-width: 220px;*/
    /*float: right;*/
  }
  .menu-items
  {
    padding: 12px 0 !important;
  }
  .combo-block p
  {

  }
  .immerse-body ul
  {
    font-size: 16px;
  }
  .immerse-body p
  {
    font-size: 18px;
  }
  .about-left p, .about-im-right p, .is-p
  {
    color: #333333;
    font-weight: 600;
  }
  .academic-row-3 .element-container
  {
    border-bottom: 1px solid #e2e2e4;
    padding-bottom: 50px;
  }
  .academic-row-3.padding-tb
  {
    padding-bottom: 0;
  }
  .reports-wrap
  {
    overflow: auto;
  }
  .report-item
  {
    display: block;
    width: 21%;
    margin: 2%;
    padding: 25px 0;
    text-align: center;
    float: left;
  }
  .report-item img
  {
    /*margin-bottom: 10px;*/
  }
  .report-item .icon-wrap
  {
    height: 80px;
  }
  a.inline-link, a.inline-link:hover
  {
    color: #ff6633;
    text-decoration: none;
    background:none;
    padding:0;
    /* font-size: 20px; */
    float: none; 
    margin-top: 0;
  }
  a.request-info
  {
    color: #ff6633;
    text-decoration: none;
    background: url('http://chartcipher.com/wp-content/themes/hitsongsdeconstructed/assets/images/arrow-right.svg') no-repeat right;
    padding: 0px 15px 0px 0;
    font-size: 18px;
    display: inline-block;
    margin-top: 25px;
  }
  .report-item h3
  {
    font-size: 16px;
    line-height: 22px;
    width: 80%;
    margin: 10px auto;
    color: #333333;
  }
  .report-item p
  {
    font-size: 16px;
    line-height: 26px;
    width: 91%;
    margin: 15px auto;
    color: #666666;
  }
  @media (max-width: 1200px) and (min-width: 768px){
    .combo-header .menu-items {     width: 480px !important; }
  }
  @media (max-width: 1200px)
  {
    .menu-items .btn-orange.element-inline
    {
      display: none;
    }
  }
  @media screen and (min-width: 768px){
    .combo-block-right
    {
      float: left;
      width: 85%;
      text-align: left !important;
      padding: 0 0%;
      padding-left: 3%;
    }
    .span-4 {
      width: 48%;
    }
    .combo-block img
    {
      float: left;
      width: 10%

    }
    .combo-block-right h2
    {
      text-align: left;
      font-size:18px;
    }
    .combo-block-right p
    {
      text-align: left;
      font-size: 17px;
      /* text-align-last: center; */
      padding: 0;
      width: 95%;
    }
    .combo-block-hsd
    {
      border-right: none;
    }
    .combo-block-immersion {
      margin-left: 15px;
    }
  }
  .sidebar-toggle-box{display: none !important;}
  @media screen and (max-width: 600px){
    .combo-header .logo-container, .home-header .logo-container, .academic-header .logo-container
    {
      float:none !important;
      margin:0 auto;
    }
  }
  @media screen and (max-width: 782px){
    /*.combo-block-right ,.combo-block img{float:none;}*/
    .report-item
    {
     width: 100%;
     margin: 0 auto;
   }
 }
</style>

<link rel="stylesheet" type="text/css" href="http://chartcipher.com/wp-content/themes/hitsongsdeconstructed/assets/css/workshop-style.css">
<div id="primary" class="content-area academic-page workshop-faq">
  <section class="row academic-row-1">
    <div class="element-container">
      <div class="header-container header-academic-container header-workshop-container">
       Agenda
     </div><!-- /.header-container --> 
   </div>    
   <div class="header-vid-bottom">
    <div class="element-container">
      <div class="header-academic-bottom">
        <div class="academic-bottom academic-bottom-1">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/workshop/hit-songs-deconstructed-topics-being-covered-icon.svg" />
          <p><a href="#topicscovered">Topics Being Covered</a></p>
          <a href="#topicscovered"></a>  
        </div><!-- /.academic-bottom-1 --> 
        <div class="academic-bottom academic-bottom-2">
          <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/workshop/about-immersion-icon.svg" /> -->
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/workshop/hit-songs-deconstructed-why-attend-icon.svg" />
          <p><a href="#whyattend">Why Attend</a></p>
          <a href="#whyattend"></a>    
        </div><!-- /.academic-bottom-2 -->
        <div class="academic-bottom academic-bottom-3">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/workshop/hit-songs-deconstructed-who-should-attend-icon.svg" />
          <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/workshop/about-academic-icon.svg" /> -->
          <p><a href="#whoattend">Who Should Attend</a></p>
          <a href="#whoattend"></a>    
        </div><!-- /.academic-bottom-3 -->
        <div class="academic-bottom academic-bottom-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/workshop/hit-songs-deconstructed-schedule-icon.svg" />
          <p><a href="#schedule">Workshop Schedule</a></p>
          <a href="#schedule"></a>    
        </div><!-- /.academic-bottom-4 -->
        <div class="academic-bottom academic-bottom-5">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/workshop/hit-songs-deconstructed-agenda-icon.svg" />
          <p><a href="#">Workshop Agenda</a></p>
          <a href="#"></a>    
        </div><!-- /.academic-bottom-5 -->  
      </div>
    </div>
  </div><!-- /.header-vid-bottom -->
</section><!-- /.academic-row-1 -->

<section class="bg-white padding-tb workshop-row-agenda">
  <div class="element-container">
    <div class="workshop-block">
      <h2>Q: Do I need advanced knowledge of music theory to understand what is being taught?</h2>
<h3>A: No. While rooted in theory, the topics being covered are conveyed in a practical manner.</h3>

<h2>Q: What level of songwriting knowledge do I need?</h2>
<h3>A: A solid foundation in the basic craft of songwriting is strongly recommended.</h3>

<h2>Q: Who is this meant for?</h2>
<h3>A: Songwriters, producers, instrumentalists and A&R/Music Industry Professionals who have the goal of being involved in today’s mainstream music scene.</h3>

<h2>Q: What is the basis for the material covered?</h2>
<h3>A: We will focus on the songs that land in the Top 10 of the Billboard Hot 100, because they are the most successful. It will be a combination of current songs across each primary genre (Dance/Club/Electronic, Hip Hop/Rap, Pop, R&B/Soul, Rock), as well as a special focus on Max Martin hits over the last few years.</h3>

<h2>Q: How will the material be conveyed?</h2>
<h3>A: The presentation will feature a combination of audio examples, graphs, charts, and commentary to illustrate principals and techniques.</h3>
    </div>
  </section>

</div><!-- /.content-area --> 
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript">


  jQuery(document).ready(function($){

    $.validator.setDefaults({
      errorElement: 'div',

    });

    $('#academic-form').validate({

      rules: {
        fname: {
          required: true
        },
        lname: {
          required: true

        },
        academicins: {
          required: true

        },
        jobfunction: {
          required: true

        },  
        email: {
         required: true
       },
       phone: {
         required: true
       },
       state: {
         required: true
       },
       country: {
         required: true
       }
     }
   });
    
    
    $('#submit').on('click', function(e){   
      if ($("#academic-form").valid()) {    
        e.preventDefault(); 
        var ocode = $('#ocode').val();
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var academicins = $('#academicins').val();
        var jobfunction = $('#jobfunction').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var state = $('#state').val();
        var country = $('#country').val();
        var academicform = $('#academicform').val();
        var academicdemo = $('#academicdemo:checked').val();
        var academicpricing = $('#academicpricing:checked').val();
        $('#submit').html('<span>One Moment Please...</span>')
        $('#errorbox').html('' );


        $.post(
          '/streamsend/academic-subscribe.php',
          { 
            fname: fname,
            lname: lname,
            email: email,
            academicins: academicins,
            jobfunction: jobfunction,
            phone: phone,
            state: state,
            country: country,
            academicform: academicform,
            academicdemo: academicdemo,
            academicpricing: academicpricing,
            ocode: ocode
          },
          function(msg) {
           $('.academic-form-container').html('<h1>Thank You!</h1>');  
           window._ssstats = window._ssstats || [];
           _ssstats.push([
            'configure', {
              accountId: 334905
            }
            ]);
           _ssstats.push(['identify', email]);
           _ssstats.push([
            'publish',
            'Subscribe', {
              subscription: 'Academic',
              ocode: ocode
            }
            ]);             

         });
      }
    });
  });
</script>
<script src="//cdn.statstrk01.com/assets/javascripts/sdk2.js" async></script>
<?php get_footer();?>
