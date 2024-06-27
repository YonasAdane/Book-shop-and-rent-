function busTypeEditor(event){
    console.log(event.parentElement.parentElement);
    let tr=event.parentElement.parentElement;
    let BusCategoryID=tr.getAttribute("id");
    let BusName=tr.childNodes[1].firstChild.nodeValue;
    let BusSeatNumbers=tr.childNodes[3].firstChild.nodeValue;
    let BusCategory=tr.childNodes[5].firstChild.nodeValue;
    let BusLevel=tr.childNodes[7].firstChild.nodeValue;
    let popover=document.getElementById("edit");
    popover.classList.remove("hidden");
    document.getElementById("BusName").setAttribute("placeholder",BusName);
    document.getElementById("BusSeatNumbers").setAttribute("placeholder",BusSeatNumbers);
    document.getElementById("BusCategory").setAttribute("placeholder",BusCategory);
    document.getElementById("BusLevel").setAttribute("placeholder",BusLevel);
    document.getElementById("BusCategoryID").setAttribute("value",BusCategoryID);
    
}
const po=document.getElementById("edit");
function closePopover(){
    let popover=document.getElementById("edit");
    popover.classList.add("hidden");
}