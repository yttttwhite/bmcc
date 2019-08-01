function ShowDIV(thisObjID) {
$("#BgDiv").css({ display: "block", height: $(document).height() });
var yscroll = document.documentElement.scrollTop;
//$("#" + thisObjID).css("top", "100px");
$("#" + thisObjID).css("display", "block");
//document.documentElement.scrollTop = 0;
}

function closeDiv(thisObjID) {
$("#BgDiv").css("display", "none");
$("#" + thisObjID).css("display", "none");
}
