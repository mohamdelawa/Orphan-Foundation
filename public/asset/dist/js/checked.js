function checkAll(){
    var checkAll = document.getElementById("checkAll").checked;
    const items = document.getElementsByClassName("item");
    for (let i = 0; i < items.length; i++) {
        if(checkAll){
            items[i].checked=true;
        }else{
            items[i].checked=false;
        }
    }
}
