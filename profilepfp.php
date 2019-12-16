<?php
    require_once('init.php');
    $user = findUserByID($_GET['id']);
    if (isset($user['pfp']))
    {
        $pfptype = $user['pfptype'];
        header('Content-type: ' . $user['pfptype']);
        if (isset($_GET['width']) && isset($_GET['height']))
        {
            if ($pfptype == 'gif')
            {
                echo $user['pfp'];
            }
            else
            {
                $new_width = $_GET['width'];
                $new_height = $_GET['height'];
                
                ob_start();
                resizeImage($user['pfp'], $pfptype, $new_width, $new_height);
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
            resizeImage($user['pfp'], $pfptype, $placeholder_width, $placeholder_height);
            $contents = ob_get_contents();
            ob_end_clean();
            
            echo $contents;
        }
        else
        {
            echo $user['pfp'];
        }
    }
    else
    {
        echo "Profile picture not found.";
    }
?>