<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <h1>Dynamic PHP Gallery</h1>
        <p>Dynamically generate a gallery using PHP based on images present in a directory.  Reads and displays embedded IPTC metadata headline and caption.</p>
        <?php
            $previewDir = 'images/preview/';
            //Replace this filepath with one that contains the images you want to display on this page
            $previewImages = glob($previewDir.'*.jpg');
            foreach($previewImages as $previewImage) {
            //Runs the following on every jpg in the given directory. Images will need to be in jpg format unless you change the glob rule to include other filetypes.
                $fullImage = str_replace("preview","full-size",$previewImage);
                //Changes previewImage filepath to full-size filepath
                $size = getimagesize($previewImage, $info);
                if(isset($info['APP13']))
                    {
                        $iptc = iptcparse($info['APP13']);
                        $title = $iptc["2#105"][0];
                        $caption = $iptc["2#120"][0];
                    }
                //pulls IPTC data from the image and assigns the title and caption as variables
                echo "
                    <div class='previewWrap'>
                        <h3>{$title}</h3>
                        <div class='galleryPreview'>
                            <a href='{$fullImage}'><img src='{$previewImage}' /></a>
                        </div>
                        <div class='infoBox'>
                            <p>{$caption}</p>
                        </div>
                    </div>
                    ";
                //Echos out a div with variables filled in for each image.
            }
        ?>
    </body>
</html>