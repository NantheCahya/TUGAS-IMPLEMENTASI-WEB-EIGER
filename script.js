
$(document).ready(function(){

  // Fokus input → highlight
  $("input, textarea").focus(function(){
    $(this).css("border", "2px solid #d62828");
  }).blur(function(){
    $(this).css("border", "1px solid #ccc");
  });

  // Validasi checkout
  $("form").submit(function(){
    if ($(this).find("input[name='doCheckout']").length) {
      let telepon = $("input[name='telepon']").val();
      let catatan = $("textarea[name='catatan']").val();

      if(telepon && telepon.length < 10){
        alert("Nomor telepon minimal 10 digit!");
        return false;
      }
      if(catatan && catatan.length < 10){
        alert("Catatan minimal 10 karakter!");
        return false;
      }
    }
    return true;
  });

  // Pilihan warna interaktif
  $(".pilihan-warna button").on("click", function(){
    $(".pilihan-warna button").css({
      "background-color": "black",
      "color": "white"
    });

    let warna = $(this).data("color");

    $(this).css({
      "background-color": warna,
      "color": (warna === "yellow") ? "black" : "white"
    });

    $("#warnaDipilih").text("Warna yang dipilih: " + $(this).text());
    $("#inputWarna").val($(this).text());
  });

});
