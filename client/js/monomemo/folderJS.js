jQuery(function () {
  const params = new URLSearchParams(window.location.search);
  if (!params.has("folder_uuid")) {
    window.location.href = "/client/pages/monomemo/home.php";
  }
  const folderUUID = params.get("folder_uuid");

  $(".folder-data-container").on("input", "#single-folder-name", function (e) {
    setTimeout(() => {
      const folderTitle = $("#single-folder-name").val();
      updateFolder(folderUUID, folderTitle);
    }, [400]);
  });

  $(".folder-data-container").on("click", "#delete-folder-button", function () {
    $(".delete-folder-form-container").fadeIn(100).css({
      display: "flex",
      "align-items": "center",
      "justify-content": "center",
    });
  });

  $("#decline-folder-delete").on("click", function () {
    $(".delete-folder-form-container").fadeOut(100);
  });

  $("#confirm-folder-delete").on("click", function () {
    $.ajax({
      type: "POST",
      url: `/server/routers/monomemo/folder.route.php?folder_uuid=${folderUUID}`,
      data: { type: "delete_folder" },
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response?.folder_from) {
          window.location.href = `/client/pages/monomemo/folder.php?folder_uuid=${response.folder_from}`;
        } else {
          window.location.href = "/client/pages/monomemo/home.php";
        }
      },
    });
  });

  $("#folder-plus-button").on("click", function () {
    this.animate({ rotate: "90deg" }, 200);
    $(this).toggleClass("add-button-selected");
    $(".file-button").each(function (index, $button) {
      $(this).slideToggle((index + 1) * 50);
    });
  });

  $("#folder-note-button").on("click", function () {
    $(".folder-file-form-container, #folder-create-note-form").fadeIn(100).css({
      display: "flex",
      "align-items": "center",
      "justify-content": "center",
    });
  });

  $("#folder-folder-button").on("click", function () {
    $(".folder-file-form-container, #folder-create-folder-form")
      .fadeIn(100)
      .css({
        display: "flex",
        "align-items": "center",
        "justify-content": "center",
      });
  });

  $(".folder-create-file-form-close-button").on("click", function () {
    $(".folder-file-form-container, .folder-create-file-form").fadeOut(100);
  });

  $("#folder-create-note-form").on("submit", function (e) {
    e.preventDefault();
    const $noteData = $(this).serializeArray();
    const mappedNoteData = { type: "new_folder_note", folderUUID };
    jQuery.map($noteData, function (data, index) {
      mappedNoteData[data.name] = data.value;
    });
    createNote(mappedNoteData);
    getFiles(folderUUID);
  });

  $("#folder-create-folder-form").on("submit", function (e) {
    e.preventDefault();
    const folderData = $(this).serializeArray();
    const mappedFolderData = { type: "new_folder_folder", folderUUID };
    jQuery.map(folderData, function (data, index) {
      mappedFolderData[data.name] = data.value;
    });
    createFolder(mappedFolderData);
    getFiles(folderUUID);
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
          getFiles(folderUUID);
          $(".delete-form-container").fadeOut(100);
          return;
        case "folder":
          deleteFolder(fileUUID);
          getFiles(folderUUID);
          $(".delete-form-container").fadeOut(100);
          return;
        default:
          return;
      }
    });
  });

  $(".folder-data-container").on("click", "#move-folder-button", function () {
    $(".move-folder-container").fadeIn(100).css({
      display: "flex",
      "align-items": "center",
      "justify-content": "center",
    });
    getFolderPaths(folderUUID);
  });

  $(".folder-file-paths").on("click", ".path-button", function () {
    const path = $(this).attr("path");
    moveFolder(path, folderUUID);
  });

  $(".close-move-folder-form-button").on("click", function () {
    $(".move-folder-container").fadeOut(100);
  });

  getFiles(folderUUID);
});

function getFiles(folderUUID) {
  $.ajax({
    type: "GET",
    url: `/server/routers/monomemo/folder.route.php?folder_uuid=${folderUUID}`,
    data: { type: "single_folder" },
    dataType: "json",
    success: function (response) {
      const { files, folder_data } = response;
      const mappedFiles = files.map((fileData, index) => {
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

      const folderData = `
            <div class="folder-action-buttons-container">
                <a href=${
                  folder_data.folder_from
                    ? `/client/pages/monomemo/folder.php?folder_uuid=${folder_data.folder_uuid}`
                    : "/client/pages/monomemo/folder.php"
                } >
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <button id="delete-folder-button">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
                <button id="move-folder-button">
                    <i class="fa-solid fa-arrows-turn-to-dots"></i>
                </button>
            </div>
            <textarea id="single-folder-name" placeholder="No Title">${
              folder_data.folder_name
            }</textarea>`;

      $(".folder-data-container").html(folderData);
      $(".file-container").html(mappedFiles);
    },
    error: function (response) {
      console.log(response);
    },
  });
}

function updateFolder(folderUUID, folderTitle) {
  $.ajax({
    type: "POST",
    url: `/server/routers/monomemo/folder.route.php?folder_uuid=${folderUUID}`,
    data: { type: "update_folder", folderTitle },
    dataType: "json",
    success: function (response) {
      console.log(response);
    },
  });
}

function createNote(noteData) {
  $.ajax({
    type: "POST",
    url: "/server/routers/monomemo/note.route.php",
    data: noteData,
    dataType: "json",
    success: function (response) {
      $(".folder-file-form-container, .folder-create-file-form").fadeOut(100);
    },
    error: function (response) {
      console.log(response);
    },
  });
}

function createFolder(folderData) {
  $.ajax({
    type: "POST",
    url: "/server/routers/monomemo/folder.route.php",
    data: folderData,
    dataType: "json",
    success: function (response) {
      $(".folder-file-form-container, .folder-create-file-form").fadeOut(100);
    },
    error: function (response) {
      console.log(response);
    },
  });
}

function deleteNote(noteUUID) {
  $.ajax({
    type: "POST",
    data: { type: "delete_note" },
    url: `/server/routers/monomemo/note.route.php?note_uuid=${noteUUID}`,
    dataType: "json",
    success: function (response) {
      console.log("note deleted");
    },
  });
}

function deleteFolder(folderUUID) {
  $.ajax({
    type: "POST",
    data: { type: "delete_folder" },
    url: `/server/routers/monomemo/folder.route.php?folder_uuid=${folderUUID}`,
    dataType: "json",
    success: function (response) {
      console.log("folder deleted");
    },
  });
}

function getFolderPaths(folderUUID) {
  $.ajax({
    type: "GET",
    url: `/server/routers/monomemo/move.route.php?folder_uuid=${folderUUID}`,
    data: { type: "folder_path" },
    dataType: "json",
    success: function (response) {
      const mappedPaths = response.map((data, index) => {
        return `<button class="path-button" path="${data.folder_uuid}">
                            ${data.folder_name} <i class="fa-solid fa-folder-open"></i>
                        </button>`;
      });

      mappedPaths.splice(
        0,
        0,
        `<button class="path-button" path>
                                        Home <i class="fa-solid fa-folder-open"></i>
                                    </button>`
      );

      $(".folder-file-paths").html(mappedPaths);
    },
  });
}

function moveFolder(path, folderUUID) {
  $.ajax({
    type: "POST",
    url: `/server/routers/monomemo/move.route.php?folder_uuid=${folderUUID}`,
    data: { type: "move_folder", path },
    dataType: "json",
    success: function (response) {
      if (response?.new_path) {
        window.location.href = `/client/pages/monomemo/folder.php?folder_uuid=${response?.new_path}`;
      } else {
        window.location.href = "/client/pages/monomemo/home.php";
      }
    },
    error: function (response) {
      console.log(response);
    },
  });
}
