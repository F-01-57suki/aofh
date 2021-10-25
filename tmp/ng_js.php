<script>
//右クリックWクリックドラッグ禁止
function ngevent(){
  event.preventDefault();
}
window.oncontextmenu=ngevent;
window.ondblclick=ngevent;
window.onmousedown=function(){
  window.onmousemove=ngevent;
}
</script>