<?php
  		echo "<div id=\"tablecontainer\">";
        foreach ($posts as $posttoshow) {
                // print_r($posttoshow->getPost());
                // print_r($posttoshow);
        	echo "<div id=\"tableRow\">       		<div id=\"postid1\">";
        	echo markdownout($posttoshow->getUserName());
        	echo "    </div>
          	<div id=\"userpost\">";
			echo markdownout($posttoshow->getPost());
			$pic = $posttoshow->getPicture();
            $shortfilename = '/pics/'. $posttoshow->getPictureId() .".". $posttoshow->getPictureFilenameExt();
            $filename = $_SERVER['DOCUMENT_ROOT'] .$shortfilename;
            if ($pic) {
                if (file_exists($filename)) {
                    unlink($filename);
                }
                $filestream = fopen ($filename,'w');
                $num = fwrite($filestream, $pic);
 //               echo ("whereis my pic?".$filename);
 //               exit();                
                echo " <img src=\"".$shortfilename."\" />";
 //               unlink ($filename);
            }
            echo "	</div>
        	<div id=\"postdate\">";
         	echo markdownout($posttoshow->getPostDate());
         	echo "</div></div>";
        }
    echo "</div>";