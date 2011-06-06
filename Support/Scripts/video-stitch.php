<?php
$wallWidth = 320;
$wallHeight = 120;
$tileHeight = 120;
$tileWidth = 160;
$totalFrames = 60;

//ffmpeg -i gk-2.flv -r 15 -s 160x120 -f image2 gk-2/frames-%d.jpeg
$gawkId = 1;

$y = $x = $i = 0;

$videoIds = array();
$framePositions = array();

        while ($y <= ($wallHeight - $tileHeight)) {
                while ($x <= ($wallWidth - $tileWidth)) {
                        $framePositions[] = array($x, $y);
                        $x += $tileWidth;
                }
                $x = 0;
                $y += $tileHeight;
        }


foreach ($videoIds as $videoId) {
	$exec = "convert -size {$wallWidth}x{$wallHeight} xc:skyblue ";


}

// for each of the 60 frames
for ($i = 1; $i <= $totalFrames; $i++) {
        $exec = "convert -size {$wallWidth}x{$wallHeight} xc:skyblue ";
        while ($y <= ($wallHeight - $tileHeight)) {
                while ($x <= ($wallWidth - $tileWidth)) {
                        if ($x == 0) {
                                $gawkId = 1;
                        } else {
                                $gawkId = 2;
                        }

                        $exec .= "gk-{$gawkId}/frames-$i.jpeg  -geometry  +{$x}+{$y}  -composite ";
                        $x += $tileWidth;
                }
                $x = 0;
                $y += $tileHeight;
        }
        $y = 0;

        $exec .= " wall/frames-{$i}.jpeg";

        shell_exec($exec);
}

shell_exec("ffmpeg -r 15 -b 23800 -i wall/frames-%d.jpeg wall/stiched.mp4");
