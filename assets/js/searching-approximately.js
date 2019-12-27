function SearchingFunc2() {
    var input, filter, ul, li1, li, a, i, txtValue;
    input = document.getElementById("myInput2");
    filter = input.value.toUpperCase();
    if(filter!='')
    {
        myUL2.style.display = "block";
    }
    else
    {
        myUL2.style.display = "block";
    }
    ul = document.getElementById("myUL2");
    li = ul.getElementsByTagName("li");
    
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "block";           
        } else {
            li[i].style.display = "none";
        }
    }
}

function SearchingFunc1() {
    var input, filter, ul, li1, li, a, i, txtValue;
    input = document.getElementById("myInput1");
    filter = input.value.toUpperCase();
    if(filter!='')
    {
        myUL1.style.display = "none";
    }
    else
    {
        myUL1.style.display = "block";
    }
    ul = document.getElementById("myUL1");
    li = ul.getElementsByTagName("li");
    
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "block";           
        } else {
            li[i].style.display = "none";
        }
    }
}