var inputvalue;
var typeOfAction;
var position;
var postID;
function getbuttonvalue(objbtn)
{
    //get all value
    inputvalue = String(objbtn.value);
    position = inputvalue.indexOf('-');

    typeOfAction = inputvalue.substring(position+1);
    inputvalue = inputvalue.substring(0,position);
    let postID = Number(inputvalue);

    // if the button clicked is delete
    if(typeOfAction == 'deletebtn')
    {
        //delete the post from the View (div userpost)
        var command_jQuery = '#userpost[value="'+ inputvalue +'"]';
        $(command_jQuery).remove();
        //call the function delete form DB;
        $.ajax
        ({
            url:"includes/deletepost.php",
            method:"POST",
            data:{postID:postID},
            cache:false
        });
    }
    //we will add more features for post(s) later over here, follow the input 'typeOfAction'
}