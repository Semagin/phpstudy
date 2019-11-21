<?php
    echo "    <div id= \"tableheader\">\n";
    echo "          <div id= \"headerlabel\">"." <a href=\"".$page."?sortby=1\">User name</a></div>\n";
    echo "          <div id= \"headerlabel\">Post</div>\n";
    echo "          <div id= \"headerlabel\">"." <a href=\"".$page."?sortby=2\">Post date</a></div>\n";
    echo "        </div>\n";
    foreach ($posts as $posttoshow) {
   	    echo "        <div id=\"tableRow\">\n             <div id=\"postid1\">";
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
            echo " <img src=\"".$shortfilename."\" />";
        }
        echo "	</div>
    	     <div id=\"postdate\">";
     	echo markdownout($posttoshow->getPostDate());
     	echo "</div>\n        </div>\n";
    }