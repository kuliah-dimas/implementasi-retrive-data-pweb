const insertDataComment = async (comment) => {
  try {
    const response = await fetch("http://localhost:8080/comments/", {
      body: `comment=${comment}`,
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      method: "post",
    });

    const data = await response.json();

    const $sectionComment = $(".section_comments");
    $sectionComment.append(
      `<div>${data.data.id}: ${data.data.uraian_komentar}`
    );

    $("#comment").val("");

    alert("Berhasil tambah data!");
  } catch (e) {
    console.log(e);
  }
};

const fetchDataComment = async () => {
  try {
    const response = await fetch("http://localhost:8080/comments/");
    const data = await response.json();
    return data;
  } catch (e) {
    return null;
  }
};

$(document).ready(function () {
  $("#btn_send_comment").click(function () {
    const comment = $("#comment").val();

    if (comment == "") {
      alert("Komentar tidak boleh kosong!");
      return;
    }

    $(this).html("Loading...");
    $(this).prop("disabled", true);

    insertDataComment(comment);

    setTimeout(() => {
      $(this).prop("disabled", false);
      $(this).html("Kirim Komentar");
    }, 1000);
  });
});

$(document).ready(function () {
  fetchDataComment().then((value) => {
    const $sectionComment = $(".section_comments");
    value.map((v) => {
      $sectionComment.append(
        `<div key="${v.id}">${v.id}: ${v.uraian_komentar}</div>`
      );
    });
  });
});
