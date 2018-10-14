document.addEventListener("DOMContentLoaded", init);

function init() {
    document.forms[0].addEventListener("submit", (e) => {
        e.preventDefault();
        var content = document.querySelector("#content");
        url = "index.php";
        var formData = new FormData(e.target);
        formData.append('submit', "ok");

        xhr = new XMLHttpRequest();
        xhr.open('POST', url);

        content.innerHTML = getProgressBarIndeterminate();

        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                content.innerHTML = xhr.response;
            }
        }
        xhr.send(formData);
    });

    function getProgressBarIndeterminate() {
        return `<div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                </div>`;
    }
}
