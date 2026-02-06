/**
 * Frontend related javascript.
 */

"use strict";

(function ($, tgwc) {
	/**
	 * Initialize the avatar image upload dropzone.
	 */
	Dropzone.autoDiscover = false;
	var $dropzone = $("#tgwc-file-drop-zone");
	var acceptedFiles = Object.values(
		window.tgwc_public.acceptFilesForProfile
	).join(", ");
	$dropzone.dropzone({
		maxFilesize: tgwc.avatarUploadSize,
		maxFiles: 1,
		thumbnailWidth: tgwc.avatarImageSize.width,
		thumbnailHeight: tgwc.avatarImageSize.height,
		clickable: ".tgwc-user-avatar-upload-icon",
		acceptedFiles: acceptedFiles,
		dictDefaultMessage: "",
		timeout: 30000,
		previewTemplate: "",
		addedfile: function () {}, // Removing this callback, results in console error.
		thumbnail: function (file, dataURL) {
			if (file.status === "error") {
				return;
			}
			$(this.element).find("img").attr("src", dataURL);
		},
		sending: function (file, xhr, formData) {
			formData.append("previous_attach_id", tgwc.previousAttachId);
			$(this.element)
				.find(".tgwc-progress")
				.addClass("tgwc-progress--loading")
				.removeClass("tgwc-display-none");
			$(this.element).find(".tgwc-remove-image").css("display", "none");
		},
		error: function (file, errorMessage, xhr) {
			$(this.element).find(".tgwc-progress").html(errorMessage.data);
		},
		complete: function (file) {
			$(this.element)
				.find(".tgwc-progress")
				.removeClass("tgwc-progress--loading")
				.addClass("tgwc-display-none");
			this.removeFile(file);
			if ("error" === file.status && false === file.accepted) {
				$(document)
					.find(".tgwc-profile-upload-limit-issue")
					.removeClass("tgwc-hide");
			}
		},
		success: function (file, xhr) {
			var $container = $(this.element).find(
				".tgwc-user-avatar-image-wrap"
			);
			var imgUrl = xhr.data.image_url;

			var newImg = new Image();
			newImg.src = imgUrl + "?t=" + Date.now(); // Cache busting
			newImg.alt = "";
			newImg.className = "avatar avatar-96 photo";
			newImg.width = 96;
			newImg.height = 96;

			newImg.onload = function () {
				$container.find("img").remove();

				$container.prepend(newImg);

				tgwc.previousAttachId = xhr.data.attach_id;
				$container.find(".tgwc-remove-image").css("display", "block");
			};

			newImg.onerror = function () {
				console.error("Failed to load image:", imgUrl);
			};
			$(document)
				.find(".tgwc-profile-upload-limit-issue")
				.addClass("tgwc-hide");
		},
	});

	/**
	 * Handle avatar image deletion.
	 */
	$dropzone.on("click", ".tgwc-remove-image", function (e) {
		e.preventDefault();

		var avatarUploadDropZone = Dropzone.forElement(
			"#" + $dropzone.attr("id")
		);
		avatarUploadDropZone.removeAllFiles(true);

		// Remove the previous image file.
		$.ajax({
			method: "post",
			url: tgwc.ajaxURL,
			data: {
				action: "tgwc_avatar_remove",
				previous_attach_id: tgwc.previousAttachId,
				tgwc_avatar_upload_nonce: $dropzone
					.find('input[name="tgwc_avatar_upload_nonce"]')
					.val(),
			},
			beforeSend: function (xhr) {
				$dropzone
					.find(".tgwc-progress")
					.addClass("tgwc-progress--loading")
					.removeClass("tgwc-display-none");
			},
		})
			.done(function (data) {
				$dropzone
					.find(".tgwc-user-avatar-image-wrap")
					.find("img")
					.remove();

				$dropzone.find(".tgwc-user-avatar-image-wrap").prepend(
					'<img src="' +
						tgwc.gravatarImage +
						"?t=" +
						Date.now() + // Cache busting
						'" alt="Default Avatar" class="avatar avatar-96 photo" height="96" width="96" />'
				);
				$(document)
					.find(".tgwc-profile-upload-limit-issue")
					.addClass("tgwc-hide");
			})
			.always(function () {
				$dropzone
					.find(".tgwc-progress")
					.removeClass("tgwc-progress--loading")
					.addClass("tgwc-display-none");
				$dropzone.find(".tgwc-remove-image").hide();
			});
	});

	/**
	 * Scrollable tab init.
	 */
	var $nav = $(".tgwc-woocommerce-MyAccount-navigation"),
		$ul = $nav.find("ul");

	/**
	 * Handle hover on sub menu item.
	 */
	// $("li.woocommerce-MyAccount-navigation-link").on("mouseover", function () {
	// 	var $navItem = $(this),
	// 		$submenuWrap = $("> ul", $navItem);

	// 	// grab the menu item's position relative to its positioned parent
	// 	var navItemPos = $navItem.position();

	// 	// place the submenu in the correct position relevant to the menu item
	// 	$submenuWrap.css({
	// 		left: navItemPos.left,
	// 	});
	// });

	/**
	 * Handle toggle of group menu item.
	 */
	$(".tgwc-group > a").on("click", function (e) {
		e.preventDefault();
		if ("tab" !== tgwc.menuStyle) {
			var $this = $(this),
				$plus =
					"<svg class='tgwc-icon tgwc-icon--chevron-right' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'><path fill='currentColor' d='M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z' /></svg>",
				$minus =
					"<svg class='tgwc-icon tgwc-icon--chevron-down' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'><path fill='currentColor' d='M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z' /></svg>";

			$this.next().slideToggle("fast", function () {
				if ($(this).is(":hidden")) {
					$this.find("> svg").replaceWith($plus);
					$this.parent("li").attr("data-collapsed", true);
				} else {
					$this.find("> svg").replaceWith($minus);
					$this.parent("li").attr("data-collapsed", false);
				}
			});
		}
	});
})(jQuery, window.tgwc);
