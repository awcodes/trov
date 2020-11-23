window.addEventListener("load", function() {
  window.insertMedia = false;
  window.ml = cloudinary.createMediaLibrary(
    {
      cloud_name: "tmxfoc",
      api_key: "183911495674986",
      username: "adam.weston@titlemax.com",
      default_transformations: [[{ quality: "auto" }, { fetch_format: "auto" }]],
    },
    {
      insertHandler: function(data) {
        if (window.insertMedia) {
          data.assets.forEach((asset) => {
            // console.log(JSON.stringify(asset, null, 2));
            if (asset.resource_type === "image") {
              var alt = ((asset.context || {}).custom || {}).alt;
              if (asset.derived.length) {
                tinymce.activeEditor.insertContent(`<img src="${asset.derived[0].secure_url}" alt="${alt}" />`);
              }
            }
          });
          window.insertMedia = false;
        }
      },
    }
  );

  document.querySelectorAll(".media-manager").forEach((item) => {
    item.addEventListener("click", () => {
      window.ml.show({ folder: { path: "tmxfinancefamily" } });
    });
  });
});
