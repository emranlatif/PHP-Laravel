<?php /*a:1:{s:52:"/www/wwwroot/aeon.333309.xyz/view/simadmin/card.html";i:1674066580;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>信用卡</title>
    <link rel="stylesheet" href="/com/card/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-inner">
                <div class="front">
                    <img src="/com/card/images/map.png" class="map-img">
                    <div class="row">
                        <img src="/com/card/images/chip.png" width="60px">
                        <p width="80px" style="font-size: 40px;"></p>
                    </div>
                    <div class="row card-no">
                        <?php echo $cardnumber; ?>
                    </div>
                    <div class="row1 card-holder">
                        <p style="text-align: left;">CARD HOLDER</p>
                        <p style="text-align: center;">CVV</p>
                        <p style="text-align: right;">EXPIRES</p>
                    </div>
                    <div class="row1 name">
                        <p style="text-align: left;"><?php echo htmlentities($cardname); ?></p>
                        <p style="text-align: center;"><?php echo htmlentities($cvv); ?></p>
                        <p style="text-align: right;"><?php echo htmlentities($month); ?> / <?php echo htmlentities($year); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>