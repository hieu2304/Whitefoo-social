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
    // if the button clicked is delete
    if(typeOfAction == 'deletebtn')
    {
        //ask user to confirm delete this post by value
        if(confirm("Bạn có chắc là muốn xóa bài viết này?"))
        {
            let postID = Number(inputvalue);
            //delete the post from the View (div userpost)
            var command_jQuery = '#userpost[value="userpost-'+ inputvalue +'"]';
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
    }
    else if(typeOfAction == 'sendbtn')
    {    
        position = inputvalue.indexOf('=');
        profileID = inputvalue.substring(position+1);
        conversationID = inputvalue.substring(0,position);
        message = document.getElementById("inputmessagehere").value;
        if(!(message == '' || message == " "))
        {
            //gửi
            $.ajax
            ({
                url:"includes/sendding-message.php",
                method:"POST",
                data:{conversationID:conversationID, profileID:profileID, message:message},
                cache:false
            });
            //tải lại sau 1s
            timedRefresh(1000);
        }
    }
    else if(typeOfAction == 'deletemessagebtn')
    {      
        if(confirm("Bạn có chắc là muốn xóa tin nhắn này?"))
        {
            position = inputvalue.indexOf('=');
            messageID = inputvalue.substring(position+1);
            inputvalue = inputvalue.substring(0, position);
            position = inputvalue.indexOf('+');
            conversationID = inputvalue.substring(position+1);
            profileID = inputvalue.substring(0,position);
            var command_jQuery = '#messaging[value="msg'+ messageID +'"]';
            $(command_jQuery).remove();
            $.ajax
            ({
                url:"includes/deleting-message.php",
                method:"POST",
                data:{conversationID:conversationID, profileID:profileID, messageID:messageID},
                cache:false
            });
        }
    }
    //we will add more features for post(s) later over here, follow the input 'typeOfAction'
}

function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
//mặc định reload sau khi load trang mỗi 5s
// window.onload = timedRefresh(5000);