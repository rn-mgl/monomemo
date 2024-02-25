jQuery(function () {
  $("#plus-button").on("click", function () {
    this.animate({ rotate: "90deg" }, 200);
    $(this).toggleClass("add-button-selected");
    $(".file-button").each(function (index, $button) {
      $(this).slideToggle((index + 1) * 50);
    });
  });

  $("#note-button").on("click", function () {
    $(".file-form-container, #create-note-form").fadeIn(100).css({
      display: "flex",
      "align-items": "center",
      "justify-content": "center",
    });
  });

  $("#folder-button").on("click", function () {
    $(".file-form-container, #create-folder-form").fadeIn(100).css({
      display: "flex",
      "align-items": "center",
      "justify-content": "center",
    });
  });

  $(".create-file-form-close-button").on("click", function () {
    $(".file-form-container, .create-file-form").fadeOut(100);
  });

  $("#create-note-form").on("submit", function (e) {
    e.preventDefault();
    const $noteData = $(this).serializeArray();
    const mappedNoteData = { type: "new_note" };
    jQuery.map($noteData, function (data, index) {
      mappedNoteData[data.name] = data.value;
    });
    createNote(mappedNoteData);
  });

  $("#create-folder-form").on("submit", function (e) {
    e.preventDefault();
    const $folderData = $(this).serializeArray();
    const mappedFolderData = { type: "new_folder" };
    jQuery.map($folderData, function (data, index) {
      mappedFolderData[data.name] = data.value;
    });
    createFolders(mappedFolderData);
  });

  $(".file-container").on("click", ".delete-file-button", function () {
    const fileType = $(this).attr("fileType");
    const fileUUID = $(this).attr("fileUUID");

    $(".delete-form-container").fadeIn(100).css({
      display: "flex",
      "align-items": "center",
      "justify-content": "center",
    });

    $("#decline-delete").on("click", function () {
      $(".delete-form-container").fadeOut(100);
    });

    $("#confirm-delete").on("click", function () {
      switch (fileType) {
        case "note":
          deleteNote(fileUUID);
          getFiles();
          $(".delete-form-container").fadeOut(100);
          return;
        case "folder":
          deleteFolder(fileUUID);
          getFiles();
          $(".delete-form-container").fadeOut(100);
          return;
        default:
          return;
      }
    });
  });

  getFiles();
});

function createNote(noteData) {
  $.ajax({
    type: "POST",
    url: "/server/routers/monomemo/note.route.php",
    data: noteData,
    dataType: "json",
    success: function (response) {
      getFiles();
      $(".file-form-container, .create-file-form").fadeOut(100);
    },
  });
}

function createFolders(folderData) {
  $.ajax({
    type: "POST",
    url: "/server/routers/monomemo/folder.route.php",
    data: folderData,
    dataType: "json",
    success: function (response) {
      getFiles();
      $(".file-form-container, .create-file-form").fadeOut(100);
    },
  });
}

function getFiles() {
  $.ajax({
    type: "GET",
    url: "/server/routers/monomemo/home.route.php",
    dataType: "json",
    success: function (response) {
      const mappedFiles = response.map((fileData, index) => {
        return fileData.type === "note"
          ? `<div class="note-card-container">
                    <a class="note-card-link" 
                        href="/client/pages/monomemo/note.php?note_uuid=${
                          fileData.uuid
                        }">
                        <p class="note-card-title">${
                          fileData.title ? fileData.title : ""
                        }</p>
                        <p class="note-card-content">${
                          fileData.content ? fileData.content : ""
                        }</p>
                    </a>
                    <div class="file-card-action-buttons-container">  
                        <button class="delete-file-button" fileType="note" fileUUID="${
                          fileData.uuid
                        }">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        <button class="move-file-button" fileType="note" fileUUID="${
                          fileData.uuid
                        }">
                            <i class="fa-solid fa-arrows-turn-to-dots"></i>
                        </button>
                    </div>
                </div>`
          : `<div class="folder-card-container" >
                    <a class="folder-card-link" 
                        href="/client/pages/monomemo/folder.php?folder_uuid=${
                          fileData.uuid
                        }">
                        <p class="folder-card-title">${
                          fileData.title ? fileData.title : ""
                        }</p>
                    </a>
                    <div class="file-card-action-buttons-container">  
                        <button class="delete-file-button" fileType="folder" fileUUID="${
                          fileData.uuid
                        }">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        <button class="move-file-button" fileType="folder" fileUUID="${
                          fileData.uuid
                        }">
                            <i class="fa-solid fa-arrows-turn-to-dots"></i>
                        </button>
                    </div>
                </div>`;
      });
      $(".file-container").html(mappedFiles);
    },
    error: function (re) {
      console.log(re);
    },
  });
}

function deleteNote(noteUUID) {
  $.ajax({
    type: "POST",
    url: `/server/routers/monomemo/note.route.php?note_uuid=${noteUUID}`,
    data: { type: "delete_note" },
    dataType: "json",
    success: function (response) {
      console.log("note deleted");
    },
  });
}

function deleteFolder(folderUUID) {
  $.ajax({
    type: "POST",
    url: `/server/routers/monomemo/folder.route.php?folder_uuid=${folderUUID}`,
    data: { type: "delete_folder" },
    dataType: "json",
    success: function (response) {
      console.log(response);
    },
    error: function (response) {
      console.log(response);
    },
  });
}
