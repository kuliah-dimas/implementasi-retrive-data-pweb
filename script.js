const insertDataComment = async (comment) => {
  try {
    const response = await fetch("comments/", {
      method: "POST",
      body: `comment=${comment}`,
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });

    const data = await response.json();
    if (data?.data?.id && data?.data?.uraian_komentar) {
      $(".section_comments").append(
        `<div>${data.data.id}: ${data.data.uraian_komentar}</div>`
      );
      $("#comment").val(""); 
      alert("Berhasil tambah data!");
    }
  } catch (error) {
    console.error("Error inserting comment:", error);
  }
};

const fetchDataComment = async () => {
  try {
    const response = await fetch("comments/");
    return await response.json();
  } catch (error) {
    console.error("Error fetching comments:", error);
    return [];
  }
};

const displayComments = (comments) => {
  if (comments.length > 0) {
    const commentElements = comments.map(
      (comment) => `<div key="${comment.id}">${comment.id}: ${comment.uraian_komentar}</div>`
    );
    $(".section_comments").append(commentElements.join(''));
  }
};

const handleSendComment = async () => {
  const comment = $("#comment").val().trim();

  if (!comment) {
    alert("Komentar tidak boleh kosong!");
    return;
  }

  const $btnSend = $("#btn_send_comment");
  $btnSend.prop("disabled", true).html("Loading...");

  await insertDataComment(comment);

  $btnSend.prop("disabled", false).html("Kirim Komentar");
};

$(document).ready(async function () {
  const existingComments = await fetchDataComment();
  displayComments(existingComments);
  $("#btn_send_comment").click(handleSendComment);
});
