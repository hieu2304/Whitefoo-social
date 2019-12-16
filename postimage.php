<?php
    require_once('init.php');
    $post = findPostByID($_GET['id']);
    if (isset($post['image']))
    {
        $imagetype = $post['imagetype'];
        header('Content-type: ' . $imagetype);
        if (isset($_GET['width']) && isset($_GET['height']))
        {
            if ($imagetype == 'gif')
            {
                echo $post['image'];
            }
            else
            {
                $new_width = $_GET['width'];
                $new_height = $_GET['height'];
                
                ob_start();
                resizeImage($post['image'], $imagetype, $new_width, $new_height);
                $contents = ob_get_contents();
                ob_end_clean();
                
                echo $contents;
            }
        }
        elseif (isset($_GET['placeholder']))
        {
            $placeholder_width = 48;
            $placeholder_height = 48;
            
            ob_start();
            resizeImage($post['image'], $imagetype, $placeholder_width, $placeholder_height);
            $contents = ob_get_contents();
            ob_end_clean();
            
            echo $contents;
        }
        else
        {
            echo $post['image'];
        }
    }
    else
    {
        echo "Image not found.";
    }
?>