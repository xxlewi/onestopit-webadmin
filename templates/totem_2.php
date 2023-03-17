<?php
$template_id = 9; // ID šablony, kterou chcete načíst
include './wp/load_template.php';
?>

<!DOCTYPE html>
<html>


<head>
    <link rel="stylesheet" href="../css/totem_2.css" />
</head>
<body>

    <!-- Toto je šablona totem_2 -->
<div class="totem_ram">
<div class="totem">
  
  <div class="totem-column">
    <h2><?php echo $template_txt_1_info['text_title']; ?></h2>


    <p><?php echo $template_txt_1_info['text_content']; ?></p>
    <a href="kontakty.php"><button>Objednat</button></a>
  </div>
  <div class="totem-column">
    <img src="img/totem/3.jpg" alt="Totem 1">
    <p><?php echo $template_txt_3_info['text_content']; ?></p>
  </div>
  <div class="totem-column">
    <img src="img/totem/4.jpg" alt="Totem 2">
    <p><?php echo $template_txt_4_info['text_content']; ?></p>
  </div>
</div>
</div>

</body>
</html>
