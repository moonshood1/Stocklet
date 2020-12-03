// fonction de like
function onClickBtnLike(event) {
  event.preventDefault();

  const url = this.href;
  const spanLikesCount = this.querySelector("span.js-likes");
  const icone = this.querySelector("i");

  axios
    .get(url)
    .then(function (response) {
      spanLikesCount.textContent = response.data.likes;

      if (icone.classList.contains("fas")) {
        icone.classList.replace("fas", "far");
      } else {
        icone.classList.replace("far", "fas");
      }
    })
    .catch(function (error) {
      if (error.response.status === 403) {
        window.alert(
          "Vous ne pouvez pas liker un commentaire sans etre connecté"
        );
      } else {
        window.alert("Reessayez plus tard , une erreur s'est produite");
      }
    });
}

// fonction de dislike
function onClickBtnDisLike(event) {
  event.preventDefault();

  const url = this.href;
  const spandisLikesCount = this.querySelector("span.js-dislikes");
  const icone = this.querySelector("i");

  axios
    .get(url)
    .then(function (response) {
      spandisLikesCount.textContent = response.data.dislikes;

      if (icone.classList.contains("fas")) {
        icone.classList.replace("fas", "far");
      } else {
        icone.classList.replace("far", "fas");
      }
    })
    .catch(function (error) {
      if (error.response.status === 403) {
        window.alert(
          "Vous ne pouvez pas disliker un commentaire sans etre connecté"
        );
      } else {
        window.alert("Reessayez plus tard , une erreur s'est produite");
      }
    });
}
// Selection de tous les a avec la class js-like
document.querySelectorAll("a.js-like").forEach(function (link) {
  link.addEventListener("click", onClickBtnLike);
});

// selection de tous les dislikes avec la class js-dislike
document.querySelectorAll("a.js-dislike").forEach(function (link) {
  link.addEventListener("click", onClickBtnDisLike);
});
