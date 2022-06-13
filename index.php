<?php
   $store_locally = false; 
   
   function generateRandomString($length = 10) {
       $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $charactersLength = strlen($characters);
       $randomString = '';
       for ($i = 0; $i < $length; $i++) {
           $randomString .= $characters[rand(0, $charactersLength - 1)];
       }
       return $randomString;
   }
   
   function downloadVideo($video_url, $geturl = false)
   {
       $ch = curl_init();
       $headers = array(
           'Range: bytes=0-',
       );
       $options = array(
           CURLOPT_URL            => $video_url,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_HEADER         => false,
           CURLOPT_HTTPHEADER     => $headers,
           CURLOPT_FOLLOWLOCATION => true,
           CURLINFO_HEADER_OUT    => true,
           CURLOPT_USERAGENT => 'okhttp',
           CURLOPT_ENCODING       => "utf-8",
           CURLOPT_AUTOREFERER    => true,
           CURLOPT_COOKIEJAR      => 'cookie.txt',
   	CURLOPT_COOKIEFILE     => 'cookie.txt',
           CURLOPT_REFERER        => 'https://www.tiktok.com/',
           CURLOPT_CONNECTTIMEOUT => 30,
           CURLOPT_SSL_VERIFYHOST => false,
           CURLOPT_SSL_VERIFYPEER => false,
           CURLOPT_TIMEOUT        => 30,
           CURLOPT_MAXREDIRS      => 10,
       );
       curl_setopt_array( $ch, $options );
       if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
         curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
       }
       $data = curl_exec($ch);
       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       if ($geturl === true)
       {
           return curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
       }
       curl_close($ch);
       $filename = "user_videos/" . generateRandomString() . ".mp4";
       $d = fopen($filename, "w");
       fwrite($d, $data);
       fclose($d);
       return $filename;
   }
   
   if (isset($_GET['url']) && !empty($_GET['url'])) {
       if ($_SERVER['HTTP_REFERER'] != "") {
           $url = $_GET['url'];
           $name = downloadVideo($url);
           echo $name;
           exit();
       }
       else
       {
           echo "";
           exit();
       }
   }
   
   function getContent($url, $geturl = false)
     {
       $ch = curl_init();
       $options = array(
           CURLOPT_URL            => $url,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_HEADER         => false,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_USERAGENT => 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Mobile Safari/537.36',
           CURLOPT_ENCODING       => "utf-8",
           CURLOPT_AUTOREFERER    => false,
           CURLOPT_COOKIEJAR      => 'cookie.txt',
   	CURLOPT_COOKIEFILE     => 'cookie.txt',
           CURLOPT_REFERER        => 'https://www.tiktok.com/',
           CURLOPT_CONNECTTIMEOUT => 30,
           CURLOPT_SSL_VERIFYHOST => false,
           CURLOPT_SSL_VERIFYPEER => false,
           CURLOPT_TIMEOUT        => 30,
           CURLOPT_MAXREDIRS      => 10,
       );
       curl_setopt_array( $ch, $options );
       if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
         curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
       }
       $data = curl_exec($ch);
       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       if ($geturl === true)
       {
           return curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
       }
       curl_close($ch);
       return strval($data);
     }
   
     function getKey($playable)
     {
     	$ch = curl_init();
     	$headers = [
       'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
       'Accept-Encoding: gzip, deflate, br',
       'Accept-Language: en-US,en;q=0.9',
       'Range: bytes=0-200000'
   	];
   
       $options = array(
           CURLOPT_URL            => $playable,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_HEADER         => false,
           CURLOPT_HTTPHEADER     => $headers,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
           CURLOPT_ENCODING       => "utf-8",
           CURLOPT_AUTOREFERER    => false,
           CURLOPT_COOKIEJAR      => 'cookie.txt',
   	CURLOPT_COOKIEFILE     => 'cookie.txt',
           CURLOPT_REFERER        => 'https://www.tiktok.com/',
           CURLOPT_CONNECTTIMEOUT => 30,
           CURLOPT_SSL_VERIFYHOST => false,
           CURLOPT_SSL_VERIFYPEER => false,
           CURLOPT_TIMEOUT        => 30,
           CURLOPT_MAXREDIRS      => 10,
       );
       curl_setopt_array( $ch, $options );
       if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
         curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
       }
       $data = curl_exec($ch);
       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       curl_close($ch);
       $tmp = explode("vid:", $data);
       if(count($tmp) > 1){
       	$key = trim(explode("%", $tmp[1])[0]);
       }
       else
       {
       	$key = "";
       }
       return $key;
     }
   ?>
<!doctype html>
<html>
   <meta http-equiv="content-type" content="text/html;charset=utf-8" />
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="node_modules/modern-normalize/modern-normalize.css">
      <link rel="stylesheet" href="styles/style.css">
   <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
   <meta name="msapplication-TileColor" content="#da532c">
   <meta name="theme-color" content="#000000">

   <meta name="title" content="TikTok Video Downloader - Download and Save fast and free | Swiftly">
   <meta name="description" content="Swiftly is the easiest and fastest way to download TikTok videos from the internet. Download videos from TikTok easily and for free. Just enter the video URL into the box and hit Start! Free, faster and easier alternative to download TikTok videos from the Internet. No timeouts, no captchas and no bandwidth limits.">
   <meta name="keywords" content="tiktok, tiktok video downloader, tikok video download, download tiktok video, download tiktok audio, how to download tik tok videos, video save tiktok, tiktok videos download, tiktok video save, save tiktok online, online tiktok video downloader ">
   <meta name="robots" content="index, follow">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="language" content="English">
   <meta name="author" content="Vinlex Technologies">
     
   <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PDKDQW3ZX6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PDKDQW3ZX6');
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TF44JLT');</script>
<!-- End Google Tag Manager -->

   </head>
   <body>

   <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF44JLT"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

      <div class="qd">
         <header class="be jj">
            <div class="a ce k th hk">
               <div class="bb mc oc">
                  <div class="dc">
                     <a href="#" title="" class="bb bd rf lg ng qg">
                     <a href="#" title="" class="je ee qe xe bf gf vf wf pd hd jd cd yf font-pj kg mg qg ng" role="">Swiftly.</a>
                     </a>
                  </div>
                  <div class="bb sj">
                     <button type="button" class="ff">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                     </button>
                  </div>
                  <a href="#" title="" class="je ee qe xe bf gf vf wf pd hd jd cd yf font-pj kg mg qg ng" role="button">Why choose us?</a>
               </div>
            </div>
      </div>
      </header>
      <section class="ne oe ai lk">
         <div class="ce k vb th hk">
            <div class="db yb jc k tj yj xj tc dk">
               <div>
                  <div class="pe mk">
                     <h1 class="ue xe cf ff ei fi ok nk font-pj">The fastest, easiest way to download TikTok videos!</h1>
                     <p class="t te if ah">Swiftly is a free, quicker, and more secure TikTok video downloader. You simply stary by entering the video's URL in the box below directly from your browser, without the need for any extra software.</p>
                     <form method="POST" class="q bh">
                        <div class="c zd qh sh rg ph hi ii gi">
                           <input type="text" name="tiktok-url" placeholder="Enter video URL here..." class="ab qb ce be ff lf rd hd md rf gg lg ng cd rh ki ji" >
                           <div class="u ch wg xg yg fh jh bi">
                              <button type="submit" placeholder="https://www.tiktok.com/@username/video/1234567890123456789" class="cb de ke te xe gf vf wf pd ed kg jg font-pj yf">Download Now</button>
                              <div class="c qh sh rg ph hi ii gi">
                                 <div class="u ch wg xg yg fh jh bi">
                                 </div>
                              </div>
                     </form>
                     </form>
                     </div>
                     </div>
                     </form>
                  </div>
                  <div class="bb mc nc n vc zj nh">
                     <div class="bb mc">
                        <p class="se we ff di font-pj">100k</p>
                        <p class="v re ff font-pj">Users<br>YTD</p>
                     </div>
                     <div class="eb eh">
                        <svg class="hf" width="16" height="39" viewBox="0 0 16 39" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                           <line x1="0.72265" y1="10.584" x2="15.7226" y2="0.583975"></line>
                           <line x1="0.72265" y1="17.584" x2="15.7226" y2="7.58398"></line>
                           <line x1="0.72265" y1="24.584" x2="15.7226" y2="14.584"></line>
                           <line x1="0.72265" y1="31.584" x2="15.7226" y2="21.584"></line>
                           <line x1="0.72265" y1="38.584" x2="15.7226" y2="28.584"></line>
                        </svg>
                     </div>
                     <div class="bb mc">
                        <p class="se we ff di font-pj">1M+</p>
                        <p class="v re ff font-pj">Downloads<br>Completed</p>
                     </div>
                  </div>
               </div>
               <div>
                  <img class="qb" src="https://i.pinimg.com/originals/1b/c1/60/1bc1609edfe74fe7776cb8bc590311ce.png" alt="">
               </div>
            </div>
         </div>
      </section>
      <section>
         <div class="bg-light">
            <div class="text-center p-5">
               <link rel="stylesheet" href="styles\downloads.css">
               <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script></script>
               <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
               <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
               <?php
                  if (isset($_POST['tiktok-url']) && !empty($_POST['tiktok-url'])) {
                  	$url = trim($_POST['tiktok-url']);
                  	$resp = getContent($url);
                  	//echo "$resp";
                  	$check = explode('"downloadAddr":"', $resp);
                  	if (count($check) > 1){
                  		$contentURL = explode("\"",$check[1])[0];
                  		$contentURL = str_replace("\\u0026", "&", $contentURL);
                  		$contentURL = str_replace("\\u002F", "/", $contentURL);
                  		$thumb = explode("\"",explode('og:image" content="', $resp)[1])[0];
                  		$username = explode('"',explode('"uniqueId":"', $resp)[1])[0];
                  		$create_time = explode('"', explode('"createTime":"', $resp)[1])[0];
                  		$dt = new DateTime("@$create_time");
                  		$create_time = $dt->format("d M Y H:i:s A");
                  		$videoKey = getKey($contentURL);
                  		$cleanVideo = "https://api2-16-h2.musical.ly/aweme/v1/play/?video_id=$videoKey&vr_type=0&is_play_url=1&source=PackSourceEnum_PUBLISH&media_type=4";
                  		$cleanVideo = getContent($cleanVideo, true);
                  		if (!file_exists("user_videos") && $store_locally){
                  			mkdir("user_videos");
                  		}
                  		if ($store_locally){
                  			?>
               <script type="text/javascript">
                  $(document).ready(function(){
                      $('#wmarked_link').text("Please wait ...");
                      $.get('./<?php echo basename($_SERVER['PHP_SELF']); ?>?url=<?php echo urlencode($contentURL); ?>').done(function(data)
                          {
                              $('#wmarked_link').removeAttr('disabled');
                              $('#wmarked_link').attr('onclick', 'window.location.href="' + data + '"');
                              $('#wmarked_link').text("Download Video");
                          });
                  });
               </script>
               <?php
                  }
                  ?>
               <script>
                  $(document).ready(function(){
                      $('html, body').animate({
                     scrollTop: ($('#result').offset().top)
                  },1000);
                  });
               </script>
               <div class="border m-3 mb-5" id="result">
                  <div class="row m-0 p-2">
                     <div class="col-sm-5 col-md-5 col-lg-5 text-center"><img width="250px" height="250px" src="<?php echo $thumb; ?>"></div>
                     <div class="col-sm-6 col-md-6 col-lg-6 text-center mt-5">
                        <ul style="list-style: none;padding: 0px">
                           <li>This video was created by: <b>@<?php echo $username; ?></b></li>
                           <li>Created on: <b><?php echo $create_time; ?></b></li>
                           <li><button id="wmarked_link" disabled="disabled" class="btn btn-primary mt-3" onclick="window.location.href='<?php if ($store_locally){ echo $filename;} else { echo $contentURL; } ?>'">Download Video</button></li>
                           <li>
                              <div class="alert alert-primary mb-0 mt-3">If the video automatically starts playing, try storing it by hitting CTRL+S or saving from the three dots in the bottom left corner on your phone.</div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <?php
                  }
                  else
                  {
                  	?>
               <script>
                  $(document).ready(function(){
                      $('html, body').animate({
                     scrollTop: ($('#result').offset().top)
                  },1000);
                  });
               </script>
               <div class="mx-5 px-5 my-3" id="result">
                  <div class="alert alert-danger mb-0"><b>Please double check your url and try again.</b></div>
               </div>
               <?php
                  }
                  }
                  ?>
               <div class="m-5">
                  &nbsp;
               </div>
               <script type="text/javascript">
                  $(document).ready(function(){
                      $('#wmarked_link').text("Please wait ...");
                      $.get('./<?php echo basename($_SERVER['PHP_SELF']); ?>?url=<?php echo urlencode($contentURL); ?>').done(function(data)
                          {
                              $('#wmarked_link').removeAttr('disabled');
                              $('#wmarked_link').attr('onclick', 'window.location.href="' + data + '"');
                              $('#wmarked_link').text("Download Video");
                          });
                  });
               </script>
            </div>
            <script>
               $(document).ready(function(){
                   $('html, body').animate({
                  scrollTop: ($('#result').offset().top)
               },1000);
               });
            </script>
      </section>
      </div>
      <section class="c he zc qd uh ik dl">
         <div class="ce k vb th hk">
            <div class="db mc jc yk">
               <div class="ie pe fl el yi oi uk">
                  <h2 class="se xe ff di gl font-pj">Millions of users and brands rely on it.</h2>
                  <p class="p te ye if font-pj">Swiftly connects your worlds while keeping you safe and secure on all your devices: enjoy beautiful, easy-to-use tools tursted by millions.</p>
               </div>
               <div class="c q zg uj mj uk qk">
                  <div class="b f">
                     <div class="qb hb k ec nf fd sf uf" style="background: linear-gradient(90deg, #44ff9a -0.55%, #44b0ff 22.86%, #8b44ff 48.36%, #ff6644 73.33%, #ebff70 99.34%)"></div>
                  </div>
                  <div class="c xc">
                     <div class="db jc pc hh">
                        <div class="bb mc nc de be k zc od ed qf tb wi">
                           <img class="pb ib" src="images/microsoft-logo-png-transparent.png" alt="">
                        </div>
                        <div class="bb mc nc de be k zc od ed qf tb wi">
                           <img class="pb ib" src="https://cdn.rareblocks.xyz/collection/clarity/images/brands/3/logo-martino.svg" alt="">
                        </div>
                        <div class="bb mc nc de be k zc od ed qf tb wi">
                           <img class="pb ib" src="https://cdn.rareblocks.xyz/collection/clarity/images/brands/3/logo-squarestone.svg" alt="">
                        </div>
                     </div>
                     <div class="db jc pc hh wk">
                        <div class="bb mc nc de be k zc od ed qf tb wi">
                           <img class="pb ib" src="https://cdn.rareblocks.xyz/collection/clarity/images/brands/3/logo-waverio.svg" alt="">
                        </div>
                        <div class="bb mc nc de be k zc od ed qf tb wi">
                           <img class="pb ib" src="https://cdn.rareblocks.xyz/collection/clarity/images/brands/3/logo-fireli.svg" alt="">
                        </div>
                        <div class="bb mc nc de be k zc od ed qf tb wi">
                           <img class="pb ib" src="https://cdn.rareblocks.xyz/collection/clarity/images/brands/3/logo-virogan.svg" alt="">
                        </div>
                     </div>
                     <div class="db jc pc hh xk">
                        <div class="bb mc nc de be k zc od ed qf tb wi">
                           <img class="pb ib" src="https://cdn.rareblocks.xyz/collection/clarity/images/brands/3/logo-aromix.svg" alt="">
                        </div>
                        <div class="bb mc nc de be k zc od ed qf tb wi">
                           <img class="pb ib" src="https://cdn.rareblocks.xyz/collection/clarity/images/brands/3/logo-natroma.svg" alt="">
                        </div>
                        <div class="bb mc nc de be k zc od ed qf tb wi">
                           <img class="pb ib" src="https://upload.wikimedia.org/wikipedia/en/thumb/a/a9/TikTok_logo.svg/2560px-TikTok_logo.svg.png" alt="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="b g sd cl td ud vd"></div>
      </section>
      <section class="he od uh ik">
         <div class="ce k vb th hk">
            <div class="pe">
               <h2 class="se xe cf ff di gl font-pj">Swiftly. You Know it.</h2>
               <p class="u qe bf if ah font-pj">It's simple, we are regarded as one of the best in our industry.</p>
            </div>
            <div class="db jc n pe dh ih lh tc zi dj rk">
               <div class="ij gk gj hj">
                  <svg class="k" width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M9.66667 25H6C3.23858 25 1 27.2386 1 30V37C1 39.7614 3.23858 42 6 42H36C38.7614 42 41 39.7614 41 37V30C41 27.2386 38.7614 25 36 25H31.8333C30.2685 25 29 26.2685 29 27.8333C29 29.3981 27.7315 30.6667 26.1667 30.6667H15.3333C13.7685 30.6667 12.5 29.3981 12.5 27.8333C12.5 26.2685 11.2315 25 9.66667 25Z" fill="#D4D4D8"></path>
                     <path d="M9 9H33" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M9 17H33" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M1 25H13V31H29V25H41" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M37 1H5C2.79086 1 1 2.79086 1 5V37C1 39.2091 2.79086 41 5 41H37C39.2091 41 41 39.2091 41 37V5C41 2.79086 39.2091 1 37 1Z" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  <h3 class="o ve xe ff font-pj">Unlimted downloads</h3>
                  <p class="w qe if font-pj">There are no limits or restrictions on how many videos you may save.</p>
               </div>
               <div class="ij gk fj hj gj">
                  <svg class="k" width="46" height="42" viewBox="0 0 46 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M30.562 18.4609C30.0511 17.9392 29.4292 17.5392 28.7426 17.2907C28.0559 17.0422 27.3221 16.9516 26.5956 17.0256C25.8692 17.0996 25.1687 17.3362 24.5462 17.718C23.9237 18.0998 23.3952 18.6169 23 19.2309C22.6049 18.6167 22.0764 18.0995 21.4539 17.7176C20.8315 17.3357 20.1309 17.099 19.4044 17.025C18.6779 16.951 17.944 17.0417 17.2573 17.2903C16.5706 17.5389 15.9488 17.939 15.438 18.4609C14.5163 19.4035 14.0002 20.6695 14.0002 21.9879C14.0002 23.3063 14.5163 24.5722 15.438 25.5149L23 33.1999L30.564 25.5159C31.485 24.5726 32.0004 23.3064 32 21.988C31.9997 20.6696 31.4835 19.4037 30.562 18.4609Z" fill="#D4D4D8" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M41 41H5C3.93913 41 2.92172 40.5786 2.17157 39.8284C1.42143 39.0783 1 38.0609 1 37V1H17L22 9H45V37C45 38.0609 44.5786 39.0783 43.8284 39.8284C43.0783 40.5786 42.0609 41 41 41Z" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  <h3 class="o ve xe ff font-pj">Fast & Secure</h3>
                  <p class="w qe if font-pj">We regularly update our software to make sure it is secure for every user.</p>
               </div>
               <div class="ij gk fj hj gj">
                  <svg class="k" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M25 7C34.941 7 43 15.059 43 25C43 34.941 34.941 43 25 43C15.059 43 7 34.941 7 25" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M19 1C9.059 1 1 9.059 1 19H19V1Z" fill="#D4D4D8" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  <h3 class="o ve xe ff font-pj">Top Quality</h3>
                  <p class="w qe if font-pj">Our software APIs deliver the highest video quality in the original format.</p>
               </div>
            </div>
         </div>
      </section>
      <section class="he od uh ik">
         <div class="ce k vb th hk">
            <div class="db mc jc qc zi">
               <div>
                  <img class="qb vi" src="../../../../../cdn.rareblocks.xyz/collection/clarity/images/integrations/3/top-logos.png" alt="">
                  <img class="eb qb wj ti" src="../../../../../cdn.rareblocks.xyz/collection/clarity/images/integrations/3/left-logos.png" alt="">
               </div>
               <div class="pe">
                  <h2 class="se xe ff di gl font-pj">Easy access to over +1B videos.</h2>
                  <p class="p te ye if font-pj">You may download over a billion TikTok videos with with swiftly.</p>
               </div>
               <div>
                  <img class="qb vi" src="../../../../../cdn.rareblocks.xyz/collection/clarity/images/integrations/3/bottom-logos.png" alt="">
                  <img class="eb qb wj ti" src="../../../../../cdn.rareblocks.xyz/collection/clarity/images/integrations/3/right-logos.png" alt="">
               </div>
            </div>
         </div>
      </section>
      <section class="he pd uh jk">
         <div class="ce k vb th hk">
            <div class="db mc jc rc kh xj">
               <div>
                  <div class="cc k od vk gd fc">
                     <div class="ae wh xh">
                        <img class="pb fb" src="https://cdn.rareblocks.xyz/collection/clarity/images/cta/3/crowny-logo.svg" alt="">
                        <blockquote class="p">
                           <p class="te ye df ff font-pj">“You made it so simple. I am now able to download my TikTok Video in just seconds from my browswer. Thank you truly.”</p>
                        </blockquote>
                        <div class="bb mc oc q">
                           <div class="bb mc">
                              <img class="dc xd dd ub mb" src="images/userAvatar.webp" alt="">
                              <div class="v">
                                 <p class="te xe ff font-pj">Jerome Host</p>
                                 <p class="qe font-pj ye if x">Current User</p>
                              </div>
                           </div>
                           <img class="pb nb" src="https://cdn.rareblocks.xyz/collection/clarity/images/cta/3/signature.svg" alt="">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="ac k pe vj mk">
                  <h2 class="se xe gf di gl font-pj">Get your download in seconds.</h2>
                  <p class="q qe ye bf jf font-pj">Swiftly is a free, quicker, and more secure TikTok video downloader. You simply stary by entering the video's URL in the box below directly from your browser, without the need for any extra software.</p>
                  </p>
                  <form action="#" method="POST" class="r">
                     <label for="" class="te xe gf font-pj">Get the latest software updates from swiftly:</label>
                     <div class="c yb k w lj">
                        <div class="b d">
                           <div class="qb hb k ec nf sf uf" style="background: linear-gradient(90deg, #44ff9a -0.55%, #44b0ff 22.86%, #8b44ff 48.36%, #ff6644 73.33%, #ebff70 99.34%)"></div>
                        </div>
                        <div class="c">
                           <input type="email" name="" id="" placeholder="Enter your email address" class="ab qb je le qe ye gf mf pd hd jd cd hg lg pg font-pj kg">
                           <div class="u ch wg xg yg fh jh ci">
                              <button type="submit" class="cb mc nc qb ie be qe xe ff vf wf od hd jd yh gh kg mg qg pg font-pj bg cd">
                              Get started now
                              </button>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </section>
      <footer class="he pd uh ik">
         <div class="ce k vb th hk">
            <div class="ui aj cj">
               <div class="cc q pi">
               </div>
            </div>
            <hr class="o nd qi">
            <div class="n rj yj ck si">
               <ul class="bb mc vc oh">
                  <li>
                     <p class="q te ye gf oj font-pj">
                        © Copyright <script>document.write(new Date().getFullYear())</script>, All Rights Reserved
                     </p>
                  </li>
               </ul>
            </div>
         </div>
      </footer>
      <script type="text/javascript">
         window.setInterval(function(){
             if ($("input[name='tiktok-url']").attr("placeholder") == "Enter URL here.....") {
                 $("input[name='tiktok-url']").attr("placeholder", "Please enter your URL here....");
             }
             else
             {
                 $("input[name='tiktok-url']").attr("placeholder", "Enter URL here.....");
             }
         }, 3000);
      </script>
   </body>
</html>